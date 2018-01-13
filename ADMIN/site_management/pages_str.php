<?php
// Jobs Portal
// http://www.netartmedia.net/jobsportal
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php

function has_func_struct($param1,$param2=null) 
{
    
    $langConstructs = array("die", 
                            "echo", "empty", "exit", "eval", 
                            "include", "include_once", "isset", 
                            "list", 
                            "print",
                            "require", "require_once", 
                            "unset"
                            );
    
    

	if (!is_null($param2)) {
        return(method_exists($param1,$param2));
    }
    
   

   if (!is_string($param1)) {
        return(FALSE);
    }
    
    if (function_exists($param1) === TRUE) {
        return(TRUE);
    }
    
   

   $items = explode("::",$param1);
    if (count($items) == 2) {
        return(method_exists($items[0],$items[1]));
    }
    
    $items = explode("->",$param1);
    if (count($items) == 2) {
        return(method_exists($items[0],$items[1]));
    }
    
   

   if (in_array($param1,$langConstructs)) {
        return(TRUE);
    }
    
    return(FALSE);
}


?>