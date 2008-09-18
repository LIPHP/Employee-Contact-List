<?php
/**
 * Contains abstract class Session
 * @package MiddleWare
**/

/**
 * Include files
**/
require_once('Dba.php');
require_once('Functions.php');
require_once ('Smarty/Smarty.class.php');

/**
 * Object that handles the user session.
 * This object uses a combination of the PHP session handler and 
 * custom cookies to manage a users session. A PHP session is created 
 * if the user logs in. 
 * @todo I believe in its current configuration if apache is restarted the 
 * session will still read as active but won't be.
 * @package MiddleWare
**/
class Session {

	protected $Db;


	public function __construct() {
		$this->Db =& new Dba();
		/*/
		 * Sometimes multiple session objects get called. 
		 * I should probably implement this as a 
		 * singleton class, but for now, muck with session 
		 * variables below and do everything else
		 * above this line.
		/*/
		if (isset($_COOKIE['login_session'])) {
			session_id($_COOKIE['login_session']);
			session_start();
		}
	}


	/**
	 * Factory method that creates a smarry object with security turned on.
	 * @param string $template_dir the template directory.
	 * @param boolean $smarty_debugging Set to true to turn on debugging.
	 * @return A smarty object.
	 */
	function CreateSmarty($template_dir = 'templates/', $smarty_debugging=false) {
		$smarty = init_smarty();
		#TODO: Assign global smartyh variables here.
		return $smarty;
	}


	/**
	 * Displays an error page with the given error message.
	 * @param $message string The Error message to display.
	 * @param $redirect_url string The url to redirect to after displaying
	 * the error page. If not specified, redirects to the referer url.
	 * @return null
	**/
	public function DisplayError($message="Unspecified error message.", $redirect_url=null) {
		$redirect_url = $redirect_url == null ? $_SERVER['HTTP_REFERER'] : $redirect_url;
		$Smarty = $this->CreateSmarty();
		$Smarty->assign("ErrorMessage", $message);
		$Smarty->assign("RedirectUrl", $redirect_url);
		$Smarty->display("flip_error.tpl");
		die();
	}
	

	/**
	 * Factory method to return data access object.
	 * @return an object of type dba.
	 */
	function GetDba() {
		return new Dba();
	}


	/**
	 * Retrieve the sessionid of the session
	 * @return string The identifier of the session.
	**/
	public function GetSessionId() {
		return session_id();
	}


	/**
	 * Change the session id.
	 * @param string $SesssionId The id of the session being restored.
	**/
	public function SetSessionId($SessionId) {
		session_write_close();
		session_id($SessionId);
		session_start();
	}
}
?>
