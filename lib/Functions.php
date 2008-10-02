<?php

/*
 * Justin's Employee Contact List
 * Copyright (C) 2008  Justin Dearing <zippy1981@gmail.com>
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

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
