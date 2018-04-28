<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: view.html.php 81 2012-08-11 01:16:36Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');


AImporter::helper('bookpro','bus');

class BookProViewBusTrip extends JViewLegacy
{
   	
    function display($tpl = null)
    {
    	$this->form		= $this->get('Form');
    	$this->item		= $this->get('Item');
    	$this->state	= $this->get('State');
    	$this->addToolbar();
    	parent::display($tpl);
       
    }
    protected function addToolbar()
    {
    	JToolBarHelper::title(JText::_('COM_BOOKPRO_BUSTRIP'), 'bus');
    	JToolBarHelper::apply('bustrip.apply');
    	JToolBarHelper::save('bustrip.save');
    	JToolBarHelper::cancel('bustrip.cancel');
    }
    
}

?>