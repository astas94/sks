<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: view.html.php 26 2012-07-08 16:07:54Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');

class BookProViewApplications extends JViewLegacy
{
	public function display($tpl = null){
		//get data from database into items
		$this->items = $this->get('Items');
		$this->state = $this->get('State');		
		$this->pagination = $this->get('Pagination');	
		
		if (count($error = $this->get('Errors'))){
			JError::raiseError(500, implode ("\n", $errors));
			return false;
		}
	
		$this->addToolbar();
		
		parent::display($tpl);
	}
	
	protected function addToolbar(){
		JToolBarHelper::title(JText::_('COM_BOOKPRO_APPLICATION_MANAGER'),'grid-view ');
		//JToolbarHelper::addNew('application.add');		
		JToolbarHelper::editList('application.edit');		
		JToolbarHelper::publish('applications.publish', 'JTOOLBAR_PUBLISH', true);
		JToolbarHelper::unpublish('applications.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		
		
	}
	
	protected function getSortFields()
	{
		return array(
				'a.state' => JText::_('JSTATUS'),
				'a.code' => JText::_('Code'),
				'a.title' => JText::_('JGLOBAL_TITLE'),
				'a.id' => JText::_('ID'),
		);
	}
   
}

?>