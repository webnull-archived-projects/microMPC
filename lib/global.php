<?php
	/* Smarty stuff */

	$version = '0.5.2';

	if (get_magic_quotes_gpc()) {
		/* Deal with Magic quotes. We can safely strip these off as we're not using a database. */
		$_REQUEST = array_map('stripslashes', $_REQUEST);
		$_GET = array_map('stripslashes', $_GET);
		$_POST = array_map('stripslashes', $_POST);
		$_COOKIE = array_map('stripslashes', $_COOKIE);
	}

	require('config/config.inc.php');
	

	$_CONFIG['separator'] = '|';

	define('SMARTY_DIR', 'lib/smarty/libs/');
	require(SMARTY_DIR . 'Smarty.class.php');
	$smarty = new Smarty;
	$smarty->template_dir = 'templates/';
	$smarty->compile_dir = 'smarty/templates_c/';
	$smarty->config_dir = 'smarty/configs/';
	$smarty->cache_dir = 'smarty/cache/';

	$smarty->assign('version', $version);
	$smarty->assign('template', $_CONFIG['template']);
	
	require("templates/${_CONFIG['template']}/config.inc.php");

	include('lib/mpd.class.php');
	if ($_CONFIG['password'] != '') {
		$mympd = new mpd($_CONFIG['server'], $_CONFIG['port'], $_CONFIG['password']);
	}
	else {
		$mympd = new mpd($_CONFIG['server'], $_CONFIG['port']);
	}

	if (!$mympd->connected) {
		echo "<p>Problem connecting to MPD!</p>";
		exit;
	}

	/* track number sorting function */

	function track_sort($a, $b) {
		if ($a['directory'] && $b['directory']) {
			if ($a['directory'] < $b['directory']) {
				return -1;
			}
			elseif ($a['directory'] > $b['directory']) {
				return 1;
			}
			else {
				return 0;
			}
		}
		elseif ($a['directory'] && !$b['directory']) {
			return 1;
		}
		elseif (!$a['directory'] && $b['directory']) {
			return -1;
		}
		else {
			return $a['Track'] - $b['Track'];
		}
	}

	/* setup some global vars */
	$smarty->assign('browse_link', 'index.php?page=browse&ajax=notemplate');
	$smarty->assign('playlist_link', 'index.php?page=playlist&ajax=notemplate');
	$smarty->assign('browselist_play_link', 'index.php?action=fileplay&ajax=notemplate&file=');
	$smarty->assign('browselist_add_link', 'index.php?action=fileadd&ajax=notemplate&file=');
	$smarty->assign('playlist_remove_link', 'index.php?action=remove&ajax=notemplate&id=');
	$smarty->assign('control_link', 'index.php?page=control&ajax=notemplate');
	$smarty->assign('playlist_play_link', 'index.php?page=control&action=play&ajax=notemplate&skipto=');
	$smarty->assign('playlist_clear_link', 'index.php?action=clear&ajax=notemplate');
	$smarty->assign('mpd_state', $mympd->state);
	$smarty->assign('mpd_volume', $mympd->volume);
	$smarty->assign('mpd_uptime', $mympd->uptime);
	$smarty->assign('mpd_playtime', $mympd->playtime);
	$smarty->assign('mpd_position', $mympd->current_track_position);

	$current_track = $mympd->playlist[$mympd->current_track_id];
	$smarty->assign('current_track_no', $mympd->current_track_id);
	$smarty->assign('current_title', $current_track['Title']);
	$smarty->assign('current_album', $current_track['Album']);
	$smarty->assign('current_artist', $current_track['Artist']);
	$smarty->assign('current_file', $current_track['file']);

	/* first check for a page cookie, and default to displaying the playlist */
	if ($_GET['page']) {
		$page = $_GET['page'];
		setcookie('page', $page);
	}
	else {
		$page = $_COOKIE['page'];
	}

	if (!$page) {
		$page = 'playlist';
	}

	//echo $mympd->current_track_length, ' - ', $mympd->current_track_position;

	$smarty->assign('page', $page);

?>
