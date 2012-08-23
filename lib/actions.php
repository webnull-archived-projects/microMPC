<?php
	/* handle the actions for mpd */

	if ($_GET['skipto']) {
		$mympd->SkipTo($_GET['skipto']);
	}

	switch($_GET['action']) {
		case "clear":
			$mympd->PLClear();
			break;

		case "remove":
			$mympd->PLRemove($_GET['id']);
			break;

		case "fileadd":
			$mympd->PLAdd($_GET['file']);
			break;

		case "addall":
			addall($_COOKIE['browse']);
			$page = 'playlist';
			setcookie('page', $page);
			header("Location: index.php?ajax=notemplate");
			break;

		case "playall":
			$mympd->PLClear();

			addall($_COOKIE['browse']);

			$page = 'control';
			setcookie('page', $page);
			$mympd->Play();
			header("Location: index.php?ajax=notemplate&page=playlist");
			break;

		case "fileplay":
			$mympd->PLClear();
			$mympd->PLAdd($_GET['file']);
			$page = 'control';
			setcookie('page', $page);
			$mympd->Play();
			header("Location: index.php?ajax=notemplate&page=playlist");
			break;

		case "volumeup":
			$mympd->AdjustVolume(10);
			header("Location: index.php?ajax=notemplate&page=playlist");
		break;

		case 'seek_up':
			$mympd->SeekTo(($mympd->current_track_position+10));
			header("Location: index.php?ajax=notemplate&page=playlist");
		break;

		case 'seek_down':
			$mympd->SeekTo(($mympd->current_track_position-10));
			header("Location: index.php?ajax=notemplate&page=playlist");
		break;

		case "volumedown":
			$mympd->AdjustVolume(-10);
			header("Location: index.php?ajax=notemplate&page=playlist");
		break;

		case "play":
			$mympd->Play();
			header("Location: index.php?ajax=notemplate&page=playlist");
			break;

		case "stop":
			$mympd->Stop();
			header("Location: index.php?ajax=notemplate&page=playlist");
			break;

		case "pause":
			$mympd->Pause();
			header("Location: index.php?ajax=notemplate&page=playlist");
			break;

		case "prev":
			$mympd->Previous();
			header("Location: index.php?ajax=notemplate&page=playlist");
			break;

		case "next":
			$mympd->Next();
			header("Location: index.php?ajax=notemplate&page=playlist");
			break;
	}

	function addall($browse) {

		global $_CONFIG, $mympd;

		if ($browse == $_CONFIG['separator']) {
			$browse = '';
		}


				$browse_bits = explode($_CONFIG['separator'], $browse);
				
				if (is_array($browse_bits)) {

					if ($browse_bits[1]) {
						$album = $browse_bits[1];
						$browselist = $mympd->Find(MPD_SEARCH_ALBUM, $album);
					}
					elseif ($browse_bits[0]) {
						$artist = $browse_bits[0];
						$browselist = $mympd->Find(MPD_SEARCH_ARTIST, $artist);
					}

				}
				else {
					//$browselist = $mympd->Search(MPD_SEARCH_TITLE, '');
				}


		if (is_array($browselist)) {

			foreach($browselist as $browselist_item) {
				if ($browselist_item['file']) {
					$addlist[] = $browselist_item['file'];
				}
			}

			$mympd->PLAddBulk($addlist);
		}

	}
?>
