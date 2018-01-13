<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2017
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php

if (!function_exists("debug_print")) 
{ 


  if ( defined('DEBUG') && TRUE===DEBUG )

  { 
  
  
    function debug_print($string,$flag=NULL) 
	{ 
     
      if ( !(FALSE===$flag) ) 
	  
        print 'DEBUG: '.$string . "\n"; 
    } 
  }
 else 
 
 { 
 
    function debug_print($string,$flag=NULL) 
	
	{ 
	
	
    } 
  } 
  
} 

?>