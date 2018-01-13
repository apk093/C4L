
$("#sidebar-toggle").click(function(e) {
    e.preventDefault();
    $(".navbar-side").toggleClass("collapsed");
    $("#page-wrapper").toggleClass("collapsed");
});

function sub_loc_select(x,field_name)
{
	if(x=="") return;
	
	if (window.XMLHttpRequest)
	{
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			show_sub_locs(xmlhttp.responseText,x,field_name);
		}
	}
	
	xmlhttp.open("GET","../include/suggest_location.php?location="+x+"&q=",true);
		
	xmlhttp.send(null);
	
}
var up_html = new Array();
var i_last_level = -1;
function show_sub_locs(text,x,field_name)
{
	var i_level = (x.split(".").length - 1);

	for(i=i_level;i<=4;i++)
	{
		document.getElementById("s_"+field_name+"_"+i).innerHTML="";	
	}
	
	var new_html="";
	var splitArray = text.split("~");

	var j = 0;
	for(j = 0; j < splitArray.length; j++)
	{
		var location = splitArray[j].split("#");
		 
		if(location[0]=="no suggestion")
		{
			
			
		}
		else
		{
			new_html += "<option value=\""+location[1]+"\">"+location[0]+"</option>";
		}
	}
	
	if(new_html!="")
	{
		new_html ='<select '+(field_name=="category_1"?'required':'')+' onChange="sub_loc_select(this.value,\''+field_name+'\'")" type="text" class="form-control input-sm" id="'+field_name+'_'+(i_level+1)+'" name="'+field_name+'_'+(i_level+1)+'">'
		+'<option value="">'+m_all+'</option>'+new_html+'</select>';
		document.getElementById("s_"+field_name+"_"+i_level).innerHTML=new_html;
	}
	
	i_last_level = i_level
}	

 
function init() 
{
	
	if(document.getElementById("home-links-area"))
	{
		$('.menu-sub-link').draggable( {
			  helper: 'clone', 
				appendTo: 'body', 
				start: function(){
					$(this).css({opacity:0});
				},
				stop: function(){
					
					$(this).css({opacity:1});
				}
		} );
		
		for(i=0;i<=6;i++)
		{
			$('#b-'+i).draggable( {
			  containment: '#home-links-area',
			  stack: ".tile-p",
			  revert: true
			} );
			
			$('#box-'+i).droppable( {
				drop: handleDropEvent
			  } );
		}	
	
	}
}
 
function handleDropEvent( event, ui ) {
var id = $(this).attr('id');
  var draggable = ui.draggable;
  
  if(draggable.attr('id').indexOf("b-")==-1&&draggable.attr('id').indexOf("box-")==-1)
  {
	document.getElementById('ajax-ifr').src="admin_page.php?ajax_load=1&category=home&action=welcome&bn=a&o="+id+"&n="+ draggable.attr('id');
 
  }
  else
  {
	document.getElementById('ajax-ifr').src="admin_page.php?ajax_load=1&category=home&action=welcome&bn=s&o="+id+"&n="+ draggable.attr('id');
  }
}

function dragStart()
{
	lock_check = true;
}



function ShowHide(div_name)
{

	if(document.getElementById(div_name).style.display=="block")
	{
		document.getElementById(div_name).style.display="none";
	}
	else
	{
		document.getElementById(div_name).style.display="block";
	}

}
