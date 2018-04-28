<?php


/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 27 2012-07-08 17:15:11Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');

//import needed JoomLIB helpers
jimport('joomla.application.component.modellist');

class BookProModelCoupons extends JModelList
{
    
	public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'coupon.id',
                'coupon.title',
            );
        }
        parent::__construct($config);
    }
    protected function populateState($ordering = null, $direction = null) {
    	$app = JFactory::getApplication();
    	$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
    	$this->setState('filter.search', $search);
    	$this->setState('filter.state', $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_state', '', 'string'));
    	$value = $this->getUserStateFromRequest($this->context.'.ordercol', 'filter_order', $ordering);
    	$this->setState('list.ordering', $value);
    	$value = $this->getUserStateFromRequest($this->context.'.orderdirn', 'filter_order_Dir', $direction);
    	$this->setState('list.direction', $value);
    	parent::populateState('coupon.title', 'DESC');
    }

    /**
     * Get MySQL loading query for customers list
     * 
     * @return string complet MySQL query
     */
    protected function getListQuery() {
    	$db = $this->getDbo();
    	$query = $db->getQuery(true);
    	$query->select('coupon.*')->from('#__bookpro_coupon AS coupon');
    	$query->order($db->escape($this->state->get('list.ordering', 'coupon.title').' '.$this->state->get('list.direction', 'asc')));
    	return $query;
    }
   

  }

?>