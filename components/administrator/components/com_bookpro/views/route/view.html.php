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

AImporter::model('airports','bustrip');
AImporter::helper('bookpro','bus');

class BookProViewRoute extends JViewLegacy
{
   	
    function display($tpl = null)
    {
        $input = JFactory::getApplication()->input;
     
        $model = new BookProModelBusTrip();
        $obj = $model->getItem($input->get('id'));
       
        if($obj->parent_id==0){
        	$item= $obj;	
        }else{
        	
        	$model = new BookProModelBusTrip();
        	$item = $model->getItem($obj->parent_id);
        }
       
        $this->obj= $item;
        $this->destinations=$this->getRoute($item->route);
        parent::display($tpl);
	    }
  
    function getRoute($destination){
    	
    	$db		= JFactory::getDbo();
    	$query	= $db->getQuery(true);
    	$destination=str_replace(';', ',',$destination);
    	$query_arr='SELECT * FROM #__bookpro_dest WHERE id IN ('.$destination.')';
 		$db->setQuery($query_arr);
 		return 	$db->loadObjectList();	   	
    	
    }
    
    function getParentBox($select){
    		
    		
    	$options = array();
    	$db		= JFactory::getDbo();
    	$query	= $db->getQuery(true);
    		
    	$query->select('a.id as value, a.level,CONCAT(`dest1`.`title`,'.$db->quote('-').',`dest2`.`title`) AS `text`');
    	
    	$query->from('#__bookpro_bustrip AS a');
    	$query->join('LEFT', $db->quoteName('#__bookpro_dest').' AS dest1 ON a.from =  dest1.id');
    	$query->join('LEFT', $db->quoteName('#__bookpro_dest').' AS dest2 ON a.to =  dest2.id');
    
    	//$query->where('a.state IN (0,1)');
    	$query->where('a.parent_id =0');
    	//$query->group('a.id, a.title, a.level, a.lft, a.rgt, a.parent_id');
    	//$query->order('a.lft ASC');
    		
    	// Get the options.
    	$db->setQuery($query);
    		
    	$options = $db->loadObjectList();
    		
    	// Check for a database error.
    	if ($db->getErrorNum()) {
    		JError::raiseWarning(500, $db->getErrorMsg());
    	}
    		
    	// Pad the option text with spaces using depth level as a multiplier.
    	for ($i = 0, $n = count($options); $i < $n; $i++)
    	{
    	// Translate ROOT
    	
    	if ($options[$i]->level == 0) {
    	$options[$i]->text = JText::_('JGLOBAL_ROOT_PARENT');
    	}
    
    	$options[$i]->text = str_repeat('- ', $options[$i]->level).$options[$i]->text;
    	}
    	$options = array();
    	array_unshift($options, JHtml::_('select.option', 0, JText::_('JGLOBAL_ROOT')));
		
		return  JHtmlSelect::genericlist($options, 'parent_id','','value','text',$select);
		
    }
}

?>