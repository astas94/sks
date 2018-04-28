<?php

/**
 * @version     1.0.0
 * @package     com_bookpro
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ngo <quannv@gmail.com> - http://joombooking.com
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Bookpro records.
 */
class BookproModelBuses extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                                'id', 'a.id',
                'agent_id', 'a.agent_id',
                'title', 'a.title',
                'seat', 'a.seat',
                'bus_type', 'a.bus_type',
                'seattemplate_id', 'a.seattemplate_id',
                'seat_number', 'a.seat_number',
                'desc', 'a.desc',
                'state', 'a.state',
                'image', 'a.image',
                'code', 'a.code',
                'child_price', 'a.child_price',
                'created_by', 'a.created_by',
                'modified_by', 'a.modified_by',
                'ordering', 'a.ordering',

            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        

        // Load the parameters.
        $params = JComponentHelper::getParams('com_bookpro');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.id', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select('a.*');
        $query->from('`#__bookpro_bus` AS a');

        
		// Join over the foreign key 'agent_id'
		$query->select('agent.company AS company');
		$query->join('LEFT', '#__bookpro_agent AS agent ON agent.id = a.agent_id');
		// Join over the foreign key 'seattemplate_id'
		$query->select('template.title AS seattemplates_title');
		$query->join('LEFT', '#__bookpro_bus_seattemplate AS template ON template.id = a.seattemplate_id');

 
		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.state = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(a.state IN (0, 1))');
		}

    
        


        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    public function getItems() {
    	$items = parent::getItems();
    
    	foreach ($items as $oneItem) {  
    		if (isset($oneItem->facility)) {
    			//$values = explode(',', $oneItem->facility);
    			if ($oneItem->facility !=""){
    				$db= JFactory::getDbo();
    				$query= $db->getQuery(true);
    				$query->select('fac.title');
    				$query->from('#__bookpro_facility AS fac');
    				$query->where('fac.id IN ('.$oneItem->facility.')');
    				$db->setQuery($query);
    				$textValue = $db->loadColumn();
    			}else{
    				$textValue = array();
    			}
    			$oneItem->facility = !empty($textValue) ? implode(', ', $textValue) : $oneItem->facility;
    		}
    	}
    	return $items;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

}
