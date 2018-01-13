<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
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