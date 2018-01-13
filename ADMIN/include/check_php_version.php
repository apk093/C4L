<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
$current_php_version = "current version:" . phpversion();


function version_compare2($version1, $version2)
{
    $v1 = explode('.',$version1);
    $v2 = explode('.',$version2);
    
    if ($v1[0] > $v2[0])
        $ret = 1;
    else if ($v1[0] < $v2[0])
        $ret = -1;
    
    else    
    {
        if ($v1[1] > $v2[1])
            $ret = 1;
        else if ($v1[1] < $v2[1])
            $ret = -1;
        
        else  
        {
            if ($v1[2] > $v2[2])
                $ret = 1;
            else if ($v1[2] < $v2[2])
                $ret = -1;
            else
                $ret = 0;
        }
    }
    
    return $ret;
}


function is_same_version($version1,$version2,$operand) 
{

        $v1Parts=explode('.',$version1);
		
        $version1.=str_repeat('.0',3-count($v1Parts));
		
        $v2Parts=explode('.',$version2);
		
        $version2.=str_repeat('.0',3-count($v2Parts));
		
        $version1=str_replace('.x','.1000',$version1);
		
        $version2=str_replace('.x','.1000',$version2);        
		
        return version_compare($version1,$version2,$operand);
}
?>