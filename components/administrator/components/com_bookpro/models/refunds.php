<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: airlines.php 102 2012-08-29 17:33:02Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');

//import needed JoomLIB helpers
jimport('joomla.application.component.modellist');

class BookProModelRefunds extends JModelList
{
    
	public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'refund.id',
                'refund.number_hour',
            );
        }
        parent::__construct($config);
    }

    /**
     * Get MySQL loading query for customers list
     * 
     * @return string complet MySQL query
     */
    protected function populateState($ordering = null, $direction = null) {
    	$app = JFactory::getApplication();
    	$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
    	$this->setState('filter.search', $search);
    	$this->setState('filter.state', $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_state', '', 'string'));
    	$value = $this->getUserStateFromRequest($this->context.'.ordercol', 'filter_order', $ordering);
    	$this->setState('list.ordering', $value);
    	$value = $this->getUserStateFromRequest($this->context.'.orderdirn', 'filter_order_Dir', $direction);
    	$this->setState('list.direction', $value);
    	parent::populateState('refund.number_hour', 'DESC');
    }
    protected function getListQuery() {
    	$db = $this->getDbo();
    	$query = $db->getQuery(true);
    	$query->select('refund.*')->from('#__bookpro_refund AS refund');
    	$query->order($db->escape($this->state->get('list.ordering', 'refund.number_hour').' '.$this->state->get('list.direction', 'asc')));
    	return $query;
    }
   

  }

?>