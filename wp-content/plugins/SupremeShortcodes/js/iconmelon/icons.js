var url = stPluginUrl+'/js/iconmelon/icons.svg';
var c=new XMLHttpRequest(); c.open('GET', url, false); c.setRequestHeader('Content-Type', 'text/xml'); c.send();
document.body.insertBefore(c.responseXML.firstChild, document.body.firstChild)