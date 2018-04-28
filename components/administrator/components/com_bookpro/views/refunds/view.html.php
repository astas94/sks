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

jimport('joomla.application.component.view');


class BookProViewRefunds extends JViewLegacy
{
	protected $items;
	
	protected $pagination;
	
	protected $state;
	
	/**
	 * Display the view
	 *
	 * @return  void
	 */

	
	
    function display($tpl = null)
    {
       $this->state		= $this->get('State');
		//$this->bustrip_id=JFactory::getApplication()->getUserStateFromRequest('bustrip_id','bustrip_id',0);
		$this->sortDirection = $this->state->get('list.direction');
		$this->sortColumn = $this->state->get('list.id');

		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
    }
    protected function getSortFields()
    {
    	return array(
    			'l.number_hour' => JText::_('JGRID_HEADING_ORDERING'),
    			'l.state' => JText::_('JSTATUS'),
    			'l.id' => JText::_('JGRID_HEADING_ID')
    	);
    }
    protected function addToolbar(){
    	JToolbarHelper::addNew('refund.add');
    	JToolbarHelper::editList('refund.edit');
    	JToolbarHelper::trash('refunds.delete');
    }
  
}
?>