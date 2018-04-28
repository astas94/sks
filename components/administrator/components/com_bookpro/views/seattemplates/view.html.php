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

AImporter::helper('route', 'bookpro');


class BookProViewSeattemplates extends JViewLegacy
{
    /**
     * Array containing browse table filters properties.
     * 
     * @var array
     */
    var $lists;
    
    /**
     * Array containig browse table subjects items to display.
     *  
     * @var array
     */
    var $items;
    
    /**
     * Standard Joomla! browse tables pagination object.
     * 
     * @var JPagination
     */
    var $pagination;
    
       
    /**
     * Sign if table is used to popup selecting customers.
     * 
     * @var boolean
     */
    var $selectable;
    
    /**
     * Standard Joomla! object to working with component parameters.
     * 
     * @var $params JParameter
     */
    var $params;

    /**
     * Prepare to display page.
     * 
     * @param string $tpl name of used template
     */
    function display($tpl = null)
    {
        
        
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');
       
       $this->addToolbar();
       // $dest=$this->getDestinationSelectBox( $this->lists['dest_id'],'dest_id');
       // $airlines=$this->getBustripSelectBox($this->lists['bustrip_id'],'bustrip_id');
       // $this->assignRef("dest",$dest);
       // $this->assignRef("bustrips",$airlines);
        parent::display($tpl);
    }
    protected function addToolbar()
    {
    
    	JToolBarHelper::title(JText::_('COM_BOOKPRO_BUSSTATION_MANAGER'), 'user.png');
    	JToolBarHelper::addNew('seattemplate.add');
    	JToolBarHelper::editList('seattemplate.edit');
    	$bar = JToolbar::getInstance('toolbar');
     
    	// Strip extension.
    	//$icon = preg_replace('#\.[^.]*$#', '', $icon);
 
	// Add a standard button.
//	$bar->appendButton('Дублировать', cancel, "Дублировать", 'duplicate', true);
	//$bar->appendButton( 'Link', 'cancel', 'Отмена', 'index.php?option=com_bookpro&view=roomrate3&bustrip_id='.$this->obj->id);
    	JToolBarHelper::divider();
    	
    	
    	JToolbarHelper::deleteList('', 'seattemplates.delete');
    	
    
    		
    }
  
}

?>