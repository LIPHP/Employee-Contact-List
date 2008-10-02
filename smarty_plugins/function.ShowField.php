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
**/

/**
 * Smarty functions we call from this one.
**/
require_once('Smarty/plugins/function.html_options.php');
require_once('function.fckeditor.php');
require_once('function.html_yes_no.php');

/**
 * Smarty {ShowField} function plugin
 *
 * Type:     function<br />
 * Name:     ShowField<br />
 *
 * Input:
 * If $params[action] is set to edit return an input  box
 * names $params[name] with a value of $params[value]
 * If $params[action] is set to display returns a span.
 *
 * @author Justin Dearing <zippy1981@gmail.com>
 * @version  0.1
 * @param array
 * @param Smarty
 * @return string|null
**/

function smarty_function_ShowField ($params, &$smarty) {

	$params['heading'] .= ($params['required'] === true) ? "<span style='color: #ff0000'>(*)</span>" : '';

	if ($params['problem'] == 'notset') {
		$heading = "<label class='required'>{$params['heading']}:&nbsp;&nbsp;</label>";
	}
	else {
		$heading = "<label>{$params['heading']}:&nbsp;&nbsp;</label>";
	}

	$value = $params['value'];
	if (!isset($value) || $value === NULL || $value === 'NULL') {
		$value = "";
	}
	
	switch ($params['action']) {
		case 'edit':
		switch ($params['editmode']){
			case 'hiddeninput':
				return "<input type='hidden' name='{$params['name']}' id='{$params['name']}' value='{$value}' />";
				break;
			case 'richtextarea':
				$params['Value'] = $params['value'];
				$params['InstanceName'] = $params['name'];
				$content = smarty_function_fckeditor($params, $smarty);
				break;
			case 'textarea':
				$rows = isset($params['rows']) ? $params['rows'] : 10;
				$cols = isset($params['cols']) ? $params['cols'] : 40;

				$content = 
					"<textarea name='{$params['name']}' " . 
					"rows={$rows} cols={$cols}>" .
					$value .
					"</textarea>";
				break;
			case 'options':
				return smarty_function_html_options($params, $smarty);
				break;
			case 'yes_no':
				return smarty_function_html_yes_no($params, $smarty);
				break;
			default:
				$content = 
					'<input name="' . 
						$params[name] . '" value="' . 
					$value . '" ';
				if (isset($params['size'])) {
					$content = $content . 'size="' . $params[size] . '" ';
				}
				if (isset($params['maxlength'])) {
					$content = $content . 'maxlength="' . $params[maxlength] . '" ';
				}
				if ($params['hidden'] == true) {
					$content = $content . 'type="password" ';
				}
				$content = $content . '><br />';
				break;
		}
		break;
			
		case 'display':
		default:
		switch ($params['editmode']) {
			case 'richtextarea':
			case 'textarea':
				$content = "<div class='TextBox'>{$value}</div>";
				$heading = "<div class='TextBoxLabel'>$heading</div>";
				break;
			case 'yes_no':
				$content = $params['display_value'] . '<br />';
				break;
			default:
				$content = $value . '<br />';
				break;
		}
		break;
	}
	if ($params[table_row] == true) {
		$ret = "<tr><td>$heading</td><td>$content</td></tr>";
	} else {
		$ret = $heading . $content;
	}
	return $ret;
}

?>
