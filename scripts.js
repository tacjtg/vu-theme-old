////////////////////////////////////////////
// clear search box	
////////////////////////////////////////////
function clearDefault(el) {
	if (el.defaultValue==el.value) el.value = ""
	}
////////////////////////////////////////////
// dropdown menu	
////////////////////////////////////////////
sfHover = function() {
	var sfEls = document.getElementById("sitenav").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);