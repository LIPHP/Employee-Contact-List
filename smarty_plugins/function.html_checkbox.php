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
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {html_yes_no} function plugin
 *
 * Type:     function<br>
 * Name:     html_checkbox<br>
 * Purpose:  Prints a single checkbox and a <labal> for it.
 * Input:
 * 		  - heading = the <label> assoiated with the checkbox.
 *		  - name = the name attribute of the checkbox
 *		  - action = if not set or set to 'edit' the checkbox is enabled.
 *		  - selected = if true the checkbox is checked.
 * 
 * @author Justin Dearing <zippy1981@gmail.com>
 * @version  0.1
 * @param array
 * @param Smarty
 * @return string|null
 */
function smarty_function_html_checkbox($params, &$smarty) {
	if (!isset($params['name'])) {
		$smarty->trigger_error
			('Parameter "name" must be set in smarty function html_checkbox',
			E_USER_ERROR);
	}

	if (isset($params['heading'])) {
		$content = "<label>{$params['heading']}</label>";
	}
	$content .= "<input name='{$params['name']}' type='checkbox' ";
	$content .= isset($params['action']) && $params['action'] != 'edit' ? 'disabled ' : '';
	$content .= $params['selected'] ? 'checked />' : '/>';

	return $content;
}

?>
