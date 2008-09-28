<?php
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
