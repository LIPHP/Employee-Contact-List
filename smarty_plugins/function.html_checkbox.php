<?php
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
