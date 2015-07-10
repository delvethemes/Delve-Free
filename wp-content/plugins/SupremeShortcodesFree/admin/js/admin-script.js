/* COOKIES */
function getCookie(c_name) {
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++) {
	  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
	  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
	  x=x.replace(/^\s+|\s+$/g,"");
	  if (x==c_name)
	    {
	    return unescape(y);
	    }
	  }
}

function setCookie(c_name,value,exdays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}


/* DOCUMENT READY */
jQuery(document).ready(function($){

	/* COOKIES */
	var curr_tab = 0;
	if (getCookie("curr_tab") != "") {
		curr_tab = getCookie("curr_tab");
	}

	/* MENU - TABS */
	var tabs = $('#tabs-titles li'); //grab tabs
	var contents = $('#tabs-contents li'); //grab contents

	tabs.bind('click',function(){

		var curr_tab = $(this).index();
		setCookie("curr_tab", curr_tab, 180);

		contents.hide(); //hide all contents
		tabs.removeClass('current'); //remove 'current' classes
		$(contents[$(this).index()]).show(); //show tab content that matches tab title index
		$(this).addClass('current'); //add current class on clicked tab title

	}).eq(curr_tab).click();

});