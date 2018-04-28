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


AImporter::helper('bookpro', 'request');

class BookProViewSeattemplate extends JViewLegacy
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
		JRequest::setVar('hidemainmenu', true);
		JToolBarHelper::title("SEAT LAYOUT");
		JToolBarHelper::apply('seattemplate.apply');
		JToolBarHelper::save('seattemplate.save');
		JToolBarHelper::cancel('seattemplate.cancel');
	
	
		JHtml::_('behavior.modal','a.jbmodal');
		JHtml::_('behavior.formvalidation');
	}
	
	
	
}

?>