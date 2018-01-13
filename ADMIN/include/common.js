var affInterfaceOptions = 'aff=websiteadmin&skin=19&cols=4&rows=4&shop=n1-green&currency=0&locale=en';

function IncludeAffInterface(options,file){
	if(!file) file = 'interface';
	options = affInterfaceOptions + (options ? '&'+options : '');
	document.write('<SCRIPT type="text/javascript" language="JavaScript" src="http://www.mytemplatestorage.com/codes/'+file+'.php?'+options+'"><'+'/SCRIPT>');
}

function Popup(url){
	window.open(
		url,
		'window',
		'width=600, height=600, resizable=yes, scrollbars=yes, location=no,  toolbar=no, menubar=no, status=no'
	);
}
// Hide "www.mytemplatestorage.com" from status bar
function HideStatus(){
	window.status = document.readyState!="complete" ?
		"Loading..." : window.defaultStatus;
}
document.onreadystatechange = HideStatus;

