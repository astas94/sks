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

$db=JFactory::getDbo();
$query= $db->getQuery(true);
$query->select('count(*)')->from('#__bookpro_bustrip');
$db->setQuery($query);
$total_bustrip=$db->loadResult();

$query= $db->getQuery(true);
$query->select('count(*)')->from('#__bookpro_customer');
$db->setQuery($query);
$total_customer=$db->loadResult();

$query= $db->getQuery(true);
$query->select('count(*)')->from('#__bookpro_orders');
$db->setQuery($query);
$total_booking=$db->loadResult();


$query= $db->getQuery(true);
$query->select('count(*)')->from('#__bookpro_dest');
$db->setQuery($query);
$total_dest=$db->loadResult();

$query= $db->getQuery(true);
$query->select('count(*)')->from('#__bookpro_passenger');
$db->setQuery($query);
$total_pass=$db->loadResult();

$buttons = array(
	
		array(
				'link' =>"index.php?option=com_bookpro&view=orders",
				'image' => 'basket',
				'text' => $total_booking.' бронирования',
				'access' => array('core.manage', 'com_content', 'core.create', 'option=com_bookpro')
		),
		array(
				'link' =>"index.php?option=com_bookpro&view=airports",
				'image' => 'address',
				'text' => $total_dest.' пункты назначения',
				'access' => array('core.manage', 'com_content', 'core.create', 'option=com_bookpro')
		),
		array(
				'link' =>"index.php?option=com_bookpro&view=bustrips",
				'image' => 'list',
				'text' => $total_bustrip .' маршруты',
				'access' => array('core.manage', 'com_content', 'core.create', 'option=com_bookpro')
		),
		
		array(
				'link' =>"#",
				'image' => 'user',
				'text' => $total_pass.' пассажиры',
				'access' => array('core.manage', 'com_content', 'core.create', 'option=com_bookpro')
		)
	
			);

	$html = JHtml::_('icons.buttons', $buttons);
	?>
	<?php if (!empty($html)): ?>
	<div class="cpanel"><?php echo $html;?></div>
	<?php endif;?>


