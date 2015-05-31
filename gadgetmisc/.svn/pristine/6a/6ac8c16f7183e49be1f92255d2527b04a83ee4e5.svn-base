// cookie operation
function parseCookies() {
  var strarr = document.cookie.split(/\s*;\s*/);
  var cookies = {};
  var tag = false;
  for (var j = 0; j < strarr.length; j++) {
    var pair = strarr[j].split(/\s*=\s*/);
    if (pair[0].indexOf(COOKIE_RES_PREFIX) == 0) {
      tag = true;
      cookies[pair[0]] = pair[1];
    }
  }
  return tag ? cookies : null;
}

function setCookie(name, value, hours, path, domain) {
   var expires = new Date();
   expires.setTime(expires.getTime() + 3600000 * hours);
   var valueStr = escape(JSON.stringify(value));
   document.cookie = [name, '=', valueStr,
                      (expires ? '; expires=' + expires.toGMTString() : ''),
                      (path ? '; path=' + path : '/'),
                      (domain ? '; domain=' + domain : '')].join('');
}

function getCookie(name) {
  var search = name + '=';
  if (document.cookie.length > 0) {
    offset = document.cookie.indexOf(search);
    if (offset != -1) {
      offset += search.length;
      end = document.cookie.indexOf(';', offset);
      if (end == -1) {
        end = document.cookie.length;
      }
      return unescape(document.cookie.substring(offset, end));
    }
  }
  return '';
}

function delCookie(name, path, domain) {
  var expires = new Date();
  expires.setTime(0);
  document.cookie = [name, '=:',
                     '; expires=' + expires.toGMTString(),
                     (path ? '; path=' + path : '/'),
                     (domain ? '; domain=' + domain : '')].join('');
}

function showCookie() {
  document.getElementById('debug').innerHTML = document.cookie;
}

function clearCookie() {
  if (0 < document.cookie.length) {
    var cookies = strToArr(document.cookie);
    for (var k in cookies) {
      delCookie(k);
    }
  }
  refreshRight();
}


var COOKIE_RES_PREFIX = '__res_';

function _gel(elem_id) {
  return (document.getElementById) ? document.getElementById(elem_id) : document.all[elem_id];
}

function getTagStr(str, tagname) {
  var idx = str.indexOf('<' + tagname);
  if (-1 == idx) {
    return '';
  }
  var idx2 = str.indexOf('/>', idx);
  if (-1 == idx2) {
    idx2 =str.indexOf('</' + tagname + '>', idx);
  }

  var newstr = '';
  return str.substr(idx, idx2 + tagname.length + 3);
}

function getTag(tagname, tagid) {
  var obj = document.getElementById(tagid);
  return getTagStr(obj.parentNode.innerHTML, tagname);
}

function strToArr(inputstr) {
  var strarr = inputstr.split(';');
  var arr = new Array;
  for (var j = 0; j < strarr.length; j++) {
    var pair = strarr[j].split('=');
    arr[pair[0]] = pair[1];
  }
  return arr;
}

function arrToStr(inputarr) {
  var arr = new Array;
  for (var k in inputarr) {
    arr.push(k + '=' + inputarr[k]);
  }
  var d = arr.join(';');
  alert('1:\n' + d);
  return d;
}

function refreshRight(){
  var resclone = _gel('resclone');
  resclone.innerHTML = '';
  if (0 < document.cookie.length) {
    var cookies = strToArr(document.cookie);
    for (var k in cookies) {
      var cookieName = k.replace(' ', '');
      var cookieValue = cookies[k].replace(' ', '');
      if (cookieValue.indexOf('%3Ca%20') == -1) {
        continue;
      }
      var li = document.createElement('li');
      li.className = 'clone_res_li';
      li.innerHTML = '[<a title="a" onclick="delCookie(\'' + cookieName + '\');renderBaskets()">--</a>] ' + unescape(cookieValue);
      li.getElementsByTagName('a')[0].id = cookieName;
      resclone.appendChild(li);
    }
  }
}


function addToRight(obj) {
  var p = obj.parentNode.parentNode.parentNode;
  var res_id = p.getElementsByTagName('a')[0].id;

  var clone_id = COOKIE_RES_PREFIX + res_id;
  var elemclone = _gel(clone_id);
  if (elemclone) {
    alert(['您好，您已经添加过这条搜索结果了！',
           'hi, you have added already this search result!'].join('\n'));
    return;
  }
  var str = getTag('a', res_id);
  setCookie(clone_id, str, 3600 * 24);
  refreshRight();
}

function removeOnRight(elem_id) {
  var elem = _gel(elem_id).parentNode;
  var parent = elem.parentNode;
  parent.removeChild(elem);
}

function showInformation() {
  var query = _gel('inputquery').value;
  if (query.length < 1) {
    alert(['请输入关键词，',
           '或者用鼠标拖拽左侧词汇到这个搜索框里',
           'hi, friend, please input query here, ',
           'or you can drag some term in left to this search box!'].join('\n'));
    return;
  }
  var info = ['左侧结果将会更新，显示新输入的query[' + query + ']搜索结果，',
              '下侧您的搜索成果将保持不变',
              'the left side of results will be freshed by the new input query [' + query + '], ',
              'your record-results below will not be changed!'].join('\n');
  alert(info);
}

function onRHSKeyDown(e) {
  var key = 0;
  if (window.event) {
    key = e.keyCode;
  } else if (e.which) {
    key = e.which;
  }
  switch (parseInt(key, 10)) {
  case 13:
    showInformation();
    break;
  }
}

function onRHSSearch() {
  showInformation();
}

function onRHSReport() {
  createMask();
  return;

  if (_gel('resclone').innerHTML.length < 10) {
    alert(['不好意思, 您还没有添加您的搜索成果，请按[+]按钮，谢谢！',
           'Sorry, you have not added your result, please press [+] button, thanks!'].join('\n'));
    return;
  }
  var info = ['恭喜恭喜，您完成了本次demo的最后一步，',
              '请输入邮箱地址，谷歌将会把如下您的搜索成果发送到您的邮箱！',
              'Congratulations, you are the hero who achieved the last step of this demo, ',
              'please input your email, Google will send your results to your email now!',
              '',
              '                                                    --Lenjoy'].join('\n');
  alert(info);
}

// main function
if (!LOADED) {
  var LOADED = true;
  var dragOption = {
    helper: 'clone',
    opacity: 0.35,
    revert: 'invalid',
  };
  var dropOption = {
    activeClass: 'active-panel',
    hoverClass: 'hover-panel',
    tolerance: 'pointer',
    drop: function(event, ui) {
      onDrop(ui.draggable);
    }
  };

  var onDrop = function(draggable) {
    /* search box */
    var q = $('#tsf input.lst').val();
    var newSite = new Site(q, draggable);
    var basket = Basket.get(q);

    /* change to modify the cookie and re-render the basket? */
    var targetSite = basket.add(newSite);
    setCookie(COOKIE_RES_PREFIX + targetSite.id, targetSite, 24);
    renderBaskets();
  };

  var onStart = function(cookies, droppable) {
    for (var name in cookies) {
      var cookie = unescape(cookies[name]);
      var site = new Site(cookie);
      var basket = Basket.get(site.query);
      var targetSite = basket.add(site);
      renderBaskets();
    }
  };

  var onRemove = function() {
    var h = $(this).data('h');
    var q = $(this).data('q');
    var basket = Basket.get(q);
    var site = basket.remove(h);

    delCookie(COOKIE_RES_PREFIX + site.id);
    renderBaskets();
  };

  function renderBaskets() {
    var div = $('#resclone');
    /* what's this? */
    div.empty();
    var isEmpty = true;
    for (var q in Basket.all) {
      var newElement = Basket.all[q].render();
      div.append(newElement);
      isEmpty = false;
    }
    if (isEmpty) {
      div.append('<span>将搜索结果拖到此处</span>');
    }
  };

  var Basket = function(query) {
    this.count = 0;
    this.query = query;
    this.sites = {}; /* href, obj */

    this.add = function(site) {
      if (this.sites[site.href]) {
        alert('you have added it!');
      } else {
        this.count++;
        this.sites[site.href] = site;
      }
      return this.sites[site.href];
    };

    this.remove = function(href) {
      var site = this.sites[href];
      if (site) {
        this.count--;
        delete this.sites[href];
      }
      if (this.count <= 0) {
        Basket.destroy(this.query);
      }
      return site;
    };

    this.render = function() {
      var newItem = $('<div class="basket-item"></div>');
      newItem.append('<div>搜索词：<b>' + this.query + '</b></div>');
      for (var url in this.sites) {
        var siteItem = this.sites[url].render();
        newItem.append(siteItem);
      }
      return newItem;
    };
  };

  Basket.all = {};
  Basket.get = function(q) {
    var basket = Basket.all[q];
    if (!basket) {
      basket = new Basket(q);
      Basket.all[q] = basket;
    }
    return basket;
  };

  Basket.destroy = function(q) {
    delete Basket.all[q];
    renderBaskets();
  };

  var Site = function(query, result) {

    if (result) {
      /* initialized from drag and drop. */
      this.query = query;

      if (result.find('h3 > a').length == 0) {
        /* onebox */
        /* TODO add template */
        this.id = new Date().getTime();
        this.href = result.find('td > a').attr('href');
        this.title = result.find('td > a').text();
        this.snippet = $.trim(result.text()).replace(/\s+/g, ' ');
      } else {
        /* normal */
        this.id = result.find('h3 > a').attr('id');
        this.href = result.find('h3 > a').attr('href');
        this.title = result.children('h3').text();
        this.snippet = $.trim(result.children('h3').next().text()).replace(/\s+/g, ' ');
      }
    } else {
      /* initialized from cookie. */
      var cookie = query;
      /* really need? */
      var obj = JSON.parse(cookie);
      this.id = obj.id;
      this.query = obj.query;
      this.href = obj.href;
      this.title = obj.title;
      this.snippet = obj.snippet;
    }

    this.render = function() {
      var newItem = $('<div class="site-item"></div>');
      var delBtn = $('<button class="panel-body-input"></botton>');
      delBtn.data('q', this.query).data('h', this.href).click(onRemove);
      var anchor = $('<a></a>').attr('href', this.href).attr('target', '_blank').attr('title', this.snippet).text(this.title);
      newItem.append(delBtn);
      newItem.append(anchor);
      return newItem;
    };
  };

  var createMask = function() {
    var mask = $('#mask');
    if (mask.length == 0) {
      mask = $('<div id="mask" style="display:none;"></div>');
      $('body').append(mask);
    }
    var w = Math.max(document.documentElement.clientWidth, document.body.offsetWidth);
    var h = Math.max(document.documentElement.clientHeight, document.body.offsetHeight);
    mask.width(w);
    mask.height(h);
    mask.show();

    var emailPanel = $('#emailPanel');
    if (emailPanel.length == 0) {
      emailPanel = $('<div id="emailPanel" class="popup-panel" style="display:none;"></div>');
      emailPanel.append('<div class="popup-panel-shadow"></div>');
      emailPanel.append('<div class="popup-panel-border1"><div class="popup-panel-border2"><div class="popup-panel-content"></div></div></div>');
      $('body').append(emailPanel);
    }

    var emailCnt = emailPanel.find('.popup-panel-content');
    emailCnt.empty();
    emailCnt.append('<p><div class="caption">邮件地址: </div><input id="emailAddress"></p>');
    emailCnt.append('<p><div class="caption">文字描述: </div><textarea id="emailDesc">来看看这些搜索结果吧</textarea></p>');
    emailCnt.append('<p><div class="caption">分享内容: </div><div id="emailBaskets"></div></p>');
    emailCnt.append('<div class="buttons"><button id="emailSubmit">发送</button><button id="emailCancel">取消</button></div>');

    emailPanel.css('left', (w - 810) / 2);
    emailPanel.css('top', 100);
    emailPanel.show();

    emailPanel.find('#emailCancel').click(function() {
        $('#mask').hide();
        $('#emailPanel').hide();
      });

    var baskets = $('#resclone').clone();
    baskets.find('.site-item > span').remove();
    emailPanel.find('#emailBaskets').append(baskets);
  };

  function openAllResults() {
    $('#resclone > div > div > a').each(
        function(index) {
          window.open(this.href, '_blank');
        })
  }

  var results = $('#res > div > ol > li');
  results.draggable(dragOption);
  results.draggable('option', 'cancel', 'div.s');

  var onebox = $('#res .e:first');
  onebox.draggable(dragOption);

  var basketPanel = $('#rhst');
  basketPanel.droppable(dropOption);
  renderBaskets();

  $('#res > div > ol > li').click(function(ev) {
      var $item = $(this);
      var $target = $(ev.target);
      if ($target.is('button.button_add_to_right')) {
        onDrop($item);
      } else if ($target.is('input.gen_report')) {
        createMask();
      }
      return false;
    });

  var BASKETTEXT = '搜索成果';
  var BASKETTITLE = '我是擎天柱，可以把搜索成果存到我的集装箱里去';
  var basketBtn = $('<a title="' + BASKETTITLE + '" class="pre_a">开启' + BASKETTEXT + '</a>');
  basketBtn.click(function() {
      if (basketPanel.css('display') == 'none') {
        basketPanel.slideDown();
        basketBtn.text('关闭' + BASKETTEXT);
      } else {
        basketPanel.slideUp();
        basketBtn.text('开启' + BASKETTEXT);
      }
    });
  /* the bar near toolbelt */
  $('#prs').append(basketBtn);

  var CRAWLINGTEXT = '实时结果';
  var CRAWLINGTITLE = '我是威震天，可以为您侦察网络，提供实时结果';
  var crawlBtn = $('<a title="' + CRAWLINGTITLE + '" class="pre_a">开启' + CRAWLINGTEXT + '</a>');
  crawlBtn.click(function() {
      if (g_crawling_on) {
        crawlBtn.text('开启' + CRAWLINGTEXT);
        g_crawling_on = false;
        $('.realtime_panel').slideUp();
      } else {
        crawlBtn.text('关闭' + CRAWLINGTEXT);
        g_crawling_on = true;
        $('.realtime_panel').slideDown();
        clearTimeout(g_crawling);
        crawling();
      }
    });
  /* the bar near toolbelt */
  $('#prs').append(crawlBtn);

  var rhs_ads_number = parseInt($('#rhs_ads_number').val());
  if (rhs_ads_number <= 3) {
    $(document).ready(function() {
        $(window).scroll(function(){
            if ($(window).scrollTop() >
                $('#ssb').offset({ scroll: false }).top + 33) {
              var left = $('#rhsline').offset({ scroll: false }).left;
              $('#rhsline').css('position', 'fixed');
              $('#rhsline').css('top', '0');
              $('#rhsline').css('left', left);
            } else {
              $('#rhsline').css('position', '');
              $('#rhsline').css('top', $('#ssb').offset);
            }
          });
      });
  }

  var cookies = parseCookies();
  if (cookies != null) {
    onStart(cookies, basketPanel);
    basketPanel.show();
    basketBtn.text('关闭' + BASKETTEXT);
  }
}


// Cached code
function highlightCache(cache_url_id, cache_query_id) {
  var div = document.getElementById(cache_url_id);
  var ifr = div.getElementsByTagName('iframe')[0];
  var ifrsrc = ifr.src;
  var idx = ifrsrc.indexOf('+');
  var idx2 = ifrsrc.indexOf('&');
  ifr.src = [ifrsrc.substr(0, idx + 1),
             encodeURI(document.getElementById(cache_query_id).value),
             ifrsrc.substr(idx2, ifrsrc.length - idx2)].join('');
}

function doKeydown(e, cache_url_id, cache_query_id) {
  var key = 0;
  if (window.event) {
    key = e.keyCode;
  } else if (e.which) {
    key = e.which;
  }
  switch (parseInt(key, 10)) {
  case 13:
    highlightCache(cache_url_id, cache_query_id);
    break;
  }
}

function controlManybox(input_id) {
  var cache_url_id = input_id;
  var cache_query_id = 'query' + input_id;
  var div = document.getElementById(cache_url_id);
  if (div.style.display == 'none') {
    var ifrsrc = div.getElementsByTagName('iframe')[0].src;
    var idx = ifrsrc.indexOf('+');
    var idx2 = ifrsrc.indexOf('&');
    var query = ifrsrc.substr(idx + 1, idx2 - idx - 1).replace(/\+/g, ' ');
    document.getElementById(cache_query_id).value = decodeURI(query);
    div.style.display = 'block';
  } else {
    div.style.display = 'none';
  }
}
