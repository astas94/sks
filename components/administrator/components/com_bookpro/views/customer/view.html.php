<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: view.html.php 63 2012-07-29 10:43:08Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');



class BookProViewCustomer extends JViewLegacy
{

   	protected $form;
	protected $item;
	protected $state;	
    public function display($tpl = null)
    {
    	
    	// Initialise variables.
    	$this->form		= $this->get('Form');
    	$this->item		= $this->get('Item');
    	$this->state	= $this->get('State');
    	
    	// Check for errors.
    	if (count($errors = $this->get('Errors')))
    	{
    		JError::raiseError(500, implode("\n", $errors));
    		return false;
    	}
    	
    	$this->addToolbar();
    	parent::display($tpl);
       
    }
    
    protected function addToolbar() {
    	JFactory::getApplication()->input->set('hidemainmenu', true);
		$edit		= $this->item->id;
		$text = !$edit ? JText::_( 'JTOOLBAR_NEW' ) : JText::_( 'JACTION_EDIT' );
    	JToolbarHelper::title(JText::_('COM_BOOKPRO_CUSTOMER_MANAGER').': '.$text);
    	JToolbarHelper::save ( 'customer.save' );
    	JToolBarHelper::apply('customer.apply');
    	JToolbarHelper::cancel ('customer.cancel');

    }
    
	function getCountrySelectBox($select)
    {
        $model = new BookProModelCountries();
        $fullList = $model->getItems();
        return AHtml::getFilterSelect('country_id', JText::_('COM_BOOKPRO_SELECT_COUNTRY'), $fullList, $select, false, '', 'id', 'country_name');
    }
    
    function getCitySelectBox($select)
    {
    	AImporter::model('airports');
    	$model = new BookProModelAirports();
    	 
    	$state=$model->getState();
    	$state->set('list.start',0);
    	$state->set('list.limit', 0);
    	$state->set('list.state', 1);
    	$state->set('list.province', 1);
    	$state->set('list.parent_id', 1);
    	$fullList = $model->getItems();
    	 
    	return AHtml::getFilterSelect('city', JText::_('COM_BOOKPRO_SELECT_CITY'), $fullList, $select, false, '', 'id', 'title');
    	
    	
    }
    
    function getGroupSelectBox($select)
    {
    	$model = new BookProModelCGroups();
    	$fullList = $model->getData(array('state'=>1));
    	return AHtml::getFilterSelect('cgroup_id', JText::_('Group') , $fullList, $select, false, '', 'id', 'title');
    }
}

?>