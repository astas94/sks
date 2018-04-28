<?php

/**
 * @version     1.0.0
 * @package     com_bookpro
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ngo <quannv@gmail.com> - http://joombooking.com
 */
defined('_JEXEC') or die;

class BookproModelBusstops extends JModelList {

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
                'bustrip_id', 'a.bustrip_id',
                'location', 'a.location',
                
                'type', 'a.type',
            	'state', 'a.state',
                'ordering', 'a.location',

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
        $app = JFactory::getApplication();
        
        $bustrip_id = $app->getUserStateFromRequest($this->context . '.filter.bustrip_id', 'filter_bustrip_id');
       
        $this->setState('filter.bustrip_id', $bustrip_id);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', 1, 'int');
        $this->setState('filter.state', $published);
	
        
        $type = $app->getUserStateFromRequest($this->context . '.filter.type', 'filter_type', '', 'string');
        $this->setState('filter.type', $type);
        // List state information.
        parent::populateState('a.depart', 'asc');
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
        $query->select ( 'CONCAT(`a`.`location`,' . $this->_db->quote ( '-' ) . ',`a`.`depart`) AS title' );
        $query->from('`#__bookpro_busstop` AS a');
        
		// Join over the foreign key 'agent_id'
	
        $bustrip_id = $this->getState('filter.bustrip_id');
        if ($bustrip_id){
        	$query->where('bustrip_id='.$bustrip_id);
        }
 		
        $type = $this->getState('filter.type');
        if ($type){
        	$query->where('type='.$type);
        }
        
        
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

   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

}
