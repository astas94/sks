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
class AdminUIHelper {


	public static function startAdminArea($backEnd=true) {
		$uri = (string) JUri::getInstance();
		$return = urlencode(base64_encode($uri));
		$configRoute['route'] = 'index.php?option=com_config&view=component&component=' . OPTION . '&return=' . $return;
		$configRoute['params'] = array();
		AImporter::helper('route');
		$document=JFactory::getDocument();
		echo '<div class="span2">';

		JHtmlSidebar::addEntry(JText::_('COM_BOOKPRO_BUSFILTER3'),'index.php?option=com_bookpro&view=busfilter3');
		JHtmlSidebar::addEntry(JText::_('COM_BOOKPRO_BUSFILTER2'),'index.php?option=com_bookpro&view=busfilter2');
		JHtmlSidebar::addEntry(JText::_('COM_BOOKPRO_BUSFILTER1'),'index.php?option=com_bookpro&view=busfilter1');

		JHtmlSidebar::addEntry(JText::_('COM_BOOKPRO_CUSTOMER'),'index.php?option=com_bookpro&view=customers');
		//JHtmlSidebar::addEntry(JText::_('COM_BOOKPRO_CONFIGURATION'),JRoute::_(ARoute::view(VIEW_CONFIG)));
		//JHtmlSidebar::addEntry(JText::_('COM_BOOKPRO_VIEW_PAYMENTS'),'index.php?option=com_bookpro&view=payments');
		JHtmlSidebar::addEntry(JText::_('COM_BOOKPRO_APPLICATION'),'index.php?option=com_bookpro&view=applications');
		JHtmlSidebar::addEntry(JText::_('COM_BOOKPRO_ORDERS'),'index.php?option=com_bookpro&view=orders');
		JHtmlSidebar::addEntry(JText::_('COM_BOOKPRO_AIRPORTS'),'index.php?option=com_bookpro&view=airports');
JHtmlSidebar::addEntry(JText::_('COM_BOOKPRO_COUPONS'),'index.php?option=com_bookpro&view=coupons');
		
		AImporter::model('applications');
		$omodel = new BookProModelApplications();
		$items = $omodel->getData();
		foreach ($items as $item){
			if($item->state==1){
				$views=explode(';', $item->views);
				
				if(count($views))
					for ($j=0;$j < count($views);$j++){
					
					JHtmlSidebar::addEntry(JText::_('COM_BOOKPRO_'.strtoupper($views[$j])),JRoute::_(ARoute::view($views[$j])));
				}
			}
		}
		echo JHtmlSidebar::render();
		echo '</div>';


	}

}

