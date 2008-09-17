<?php
/** @Summary Contains class DbaException **/

/**
   @Summary Exception that is thrown by the class Dba.
 **/
class DbaException extends Exception {
	function __construct(Array $Messages) {
		foreach ($Messages as $singleMessage) {
			$message .= singleMessage . '\n';
		}
		parent::__Construct(message);
	}
}
?>
