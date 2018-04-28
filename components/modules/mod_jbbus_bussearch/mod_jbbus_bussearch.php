<?php 
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 27 2012-07-08 17:15:11Z quannv $
 **/

defined('_JEXEC') or die;

if(version_compare(PHP_VERSION,'5.3.0')==-1){
	echo 'Need PHP version 5.3.0, your current version: ' . PHP_VERSION . "\n";
	return;
}
$input=JFactory::getApplication()->input;
require_once JPATH_SITE.'/modules/mod_jbbus_bussearch/helper.php';
require_once JPATH_ADMINISTRATOR.'/components/com_bookpro/helpers/date.php';
$document=JFactory::getDocument();

$config_page = $params->get ('Itemid');
$Itemid=$config_page?$config_page:$input->get('Itemid');

JHtml::_('jquery.framework');
JHtml::_('bootstrap.framework');
$lang=JFactory::getLanguage();
$local=substr($lang->getTag(),0,2);
if($local=="en")
	$local="en-GB";


$config=JComponentHelper::getParams('com_bookpro');

$js_format=DateHelper::getConvertDateFormat('B');
$date_format=DateHelper::getConvertDateFormat('P');

$default_search=$params->get('roundtrip',0);
$document->addScript(JURI::root().'components/com_bookpro/assets/js/bootstrap-datepicker.js');
$document->addScript(JURI::root().'components/com_bookpro/assets/js/locales/bootstrap-datepicker.'.$local.'.js');
$document->addStyleSheet(JURI::root().'components/com_bookpro/assets/css/datepicker.css');
$document->addScript(JURI::root().'components/com_bookpro/assets/js/bootstrap-switch.min.js');
$document->addStyleSheet(JURI::root().'components/com_bookpro/assets/css/bootstrap-switch.min.css');
$document->addStyleSheet(JURI::root().'modules/mod_jbbus_bussearch/assets/style.css');

$from=JFactory::getApplication()->getUserState('filter.from');
$to=JFactory::getApplication()->getUserState('filter.to',null);
$roundtrip=JFactory::getApplication()->getUserStateFromRequest('filter.roundtrip','filter_roundtrip',$default_search);
$start=JFactory::getApplication()->getUserState('filter.start');
$end=JFactory::getApplication()->getUserState('filter.end',null);
$adult = JFactory::getApplication()->getUserStateFromRequest ( 'filter.adult', 'filter_adult', 1 );
$child = JFactory::getApplication()->getUserStateFromRequest ( 'filter.child', 'filter_child', 0 );
$senior = JFactory::getApplication()->getUserStateFromRequest ( 'filter.senior', 'filter_senior',0 );

$from_select=modBusHelper::createDestinationSelectBox($from,'class="input-medium"');

if($to){
	$desto=modBusHelper::getArrivalDestination('filter_to',$to,$from);
}
else{
	$desto=JHtmlSelect::genericlist(array(), 'filter_to','class="input-medium"');
}

$today = JFactory::getDate('now');
if($start){
	$start=JFactory::getDate($start)->format($date_format);
}else {
	
	$today->add(new DateInterval('P1D'));
	$start= $today->format($date_format);
}
if($end){
	$end=JFactory::getDate($end)->format($date_format);
}else {
	$today->add(new DateInterval('P2D'));
	$end= $today->format($date_format);
}
require JModuleHelper::getLayoutPath('mod_jbbus_bussearch', $params->get('layout', 'default'));