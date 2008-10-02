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
 * Contains class DbaException
**/

/**
 * Exception that is thrown by the class Dba.
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
