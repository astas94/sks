<?php
/**
 * @version     1.0.0
 * @package     com_bookpro
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ngo <quannv@gmail.com> - http://joombooking.com
 */

// No direct access.
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controlleradmin');

/**
 * Buses list controller class.
 */
class BookproControllerSeatTemplates extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Seattemplate', $prefix = 'BookproModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
    
    public function dublicatebus() 
    {
    //die;
        $this->setredirect('index.php?option=com_bookpro&view=seattemplates');
        $db = JFactory::getDbo();
	    $mainframe = JFactory::getApplication ();
		$input = JFactory::getApplication ()->input;
		$room_id = $input->get ( 'idval' );
		$db->transactionStart ();
    		$query = $db->getQuery(true);
    	    $query->select('*');
            $query->from($db->quoteName('#__bookpro_bus_seattemplate'));
            $query->where ( $db->quoteName('id').'=' . $room_id );
            $db->setQuery($query);
    		$result = $db->loadObject();
    		//var_dump ($result);die;
    		
		    $query = $db->getQuery(true);
            $columns = array('title', 'block_layout');
            $values = array($db->quote($result->title.' копия'), $db->quote($result->block_layout));
            $query
                ->insert($db->quoteName('#__bookpro_bus_seattemplate'))
                ->columns($db->quoteName($columns))
                ->values(implode(',', $values));
             
            //var_dump($query->dump());die;
            $db->setQuery($query);
            $db->execute();
		
		
		$db->transactionCommit ();
		//echo($room_id);die;
	}
	
    
    
}