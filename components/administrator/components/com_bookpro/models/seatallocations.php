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
class BookProModelSeatallocations extends JModelList
{
    
 	public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'l.id',
                
            );
        }
        parent::__construct($config);
    }

    protected function populateState($ordering = null, $direction = null) {
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search','');
        $route_id = $this->getUserStateFromRequest($this->context . '.filter.route_id', 'filter_route_id','');
        $route_id = $this->getUserStateFromRequest($this->context . '.filter.agent_id', 'filter_agent_id','');
        $depart_date = $this->getUserStateFromRequest($this->context . '.filter.depart_date', 'filter_depart_date','');
        $children = $this->getUserStateFromRequest($this->context . '.filter.children', 'filter_children','');
        $pay_status = $this->getUserStateFromRequest($this->context . '.filter.pay_status', 'filter_pay_status','');
		//
        $this->setState('filter.pay_status', $pay_status);
        $this->setState('filter.search', $search);
        $this->setState('filter.route_id', $route_id);
        $this->setState('filter.children', $children);
        $this->setState('filter.depart_date', $depart_date);
        
        $this->setState('filter.state', $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_state', '', 'string'));
        parent::populateState('firstname', 'ASC');
    }
    
    function getListQuery(){
//     	$db = $this->getDbo ();
//     	$query = $db->getQuery ( true );
//     	$query->select('a.id,a.route_id,a.start,a.firstname,a.seat,b.from,b.to,b.route,c.block_layout,d.company');
//     	$query->from('#__bookpro_passenger a');
 		
//      	$query->join('LEFT', '#__bookpro_bustrip as b ON b.id=a.route_id');
//     	$query->join('LEFT', '#__bookpro_bus_seattemplate as c ON c.id=b.seat_layout_id');
//     	$query->join('LEFT', '#__bookpro_agent as d ON d.id=b.agent_id');
//     	$agent_id=$this->getState('filter.agent_id');
//     	$route_id=$this->getState('filter.route_id');
//     	$depart_date=$this->getState('filter.depart_date');
// 		$filter_children=$this->getState('filter.children');

//     	if($agent_id){
//     		$query->where('b.agent_id='.$agent_id);
//     	}
//     	if($depart_date){
//     		$query->where('a.start='.$db->quote(JFactory::getDate($depart_date)->toSql()));
//     	}   	
//     	if($filter_children == 1){	
//     		$query->where('a.route_id='.$route_id);
//     	}else{
//     		$ids=$this->getAllId();
    		
//     		$id = implode($ids,"," );
//     		$query->where('a.route_id IN ('.$id.')');
//     	}
//     	return $query;

    	
    AImporter::helper('paystatus');
    	PayStatus::init();
    	AImporter::model('bustrip');
    	AImporter::helper('bus');
        $db = $this->getDbo();
        
        $query1 = $db->getQuery(true);
        $route_id = $this->getState('filter.route_id');
        
        $model = new BookProModelBusTrip();
        $bustrip = $model->getObjectFullById($route_id);
        $parent_id = BusHelper::getBustripParent($route_id);
      
        $children = $this->getState('filter.children');
      
        $date = $this->getState('filter.depart_date');
        $query1->select('seattemplate.block_layout,r.*,c.title AS group_title,r.return_start AS start_date,r.return_seat AS seat_number,r.price AS sprice');
        $query1->select('CONCAT(`rdest1`.`title`,'.$db->quote('-').',`rdest2`.`title`) AS triptitle ');
        $query1->select('order1.order_number,rbustrip.code AS tripcode');
        $query1->from('#__bookpro_passenger AS r');
        $query1->join('LEFT', '#__bookpro_cgroup AS c ON c.id = r.group_id');
        $query1->join('LEFT', '#__bookpro_bustrip AS rbustrip ON rbustrip.id = r.return_route_id');
        $query1->join('LEFT', '#__bookpro_dest AS rdest1 ON rbustrip.from = rdest1.id');
        $query1->join('LEFT', '#__bookpro_dest AS rdest2 ON rbustrip.to = rdest2.id');
        $query1->join('LEFT', '#__bookpro_orders AS order1 ON order1.id = r.order_id');
       $query1->join('LEFT', '#__bookpro_bus_seattemplate as seattemplate ON seattemplate.id=rbustrip.seat_layout_id');
        
        if ($route_id) {
        	$where1 = array();
        	if ($children) {
        		$query1->where('(rbustrip.parent_id='.$parent_id.' OR rbustrip.id='.$parent_id.')');
        		
        	}else{
        		$query1->where('r.return_route_id='.$route_id);
        	}	
        	
        	
        }
        if ($date) {
        	$query1->where('r.return_start='.$db->quote(JFactory::getDate($date)->toSql()));
        }
        $query1->where('`order1`.`pay_status`='.$db->quote(PayStatus::$SUCCESS->getValue()));
        
        
        $query = $db->getQuery(true);
        $query->select('seattemplate.block_layout,l.*,c.title AS group_title,`l`.`start` AS start_date,l.seat AS seat_number,l.return_price AS sprice');
        $query->select('CONCAT(`dest1`.`title`,'.$db->quote('-').',`dest2`.`title`) AS triptitle ');
        
        $query->select('order.order_number,bustrip.code AS tripcode');
        $query->from('#__bookpro_passenger AS l');
        $query->join('LEFT', '#__bookpro_cgroup AS c ON c.id = l.group_id');
        $query->join('LEFT', '#__bookpro_bustrip AS bustrip ON bustrip.id = l.route_id');
        $query->join('LEFT', '#__bookpro_dest AS dest1 ON bustrip.from = dest1.id');
        $query->join('LEFT', '#__bookpro_dest AS dest2 ON bustrip.to = dest2.id');
        $query->join('LEFT', '#__bookpro_orders AS `order` ON `order`.`id` = l.order_id');
        
       $query->join('LEFT', '#__bookpro_bus_seattemplate as seattemplate ON seattemplate.id=bustrip.seat_layout_id');
        if ($route_id) {	
        	
        	if ($children) {
        		$query->where('(bustrip.parent_id='.$parent_id.' OR bustrip.id='.$parent_id.')');
        	}else{
        		$query->where('l.route_id='.$route_id);
        	}
        }
        if ($date) {
        	$query->where('l.start='.$db->quote(JFactory::getDate($date)->toSql()));
        }
        $pay_status = $this->getState('filter.pay_status');
        
        if($pay_status){
        	$query->where('order.pay_status='.$db->quote($pay_status));
        }
      	$sql1 = (string) $query1;
      	$sql = (string) $query;
      	
      	$usql = "($sql1) UNION ALL ($sql)";
      	
      
        return $usql;
    }
   	
    function getParentId(){
    	$route_id=$this->getState('filter.route_id');
    	$db = $this->getDbo ();
    	$query = $db->getQuery ( true );
	    	$query->select("a.parent_id");
	    	$query->from("#__bookpro_bustrip as a");
	    if($route_id){
	    	$query->where("a.id=".$route_id);
	    }
	    	
	    $db->setQuery($query);
	    $result = $db->loadObject();
	 
	    return $result;
    	
    }
    
    
    function getAllId(){
    	$route_id=$this->getState('filter.route_id');
    	$getParentId=$this->getParentId();
    	$parentId=$getParentId->parent_id;
     
	    if($parentId==0){
	    	$parentId=$route_id;
	    }
   
    	$db = $this->getDbo ();
    	$query = $db->getQuery ( true );
    	$query->select("a.id");
    	$query->from("#__bookpro_bustrip as a");
    	$query->where("parent_id=".$parentId.' or id='.$parentId);
    	$db->setQuery($query);
    	$result = $db->loadColumn();
    	return $result;
    }
    
  }

?>