<?php
/**
 * Support for generating html code
 *
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: html.php 82 2012-08-16 15:07:10Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');
/**
 * 
 * @author topcare
 *
 */
class DestinationHelper {
	public static function getDestinationByID($array) {
	}
	static function getFilterSelect($field, $selected, $autoSubmit = false, $customParams = '') {
		
		AImporter::model('airports');
		$model = new BookProModelAirports();
		$state=$model->getState();
		$state->set('list.start',0);
		$state->set('list.limit', 0);
		$state->set('list.state', 1);
		$items = $model->getItems();
		
		$first = new stdClass ();
		$first->$valueLabel = 0;
		$first->$textLabel = '- ' . JText::_ ( 'COM_BOOKPRO_SELECT_DESTINATION' ) . ' -';
		array_unshift ( $items, $first );
		$customParams = array (
				trim ( $customParams ) 
		);
		if ($autoSubmit) {
			$customParams [] = 'onchange="this.form.submit()"';
		}
		$customParams = implode ( ' ', $customParams );
		
		return JHtml::_ ( 'select.genericlist', $items, $field, $customParams, 'id','title', $selected );
	}
}
