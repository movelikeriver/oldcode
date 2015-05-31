// Google Result Enhanced
// version 1.0
// 2009-09-26
// Copyright (c) 2009, Lenjoy (mars.lenjoy@gmail.com)
// Released under the GPL license
// http://www.gnu.org/copyleft/gpl.html
//
// --------------------------------------------------------------------
//
// This is a Greasemonkey user script.
//
// To install, you need Greasemonkey Firefox extension : http://greasemonkey.mozdev.org/
// Then restart Firefox and revisit this script.
// Click on install.
//
// --------------------------------------------------------------------
// ==UserScript==
// @name            Transformer
// @namespace       http://userscripts.org/scripts/show/google_result_enhance
// @description     Enhance Google results.
// @include         http://www.google.com/search*
// @include         http://www.google.cn/search*
// ==/UserScript==

/**
 * A frequent used help function to deal with selecting of tags, classname.
 * @parameter { classname : String } #id .classname
 * @return Array
  */
function getTags(classname) {
  var names = classname.split('>');
  var results = new Array();
  for (var name in names) {
    var names2 = name.split(' ');
	// (TODO): need some valid check here.
	var tagname = names2[0];
	var type = names2[1].substr(0, 1);
	var objname = names2[1].substr(1);
	var tags = new Array();
	if (type == '.') {
	  getElementsByClassName(tagname, objname);
	} else if (type == '#') {
	  document.getElementsById(objname);
	}
    alert(n);
  }
}

function getElementsByClassName(root, tag, classname) {
  var elements = root.getElementsByTagName(tag);
  var results = new Array();
  for (var i = 0; i < elements.length; i++) {
    if (elements[i].className.indexOf(classname) > -1) {
      results.push(elements[i]);
	}
  }
  return results;
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

  return str.substr(idx, idx2 + tagname.length + 3);
}

function initAddButton(targetTag) {
  
}

function genSearchBox() {
  var res = document.getElementById('res');
  var rhs = document.createElement('div');
  rhs.id = 'rhs';
  var parent = document.getElementById('cnt');
  parent.insertBefore(rhs, res);
}

function genResultsArea() {
}

function iconClick(e) {
  addToRHS(this.parentNode.parentNode.parentNode);
  e.preventDefault();
}

function initIcons() {
  var results = document.evaluate('//li[@class="g"]/div[@class="s"]/span[@class="gl"]',
                                  document,
								  null,
								  XPathResult.ORDERED_NODE_SNAPSHOT_TYPE,
								  null);
  for (var j = 0; j < results.snapshotLength; j++) {
    var resultItem = results.snapshotItem(j);
    var item = resultItem.innerHTML;
	var idx1 = item.indexOf('related:');
	var idx2 = item.indexOf('"', idx1);
	var url = item.substring(idx1 + 8, idx2);
	resultItem.innerHTML += ' - ';
	var a = document.createElement('a');
	a.setAttribute('href', '#1');
	a.innerHTML = 'add to right';
	a.title = url;
	a.addEventListener('click', iconClick, false)
	resultItem.appendChild(a);
  }
}

function initRHS() {
  genSearchBox();
  genResultsArea();
  initIcons();
}

function init() {
  initRHS();
//  alert('haha');
}

function addToRHS(obj) {
  var result = obj.innerHTML;
  var str = getTagStr(result, 'h3');
  alert(str);
}

window.addEventListener('load', init, false);
