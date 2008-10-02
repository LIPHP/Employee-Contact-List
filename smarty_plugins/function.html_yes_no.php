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
 * Smarty {html_yes_no} function plugin
 *
 * Type:     function<br>
 * Name:     html_yes_no<br>
 * Date:     March 1, 2004<br>
 * Purpose:  Prints set of radio buttons side by side, essentially with value of<br>
 * 			 1/0 [ true/false ], meant for Yes/No style options
 * Input:
 *         - name = name of radio set 
 *			  - yes_label = Text for "yes" option [default: Yes] 
 *			  - no_label = Text for "no" option [default: No] 
 *			  - value = Currently selected radio button
 *			  - default = default value, "yes" if missing [optional]
 * 
 * Examples:<br>
 * <pre>
 * {html_yes_no name="is_visible" yes_label="Show this" no_label="Hide this" value=$is_hidden}
 * </pre>
 * @author Mark Hewitt <mark@formfunction.co.za>
 * @version  0.1
 * @param array
 * @param Smarty
 * @return string|null
 */
function smarty_function_html_yes_no($params, &$smarty)
{	
	
	if ( !isset($params['value']) && is_numeric($params['value']) )
	{
		$params['value'] = ( isset($params['default']) && $params['default']='no' ? 0 : 1 ); 
	}
	
	// determine CHECK state of the individual RADIO elements

	$yes_state = ( isset($params['value']) && $params['value'] ? 'CHECKED' : '' );
	$no_state = ( isset($params['value']) && !$params['value'] ? 'CHECKED' : '' );

	// were labels given or do we use the defaults?
	if ( !isset($params['yes_label']) ) $params['yes_label'] = 'Yes';
	if ( !isset($params['no_label']) ) $params['no_label'] = 'No';

	// generate the two radio buttons
	
	$content = '<input type="radio" name="'.$params['name'].'" value="1" '.$yes_state.'>';
	$content .= '&nbsp;'.$params['yes_label'];
	$content .= '&nbsp;&nbsp;';
	$content .= '<input type="radio" name="'.$params['name'].'" value="0" '.$no_state.'>';
	$content .= '&nbsp;'.$params['no_label'];
	
	return $content;
}
?>
