<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2017
// Check http://www.netartmedia.net/jobsportal for demos and information
?><script language="JavaScript">
var javascriptVersion1_1 = false;
</script>

<script language="JavaScript1.1">
javascriptVersion1_1 = true;
</script>

<script language="JavaScript">
var detectableWithVB = false;
var pluginFound = false;

function goURL(daURL) {
  
    if(javascriptVersion1_1) {
	window.location.replace(daURL);
    } else {
	window.location = daURL;
    }
    return;
}

function redirectCheck(pluginFound, redirectURL, redirectIfFound) {
   
    if( redirectURL && ((pluginFound && redirectIfFound) || 
	(!pluginFound && !redirectIfFound)) ) {
	
	goURL(redirectURL);
	return pluginFound;
    } else {
	
	return pluginFound;
    }	
}

function canDetectPlugins() {
    if( detectableWithVB || (navigator.plugins && navigator.plugins.length > 0) ) {
	return true;
    } else {
	return false;
    }
}

function detectFlash(redirectURL, redirectIfFound) {
    pluginFound = detectPlugin('Shockwave','Flash'); 
    
    if(!pluginFound && detectableWithVB) {
	pluginFound = detectActiveXControl('ShockwaveFlash.ShockwaveFlash.1');
    }
   
    return redirectCheck(pluginFound, redirectURL, redirectIfFound);
}

function detectDirector(redirectURL, redirectIfFound) { 
    pluginFound = detectPlugin('Shockwave','Director'); 
    
    if(!pluginFound && detectableWithVB) {
	pluginFound = detectActiveXControl('SWCtl.SWCtl.1');
    }
   
    return redirectCheck(pluginFound, redirectURL, redirectIfFound);
}

function detectQuickTime(redirectURL, redirectIfFound) {
    pluginFound = detectPlugin('QuickTime');
   
    if(!pluginFound && detectableWithVB) {
	pluginFound = detectQuickTimeActiveXControl();
    }
    return redirectCheck(pluginFound, redirectURL, redirectIfFound);
}

function detectReal(redirectURL, redirectIfFound) {
    pluginFound = detectPlugin('RealPlayer');
 
    if(!pluginFound && detectableWithVB) {
	pluginFound = (detectActiveXControl('rmocx.RealPlayer G2 Control') ||
		       detectActiveXControl('RealPlayer.RealPlayer(tm) ActiveX Control (32-bit)') ||
		       detectActiveXControl('RealVideo.RealVideo(tm) ActiveX Control (32-bit)'));
    }	
    return redirectCheck(pluginFound, redirectURL, redirectIfFound);
}

function detectWindowsMedia(redirectURL, redirectIfFound) {
    pluginFound = detectPlugin('Windows Media');
   
    if(!pluginFound && detectableWithVB) {
	pluginFound = detectActiveXControl('MediaPlayer.MediaPlayer.1');
    }
    return redirectCheck(pluginFound, redirectURL, redirectIfFound);
}

function detectPlugin() {
  
    var daPlugins = detectPlugin.arguments;
   
    var pluginFound = false;
   
    if (navigator.plugins && navigator.plugins.length > 0) {
	var pluginsArrayLength = navigator.plugins.length;
	
	for (pluginsArrayCounter=0; pluginsArrayCounter < pluginsArrayLength; pluginsArrayCounter++ ) {
	
	    var numFound = 0;
	    for(namesCounter=0; namesCounter < daPlugins.length; namesCounter++) {
		
		if( (navigator.plugins[pluginsArrayCounter].name.indexOf(daPlugins[namesCounter]) >= 0) || 
		    (navigator.plugins[pluginsArrayCounter].description.indexOf(daPlugins[namesCounter]) >= 0) ) {
		    
		    numFound++;
		}   
	    }
	  
	    if(numFound == daPlugins.length) {
		pluginFound = true;
		
		break;
	    }
	}
    }
    return pluginFound;
} 



if ((navigator.userAgent.indexOf('MSIE') != -1) && (navigator.userAgent.indexOf('Win') != -1)) {
    document.writeln('<script language="VBscript">');

    document.writeln('\'do a one-time test for a version of VBScript that can handle this code');
    document.writeln('detectableWithVB = False');
    document.writeln('If ScriptEngineMajorVersion >= 2 then');
    document.writeln('  detectableWithVB = True');
    document.writeln('End If');

    document.writeln('\'this next function will detect most plugins');
    document.writeln('Function detectActiveXControl(activeXControlName)');
    document.writeln('  on error resume next');
    document.writeln('  detectActiveXControl = False');
    document.writeln('  If detectableWithVB Then');
    document.writeln('     detectActiveXControl = IsObject(CreateObject(activeXControlName))');
    document.writeln('  End If');
    document.writeln('End Function');

    document.writeln('\'and the following function handles QuickTime');
    document.writeln('Function detectQuickTimeActiveXControl()');
    document.writeln('  on error resume next');
    document.writeln('  detectQuickTimeActiveXControl = False');
    document.writeln('  If detectableWithVB Then');
    document.writeln('    detectQuickTimeActiveXControl = False');
    document.writeln('    hasQuickTimeChecker = false');
    document.writeln('    Set hasQuickTimeChecker = CreateObject("QuickTimeCheckObject.QuickTimeCheck.1")');
    document.writeln('    If IsObject(hasQuickTimeChecker) Then');
    document.writeln('      If hasQuickTimeChecker.IsQuickTimeAvailable(0) Then ');
    document.writeln('        detectQuickTimeActiveXControl = True');
    document.writeln('      End If');
    document.writeln('    End If');
    document.writeln('  End If');
    document.writeln('End Function');

    document.writeln('</scr' + 'ipt>');
}

</script>



<script language="JavaScript">

function ShowVideo(videoFileType, videoFile, videoWidth, videoHeight, videoAlign)
{
	
	if(videoFileType == "flv")
	{
	
				document.write('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="'+videoWidth+'" height="'+videoHeight+'" id="player" align="'+videoAlign+'" >');
				document.write('<param name="allowFlashAutoInstall" value="true">');
				document.write('<param name="Flashvars" value="url=../'+videoFile+'">');
				document.write('<param name="allowScriptAccess" value="sameDomain" />');
				document.write('<param name="movie" value="images/player.swf" />');
				document.write('<param name="quality" value="high" />');
				document.write('<param name="bgcolor" value="#ffffff" />');
				document.write('<embed src="images/player.swf" swLiveConnect="true" Flashvars="url=../'+videoFile+'" quality="high" bgcolor="#ffffff" width="'+videoWidth+'" height="'+videoHeight+'" name="player" align="'+videoAlign+'"  allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />');
				document.write('</object>');

	
	}
	else
	{
				//if(detectWindowsMedia())
				if(true)
				{
				   document.write('<object align="'+videoAlign+'" id="VideoPlayer" width="'+videoWidth+'" height="'+(videoHeight+48)+'" ');
				   document.write('classid="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95" ');
				   document.write('codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701" ');
				   document.write('standby="Loading Microsoft® Windows® Media Player components..."');
				   document.write('type="application/x-oleobject" align="middle">');
				   document.write('<param name="FileName" value="'+videoFile+'">');
				   document.write('<param name="ShowStatusBar" value="True">');
				   document.write('<param name="DefaultFrame" value="mainFrame">');
				   document.write('<embed  type="application/x-mplayer2" pluginspage = "http://www.microsoft.com/Windows/MediaPlayer/" ');
				   document.write('src="'+videoFile+'" align="'+videoAlign+'" ');
				   document.write('width="'+videoWidth+'" ');
				   document.write('height="'+(videoHeight+48)+'" ');
				   document.write('defaultframe="rightFrame" ');
				   document.write('showstatusbar=true>');
				   document.write('</embed>');
				   document.write('</object>');
				}
				else
				if(detectReal())
				{
				    document.write('<OBJECT align="'+videoAlign+'" ID="VideoPlayer" CLASSID="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" WIDTH="'+videoWidth+'" HEIGHT="'+videoHeight+'" >');
				    document.write('<PARAM NAME="SRC" VALUE="'+videoFile+'">');
				    document.write('<PARAM NAME="CONTROLS" VALUE="ImageWindow">');
				    document.write('<PARAM NAME="CONSOLE" VALUE="one">');
				    document.write('<PARAM NAME="AUTOSTART" VALUE="true">');
				    document.write('<EMBED align="'+videoAlign+'" SRC="'+videoFile+'" WIDTH="'+videoWidth+'" HEIGHT="'+videoHeight+'" NOJAVA="true" CONTROLS="ImageWindow" CONSOLE="one" AUTOSTART="true" type="audio/x-pn-realaudio-plugin">');
					document.write('</EMBED>');
				    document.write('</OBJECT>');
				
				}
				else
				if(detectQuickTime())
				{
				    document.write('<OBJECT align="'+videoAlign+'" id="VideoPlayer" CLASSID="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B"');
				    document.write(' WIDTH="'+videoWidth+'" HEIGHT="'+videoHeight+'" CODEBASE="http://www.apple.com/qtactivex/qtplugin.cab">');
				    document.write('<PARAM name="SRC" VALUE="'+videoFile+'">');
				    document.write('<PARAM name="AUTOPLAY" VALUE="true">');
				    document.write('<PARAM name="CONTROLLER" VALUE="true">');
				    document.write('<PARAM name="LOOP" VALUE="false">');
				    document.write('<EMBED align="'+videoAlign+'" src="'+videoFile+'"  pluginspage="http://www.apple.com/quicktime/download/" height="'+videoHeight+'" width="'+videoWidth+'" AUTOPLAY="true" LOOP="false" CONTROLLER="true">');
				    document.write('</EMBED>');
				    document.write('</OBJECT>');
				}
	}
}

</script>
