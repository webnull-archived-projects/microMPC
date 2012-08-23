
		
	{literal}
	
	function format_time(number) {
		if (number < 10) {
			return '0' + number.toString();
		}
		else {
			return number.toString();
		}
	}

	var ObiektXMLHttp;
if (window.XMLHttpRequest) 
  { 
   ObiektXMLHttp = new XMLHttpRequest(); } 
   else if (window.ActiveXObject) 
      { 
       ObiektXMLHttp = new ActiveXObject("Microsoft.XMLHTTP"); }   


function view_source(source, target, params, Method) { 
 if(ObiektXMLHttp) 
  {

   
   if(Method == 'POST')
   {
		ObiektXMLHttp.open("POST", source);
		ObiektXMLHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=ISO-8859-2");
		ObiektXMLHttp.setRequestHeader("Content-length", params.length);
		ObiektXMLHttp.setRequestHeader("Connection", "close");
   } else {
		ObiektXMLHttp.open("GET", source);
   }

ObiektXMLHttp.onreadystatechange = function() 
{
 if (ObiektXMLHttp.readyState == 4)
   {

    var new_response = ObiektXMLHttp.responseText; 

	if(target != '')
	{
		target.innerHTML = new_response;
	}
   
   }
} 
if(Method == 'POST')
	ObiektXMLHttp.send(params);
else
	ObiektXMLHttp.send(null); 
} 
}

function playerAction(action)
{
	page_frame.location = 'index.php?page=playlist&action='+action+'&ajax=notemplate';
}

//function changeSong(id)
//{
//	view_source('index.php?page=control&action=play&skipto='+id+'&ajax=notemplate', document.getElementById('page'), '', 'GET');
//}

//function deleteFromPlaylist(id)
//{
//	view_source('index.php?page=control&action=remove&id='+id+'&ajax=notemplate', document.getElementById('page'), '', 'GET');
//}
	
	{/literal}
