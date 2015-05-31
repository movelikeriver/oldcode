function ajax(opt) {
  var options = {
     type: opt.type || 'POST',
     url: opt.url || '',
     timeout: opt.timeout || 10000,
     onComplete: opt.onComplete || function() {},
     onError: opt.onError || function() {},
     onSuccess: opt.onSuccess || function() {},
     data: opt.data || ''
  };

  if (typeof XMLHttpRequest == 'undefined') {
    XMLHttpRequest = function() {
      return new ActiveXObject(navigator.userAgent.indexOf('MSIE 5') >= 0 ? 'Microsoft.XMLHTTP' : 'Msxml2.XMLHTTP');
    }
  }

  var xml = new XMLHttpRequest();
  xml.open(options.type, options.url, true);
  var timeoutLength = options.timeout;
  var requestDone = false;
  setTimeout(function() {
      requestDone = true;
    }, timeoutLength);

  xml.onreadystatechange = function() {
    if (xml.readyState == 4 && !requestDone) {
      if (httpSuccess(xml)) {
        options.onSuccess(httpData(xml, options.data));
      } else {
        options.onError();
      }
      options.onComplete();
      xml = null;
    }
  };

  xml.send(null);

  function httpSuccess(r) {
    try {
      return (!r.success && location.protocal == 'file:') ||
          (r.status >= 200 && r.status < 300) ||
          r.status == 304 ||
          navigator.userAgent.indexOf('Safari') >= 0 && typeof r.status == 'undefined';
    } catch(e) {
      alert('catch');}
    return false;
  }

  function httpData(r, type) {
    var ct = r.getResponseHeader('content-type');
    var isxml = !type && ct && ct.indexOf('xml') >= 0;
    var data = (type == 'xml' || isxml) ? r.responseXML : r.responseText;
    //var data = r.responseText;
    if (type == 'script') {
      eval.call(window, data);
    }
    return data;
  }
}

var g_index = 0;
var g_url = '/search?num=3&opti=select_corpus:instantlayer&client=google&output=xml&q=aaa';
var g_datatype = 'xml';
var g_val;
var g_results = [];
var g_results_map = {};
var g_results_str = '';
var g_container = document.getElementById('realtime');

var g_crawling;
var g_crawling_on = false;
var g_REALTIME_RES_NUM = 4;
var g_MAX_RESULTS_NUM = 5000;

var g_should_stop = false;

function parseXMLResult(respxml) {
  var res = respxml.getElementsByTagName('R');
  for (var i = 0; i < res.length; i++) {
    var tim = res[i].getElementsByTagName('WEBDISPLAYDATE');
    if (!tim || tim.length==0) {
      continue;
    }
    tim = tim[0].textContent;
    var idx = tim.indexOf('小时');
    if (idx == -1) {
      idx = tim.indexOf('hour');
    }
    if (idx != -1) {
      var hours = parseInt(tim.substr(0, idx));
      if (hours > 20) {
        continue;
      }
    }
    var url = res[i].getElementsByTagName('U')[0].textContent;

    // not really dedupe.
    if (typeof g_results_map[url] != 'undefined' && g_results_map.length < 3) {
      continue;
    }

    g_results_map[url] = true;

    var sni = res[i].getElementsByTagName('S')[0].textContent;
    var tit = res[i].getElementsByTagName('T')[0].textContent;
    sni = sni.replace(/\<b\>/g, '<em>').replace(/\<\/b\>/g, '</em>').replace(/\<br\>/g, '');
    tit = tit.replace(/\<b\>/g, '<em>').replace(/\<\/b\>/g, '</em>');

    g_results.push(['<li class="realtime_li" onmouseover="stopScroll()" onmouseout="startScroll()"><h3 class=r><a href="', url, '">',
                    tit, '</a></h3><div class="s">', sni,
                    '<br><cite>', tim, ' - ', url, '</cite></div></li>'].join(''));
  }
  if (g_results.length <= 0) {
    $('realtime_panel').css('display', 'block');
    $('#realtime').css('height', 20);
    $('#realtime').text('暂无实时结果');
    return;
  }
  clearTimeout(g_val);
  showNextResult();
}

function parseHTMLResult(resphtml) {
  var idx = resphtml.indexOf('<!--m-->');
  if (idx != -1) {
    resphtml = resphtml.substr(idx);
    var pattern = /\<\!\-\-m\-\-\>(.+?)\<\!\-\-n\-\-\>/gm;
    var href_pattern = /href=\"(.+?)\"/;
    var res;
    while ((res = pattern.exec(resphtml)) != null) {
      var url = href_pattern.exec(res[1])[1];
      if (typeof g_results_map[url] != 'undefined') {
        continue;
      }
      g_results_map[url] = true;

      var r = res[1].replace(
          /\<li class\=g\>/g,
          '<li class="realtime_li" onmouseover="stopScroll()" onmouseout="startScroll()">');
      r += '</li>';
      g_results.push(r);
    }
  }
  if (g_results.length <= 0) {
    $('realtime_panel').css('display', 'block');
    $('#realtime').css('height', 20);
    $('#realtime').text('暂无实时结果');
    return;
  }
  clearTimeout(g_val);
  showNextResult();
}

function genHtml(begin, end) {
  var arr = [g_results[end - 1].replace('"realtime_li"', '"realtime_newres" id="realtime_newres"')];
  for (var i = end - 2; i >= begin; i--) {
    arr.push(g_results[i]);
  }
  return arr.join('<br/>');
}

var g_newres_scroll;

function stopScroll() {
  g_should_stop = true;
}

function startScroll() {
  g_should_stop = false;
}

function resScrollDown() {
  var realtime = $('#realtime');
  var realtime_h = parseInt(realtime.css('height').replace('px', ''));
  var newres = $('.realtime_newres');
  var top = parseInt(newres.css('margin-top').replace('px', ''));
  var res_h = parseInt(newres.css('height').replace('px', ''));
  var step = 10;
  if (top >= 0) {
    clearTimeout(g_newres_scroll);
  } else {
    if (g_index < g_REALTIME_RES_NUM) {
      realtime.css('height', realtime_h + step + 'px');
    }
    newres.css('margin-top', top + step + 'px');
    g_newres_scroll = setTimeout('resScrollDown()', 80);
  }
}

function showNextResult() {
  if (g_should_stop) {
    return;
  }
  if (g_index >= g_results.length) {
    clearTimeout(g_val);
  } else {
    if (g_index < g_REALTIME_RES_NUM) {
      g_results_str = genHtml(0, g_index + 1);
    } else {
      g_results_str = genHtml(g_index - g_REALTIME_RES_NUM + 1, g_index + 1);
      //      alert('g_index: ' + g_index + ', g_REALTIME_RES_NUM: ' + g_REALTIME_RES_NUM);
    }
    g_container.innerHTML = g_results_str;
    g_index++;
    if (g_index < g_REALTIME_RES_NUM) {
      var realtime = $('#realtime');
      var realtime_h = parseInt(realtime.css('height').replace('px', ''));
      realtime.css('height', realtime_h + 13 + 'px');
    }
    resScrollDown();
    g_val = setTimeout('showNextResult()', 5000);
  }
}

function doAjax() {
  ajax({
    type: 'GET',
    url: g_url,
    data: g_datatype,
    onSuccess: parseHTMLResult
  });
}

function getUrlParam(para){
  var value = location.search.match(new RegExp('[\?\&]' + para + '=([^\&]*)(\&?)'));
  return value ? value[1] : null;
}

function crawling() {
  if (!g_crawling_on || g_results.length > g_MAX_RESULTS_NUM) {
    clearTimeout(g_crawling);
  } else {
    var q = $('#tsf input.lst').val();
    var hl = getUrlParam('hl');
    if (!hl) {
      hl = 'zh-CN';
    }
    //    g_url = '/search?&hl=' + hl + '&num=100&opti=select_corpus:instantlayer&client=google&output=xml&q=' + q;
    //    g_datatype = 'xml';
    g_url = '/search?&hl=' + hl + '&num=10&tbs=sbd:1,qdr:d&q=' + q;
    g_datatype = 'text';
    doAjax();
    g_crawling = setTimeout('crawling()', 20000);
  }
}
