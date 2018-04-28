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
if(!defined('DS')){
	define('DS',DIRECTORY_SEPARATOR);
}
// import joomla controller library
jimport('joomla.application.component.controller');
 
include (JPATH_COMPONENT_ADMINISTRATOR . DS . 'helpers' . DS . 'importer.php');
include (JPATH_COMPONENT_ADMINISTRATOR . DS . 'helpers' . DS . 'html.php');
include (JPATH_COMPONENT_ADMINISTRATOR . DS . 'helpers' . DS . 'model.php');


$language = JFactory::getLanguage();
/* @var $language JLanguage */
$language->load('com_bookpro', JPATH_SITE, null, true);


AImporter::defines();

AImporter::helper('bookpro', 'factory', 'html');

$document = JFactory::getDocument();
$document->addStyleSheet('components/com_bookpro/assets/css/joomla3.css');


if (class_exists(($classname = AImporter::controller()))) {
	
   
	$controller = new $classname();
    /* @var $controller JController */
    
    //$controller = JController::getInstance('BookPro');
	
    $controller->execute(JRequest::getVar('task'));
    
    //die;
    $controller->redirect();
}