<?php
/**
* @version		$Id:passenger.php 1 2014-03-15 18:20:26Z Quan $
* @package		Bookpro1
* @subpackage 	Views
* @copyright	Copyright (C) 2014, Ngo Van Quan. All rights reserved.
* @license #http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
AImporter::helper('orderstatus');
class BookproViewpassengers  extends JViewLegacy {


	protected $items;

	protected $pagination;

	protected $state;
	
	
	/**
	 *  Displays the list view
 	 * @param string $tpl   
     */
	public function display($tpl = null)
	{
		
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		$input=JFactory::getApplication()->input;

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		$agent_id=JFactory::getApplication()->getUserStateFromRequest('agent_id', 'agent_id');
		$this->agents=$this->getAgentSelectBox($agent_id);
		parent::display($tpl);
	}
	function getAgentSelectBox($select){
		AImporter::model('agents');
		$model=new BookProModelAgents();
		$items=$model->getItems();
		return AHtml::getFilterSelect('agent_id', JText::_('COM_BOOKPRO_SELECT_AGENT'), $items, $select, true, '', 'id', 'brandname');
	}
	
	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 */
	protected function addToolbar()
	{
		
			JToolBarHelper::editList('passenger.edit');
			JToolbarHelper::deleteList('', 'passengers.delete', 'JTOOLBAR_DELETE');
			JToolBarHelper::title('Passenger list');
				
					
	}	
	

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 */
	protected function getSortFields()
	{
		return array(
	     	          'a.firstname' => JText::_('Firstname'),
	     	          'a.lastname' => JText::_('Lastname'),
	     	          'a.gender' => JText::_('Gender'),
	     	          'a.age' => JText::_('Age'),
	     	          'a.id' => JText::_('JGRID_HEADING_ID'),
	     		);
	}	
}
?>
