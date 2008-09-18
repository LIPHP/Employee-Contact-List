<?php

/**
 * This file contains functions that are not part of classes used by the site. 
 * Also uses browser_detection.php.
 * @package 
**/

/**
 * Information from browder_detection.php is smartified by load_browser_info().
**/
require_once('browser_detection.php');


/**
 * Sends a 404 error message to the browser, and writes $msg as a php error. 
 * @param string $msg The error message. This message is of level E_USER_ERROR.
 * @param string $mime_type The mime type of the message. You probably only want to set this
 * if the php file is sending some kind of binary data.
**/
function die_404($msg, $mime_type="text/html") {
        header( "HTTP/1.0 404 Not Found" );
	header( "Content-type: $mime_type" );
	trigger_error($msg, E_USER_ERROR);
}


/**
 * Creates a smarty object with security turned on and configured for flipFilm.
 * This method is called by SessionBase::CreateSmarty. Generally, you should call
 * SessionBase::CreateSmarty() from webroot scripts as it loads up session data into
 * the smarty object.
 * @param string $template_dir the template directory.
 * @param boolean $smarty_debugging Set to true to turn on debugging
 * @return A smarty object
 */
function init_smarty($template_dir = 'templates/', $smarty_debugging=false) {
	$site_root = 'C:\src\LIPHP Employee Contact List\\';

	$smarty = new Smarty();

	$smarty->template_dir = $site_root . $template_dir;
	$smarty->secure_dir = $site_root . 'templates/';
	$smarty->compile_dir = $site_root . 'templates_c/';
	$smarty->config_dir = $site_root . 'configs/';
	$smarty->cache_dir = $site_root . 'cache/';
	$smarty->plugins_dir[] = $site_root . 'plugins/';
	$smarty->security = true;
	$smarty->debugging = $smarty_debugging;
	load_browser_info($smarty);
	return $smarty;
}

/**
 * Loads info from browder_detection() into a smarty object.
 * @todo Load other variables as needed. Some call this agile development.
 * I call this being lazy in a good way.
 * @param Marty &$smarty Smarty object passed by referece that is loaded with
 * smarty vaiables based on the findings of browser_detection().
 * @return NULL. 
**/
function load_browser_info (Smarty &$smarty) {
	$browser = browser_detection('browser');
	$os = browser_detection('os');
	$smarty->assign('IsIE', ($browser == 'ie'));
	$smarty->assign('IsMozilla', ($browser == 'moz'));
	$smarty->assign('IsOpera', ($browser == 'op'));
	$smarty->assign('IsSafari', ($browser == 'saf'));
	$smarty->assign('IsMac', ($os == 'mac'));
}


/**
 * Outputs a flv mime type header and the given flv file.
 * @param $fileName string. The name of the file to proxy.
 * @todo Name file the same name as the uploaded media, 
 * changing the extension to flv.
**/
function proxy_flv($fileName, $mimeBaseName="movie") {
	if (file_exists($fileName) && filesize($fileName) > 0) {
		header( "Content-type: video/x-flv" );
		header("Content-Disposition: inline; filename=\"$mimeBaseName.flv\"");
		header("Content-Length: " . filesize($fileName));
		@readfile( $fileName );
	} else {
		die_404("Media Does not exist.", "video/x-flv");
	}
}


/**
 * Make sure $filename is a valid jpeg, gif, or png, sets the MIME header,
 * and outputs the image's contents.
 * @param $fileName string. The name of the file to proxy.
**/
function proxy_image($fileName, $mimeBaseName="image") {
	if (! $fileInfo = getimagesize($fileName)) {
		die_404("Problem with format of ($fileName)", "image/png");
	}
	switch ($fileInfo[2]) {
		case 1:
			header( "Content-type: image/gif" );
			header("Content-Disposition: inline; filename=\"$mimeBaseName.gif\"");
			break;
		case 2:
			header( "Content-type: image/jpg" );
			header("Content-Disposition: inline; filename=\"$mimeBaseName.jpg\"");
			break;
		case 3:
			header( "Content-type: image/png" );
			header("Content-Disposition: inline; filename=\"$mimeBaseName.png\"");
			break;
		default:
			die_404("$fileName must be in gif, png or jpg format.", "image/png");
	}
	@readfile( $fileName );
}


/**
 * Outputs a file with a appropiate Content-type header.
 * @param $fileName string. The name of the file to proxy.
**/
function proxy_file($fileName) {
	if (file_exists($fileName) && filesize($fileName) > 0) {
		$finfo = finfo_open(FILEINFO_MIME, '/usr/share/magic');
		$mimetype = finfo_file($finfo, $fileName);
		finfo_close($finfo);
		header( "Content-type: {$mimetype}");
		header('Content-Disposition: inline; filename="' . basename($fileName) . '"');
		@readfile( $fileName );
	} else {
		die_404("Media {$fileName} does not exist.", "video/x-flv");
	}
}
?>
