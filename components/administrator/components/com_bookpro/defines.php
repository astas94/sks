<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: defines.php 104 2012-08-29 18:01:09Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');
if(!defined('DS')){
	define('DS',DIRECTORY_SEPARATOR);
}

//Set defines for component location
$mainframe = JFactory::getApplication();
/* @var $mainframe JApplication */
define('IS_ADMIN', $mainframe->isAdmin());
define('IS_SITE', $mainframe->isSite());

//Display component name
define('COMPONENT_NAME', 'BookPro');
//Unique component option use for navigation in Joomla!
define('OPTION', 'com_bookpro');
define('NAME', 'bookpro');

//default component encoding
define('ENCODING', 'UTF-8');

define('ADMIN_ROOT', JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . OPTION);
define('SITE_ROOT', JPATH_ROOT . DS . 'components' . DS . OPTION);
define('CONFIG', ADMIN_ROOT . DS . 'config.xml');

//Component table prefix
define('PREFIX', 'bookpro');


AImporter::helper('factory', 'html');

//Name of default controller
define('CONTROLLER', 'BookproController');
//Define IDs for component controllers
define('CONTROLLER_CUSTOMER', 'customer');
define('CONTROLLER_AGENT', 'agent');
define('CONTROLLER_AGENTBUS', 'agentbus');
define('CONTROLLER_AGENTBUSTRIP','agentbustrip');
define('CONTROLLER_AGENTBUSSTATION', 'agentbusstation');
define('CONTROLLER_AGENT_REPORT', 'report');
define('CONTROLLER_AIRLINE', 'airline');
define('CONTROLLER_BUS', 'bus');
define('CONTROLLER_REFUND', 'refund');
define('CONTROLLER_SEATTEMPLATE', 'seattemplate');
define('CONTROLLER_SEATTEMPLATES', 'seattemplates');
define('CONTROLLER_GERNERATE', 'generate');
define('CONTROLLER_BUSSTATION', 'busstation');
define('CONTROLLER_BUSTRIP', 'bustrip');
define('CONTROLLER_BAGGAGE', 'baggage');
define('CONTROLLER_MEAL', 'meal');
define('CONTROLLER_SEAT', 'seat');
define('CONTROLLER_PASSENGER', 'passenger');
define('CONTROLLER_AIRPORT','airport');
define('CONTROLLER_CURRENCY','currency');
define('CONTROLLER_CATEGORY','category');
define('CONTROLLER_COUNTRY','country');
define('CONTROLLER_REGION','region');
define('CONTROLLER_COUPON','coupon');
define('CONTROLLER_ORDER','order');
define('CONTROLLER_APPLICATION','application');
define('CONTROLLER_CGROUP','cgroup');
define('CONTROLLER_ROOM','room');
define('CONTROLLER_PAYMENTLOG', 'paymentlog');


define('IMAGES', JURI::root() . 'components/' . OPTION . '/assets/images/');
define('IMAGES_SAMPLE', SITE_ROOT . DS . 'assets' . DS . 'images' . DS . 'sample');

define('CACHE_IMAGES_DEPTH', 5);

define('ADMIN_SET_IMAGES_WIDTH', 80);



define('CUSTOMER_STATE_ACTIVE', 1);
define('CUSTOMER_STATE_DELETED', 0);
define('CUSTOMER_STATE_BLOCK', - 1);

define('CUSTOMER_USER_STATE_BLOCK', 1);
define('CUSTOMER_USER_STATE_ENABLED', 0);

define('CUSTOMER_SENDEMAIL', 0);


//Defines for frontend views
define('VIEW_FLIGHTS', 'flights');
define('VIEW_AIRPORTS', 'airports');
define('VIEW_CUSTOMER', 'customer');
define('VIEW_AGENT', 'agent');
define('VIEW_CUSTOMERS', 'customers');
define('VIEW_AGENTS', 'agents');
define('VIEW_AIRPORT', 'airport');
define('VIEW_PASSENGERS', 'passengers');
define('VIEW_PAYMENTS', 'payments');
define('VIEW_APPLICATION', 'application');
define('VIEW_APPLICATIONS', 'applications');
define('VIEW_PAYMENT', 'payment');
define('VIEW_CONFIG', 'config');
define('VIEW_CATEGORY', 'categories');
define('VIEW_AIRLINES', 'airlines');
define('VIEW_ADMINS', 'admins');
define('VIEW_IMAGES', 'images');
define('VIEW_FILES', 'files');



define('CHECK_OP_IN', 1);
define('CHECK_OP_OUT', 2);
define('CHECK_OP_NEXT', 3);

define('DAY_LENGTH', 24 * 60 * 60);
define('YEAR_LENGTH', 365 * 24 * 60 * 60);


define('ADMIN_VIEWS', ADMIN_ROOT . DS . 'views');
define('SITE_VIEWS', SITE_ROOT . DS . 'views');

define('PLAIN_TEXT', 'plain_text');
define('PARAM_LABEL', 3);
define('PARAM_VALUE', 4);
define('PARAM_NAME', 5);
define('PARAM_SEARCHABLES', 6);
define('PARAM_FILTERABLES', 7);
define('PARAM_TYPE', 8);
define('PARAM_ICON', 10);
define('PARAM_NODE', 11);
define('PARAM_OPTIONS', 'options');
define('SEND_EMAIL_OFF', 0);
define('SEND_EMAIL_BOTH', 1);
define('SEND_EMAIL_ADMIN', 2);
define('SEND_EMAIL_CUSTOMER', 3);


?>