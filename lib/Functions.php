<?php

/**
 * This file contains functions that are not part of classes used by the site. 
 * Also uses browser_detection.php.
 * @package EmployeePhonebook
**/


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
	$smarty->plugins_dir[] = $site_root . 'smarty_plugins/';
	$smarty->security = true;
	$smarty->debugging = $smarty_debugging;
	return $smarty;
}
?>
