<?php
#$_GET['ajax'] = 'notemplate';
	/* Dans MPD Client (need a better name for it)
	** Version 0.2
	**
	** This file is really just a stub now that brings in the code and outputs the generated interface.
	*/
	
	require("lib/global.php");	
	require("lib/actions.php");	
	require("lib/page.php");	
		
	/* output the template */	
	if($_GET['ajax'] == 'notemplate')
	{
		$smarty->display($_CONFIG['template'] . '/in_frame.html');
	} else {
		$smarty->display($_CONFIG['template'] . '/index.html');
	}
	
?> 
