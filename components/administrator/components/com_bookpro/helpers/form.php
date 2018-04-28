<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 27 2012-07-08 17:15:11Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');
class FormHelper {

	public static function bookproHiddenField($param){
		
		$fields='<input type="hidden" name="option" value="com_bookpro" />';
		$fields.=JHtml::_('form.token');
		foreach ($param as $key=>$value) {
			$fields.='<input id="'.$key.'" type="hidden" name="'.$key.'" value="'.$value.'" />';
		}
		return $fields;

	}
}