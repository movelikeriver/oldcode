/**
 * Add url preview feature for ICS / Contextual Targeting Tool.
 * author: Lenjoy
 */

function clickA (a) {
	var c = a.nextSibling;
	if (a.className == 'aw-zippy-closed') {
		a.className = 'aw-zippy-opened';
		c.style.display = 'block';
	} else {
		a.className = 'aw-zippy-closed';
		c.style.display = 'none';
	}
};

// load
var elems = document.getElementsByTagName('div');
for (var j = 0; j < elems.length; ++j) {
	var el = elems[j];
	if (el.className != 'aw-ctt-detailsPanel-predictedPlacementDomain') {
		continue;
	}
	var a = el.firstChild;
	a.id = 'a_' + j;
	a.onclick = function() {clickA(this); return false;};
	var img = document.createElement('img');
	img.src = 'http://www.google.com/webpagethumbnail?c=100&d=http://' + a.innerHTML;
	a.nextSibling.appendChild(img);
}

