<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: orders.php 56 2012-07-21 07:53:28Z quannv $
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );

class BookProModelPmiBustrips extends JModelList
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
        $agent_id = $this->getUserStateFromRequest($this->context . '.filter.agent_id', 'filter_agent_id','');
        $depart_date = $this->getUserStateFromRequest($this->context . '.filter.depart_date', 'filter_depart_date','');
        $children = $this->getUserStateFromRequest($this->context . '.filter.children', 'filter_children','');
        $pay_status = $this->getUserStateFromRequest($this->context . '.filter.pay_status', 'filter_pay_status','');
		//
        $this->setState('filter.pay_status', $pay_status);
        $this->setState('filter.search', $search);
        $this->setState('filter.route_id', $route_id);
        $this->setState('filter.children', $children);
        $this->setState('filter.depart_date', $depart_date);
        $this->setState('filter.agent_id', $agent_id);
        
        $this->setState('filter.state', $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_state', '', 'string'));
        parent::populateState('firstname', 'ASC');
    }
   	
    protected function getListQuery() {
    	AImporter::helper('orderstatus','date','bus');
    	OrderStatus::init();
    	AImporter::model('bustrip');

        $route_id = $this->getState('filter.route_id');
        
        // Get parent ID if exist
        
        $model=new BookProModelBusTrip();
        $route=$model->getItem($route_id);
        $parent_id=$route->parent_id?$route->parent_id:$route_id;
        
        ///
        
        $children = $this->getState('filter.children');
        
        $date = $this->getState('filter.depart_date');
        if ($date){
        	$date = JFactory::getDate(DateHelper::createFromFormat($date)->format('Y-m-d'))->format('Y-m-d');
        }

	if($route_id)
	{
	        $db = $this->getDbo();
	        $query0 = $db->getQuery(true);
	        $query0->select('id,route,start_time,end_time,duration');
	        $query0->from('#__bookpro_bustrip');
		$query0->where('id = '.$parent_id);
		$db->setQuery($query0);
		$date_time = $db->loadObject();
	
		$date_time_start = $date." ".$date_time->start_time;

		if(strtotime($date_time->start_time) > strtotime($date_time->end_time))
		{
			$date = date( "Y-m-d", strtotime($date." +1 days" ));
		}

		$date_time_end = $date." ".$date_time->end_time;

	}

$test_depart = "2017-12-26 00:00:00";
$test_status = "CONFIRMED";

$db = $this->getDbo();
$query_test1 = $db->getQuery(true);
$query_test1->select('id,order_id,route_id,return_route_id,start,return_start,params,passenger_status,passenger_status_return,trigger_time');
$query_test1->from('#__bookpro_passenger');
$query_test1->where('return_start > '.$db->quote($test_depart));
$query_test1->where('passenger_status_return = '.$db->quote($test_status));
$query_test1->where('trigger_time < '.$db->quote($test_depart));
$db->setQuery($query_test1);
$test_result1 = $db->loadObjectList();

foreach($test_result1 as $test_array)
{
	$test_id = $test_array->id;

	$test_date = $test_array->return_start;

	$test_date = substr($test_date, 0, -9);

	$test_bustrip = $test_array->return_route_id;

	$db = $this->getDbo();
	$query_test2 = $db->getQuery(true);
	$query_test2->select('id,parent_id,start_time,end_time,duration');
	$query_test2->from('#__bookpro_bustrip');
	$query_test2->where('id = '.$test_bustrip);
	$db->setQuery($query_test2);
	$test_result2 = $db->loadObject();

	$test_date = $test_date." ".$test_result2->start_time;

	$query_test3 = $db->getQuery(true);
	$query_test3->update($db->quoteName('#__bookpro_passenger' ));
	$query_test3->set($db->quoteName('return_start').' = '.$db->quote($test_date));
	$query_test3->where($db->quoteName('id').' = '.$test_id);
	$db->setQuery($query_test3);
	$db->execute();
}

/*

$test_depart = "2017-12-26 00:00:00";
$test_status = "CONFIRMED";

$db = $this->getDbo();
$query_test1 = $db->getQuery(true);
$query_test1->select('id,order_id,route_id,return_route_id,start,return_start,params,passenger_status,passenger_status_return,trigger_time');
$query_test1->from('#__bookpro_passenger');
$query_test1->where('return_start > '.$db->quote($test_depart));
$query_test1->where('passenger_status_return = '.$db->quote($test_status));
$query_test1->where('trigger_time < '.$db->quote($test_depart));
$db->setQuery($query_test1);
$test_result1 = $db->loadObjectList();

foreach($test_result1 as $test_array)
{
	$test_id = $test_array->id;
	$test_date = $test_array->return_start;
	$test_date = substr($test_date, 0, -9);
	$test_bustrip = $test_array->return_route_id;

	$db = $this->getDbo();
	$query_test2 = $db->getQuery(true);
	$query_test2->select('id,parent_id,start_time,end_time,duration');
	$query_test2->from('#__bookpro_bustrip');
	$query_test2->where('id = '.$test_bustrip);
	$db->setQuery($query_test2);
	$test_result2 = $db->loadObject();

	$test_date = $test_date." ".$test_result2->start_time;

	$query_test3 = $db->getQuery(true);
	$query_test3->update($db->quoteName('#__bookpro_passenger' ));
	$query_test3->set($db->quoteName('return_start').' = '.$db->quote($test_date));
	$query_test3->where($db->quoteName('id').' = '.$test_id);
	$db->setQuery($query_test3);
	$db->execute();
}

*/

        $db = $this->getDbo();
        $query1 = $db->getQuery(true);       
        $query1->select('bus.title as title_bus,r.*,r.return_start AS start_date,c.title as group_title, r.return_price as zprice, r.return_seat as pseat');
        $query1->select('CONCAT(`rdest1`.`title`,'.$db->quote('-').',`rdest2`.`title`) AS triptitle ');
        $query1->select('od.order_number,od.params AS oparams,rbustrip.code AS tripcode,od.return_seat as oseat');
        $query1->from('#__bookpro_passenger AS r');
        $query1->join('LEFT', '#__bookpro_cgroup AS c ON c.id = r.group_id');
        $query1->join('LEFT', '#__bookpro_bustrip AS rbustrip ON rbustrip.id = r.return_route_id');
        $query1->join('LEFT', '#__bookpro_dest AS rdest1 ON rbustrip.from = rdest1.id');
        $query1->join('LEFT', '#__bookpro_dest AS rdest2 ON rbustrip.to = rdest2.id');
        $query1->join('LEFT', '#__bookpro_orders AS od ON od.id = r.order_id');
        $query1->join('LEFT', '#__bookpro_bus as bus ON rbustrip.bus_id=bus.id');
        //$query1->join('LEFT', '#__bookpro_bus_seattemplate as seattemplate ON seattemplate.id=bus.seattemplate_id');
        
        if ($route_id) {
        	if ($children) {
        		$query1->where('(rbustrip.parent_id='.$parent_id.' OR rbustrip.id='.$parent_id.')');
        		//$query1->leftJoin('#__bookpro_bustrip AS parent ON parent.id = rbustrip.parent_id');
        		$query1->where(' r.return_start BETWEEN '.$db->quote($date_time_start).' AND '.$db->quote($date_time_end));
        		
        	}else{
        		$query1->where('r.return_route_id='.$route_id);
        		$query1->where(' r.return_start BETWEEN '.$db->quote($date_time_start).' AND '.$db->quote($date_time_end));
        	}	
        	        	
        }
      
        $query1->where('r.passenger_status_return='.$db->quote(OrderStatus::$CONFIRMED->getValue()));

        //echo $query1->dump();
       
        $query = $db->getQuery(true);
        $query->select('bus.title as title_bus,l.*,`l`.`start` AS start_date,c.title as group_title, l.price as zprice, l.seat as pseat');
        $query->select('CONCAT(`dest1`.`title`,'.$db->quote('-').',`dest2`.`title`) AS triptitle ');
        
        $query->select('od.order_number,od.params as oparams,bustrip.code AS tripcode,od.seat AS oseat');
        $query->from('#__bookpro_passenger AS l');
        $query->join('LEFT', '#__bookpro_cgroup AS c ON c.id = l.group_id');
        $query->join('LEFT', '#__bookpro_bustrip AS bustrip ON bustrip.id = l.route_id');
        $query->join('LEFT', '#__bookpro_dest AS dest1 ON bustrip.from = dest1.id');
        $query->join('LEFT', '#__bookpro_dest AS dest2 ON bustrip.to = dest2.id');
        $query->join('LEFT', '#__bookpro_orders AS od ON od.id = l.order_id');
        $query->join('LEFT', '#__bookpro_bus as bus ON bustrip.bus_id=bus.id');
        //$query->join('LEFT', '#__bookpro_bus_seattemplate as seattemplate ON seattemplate.id=bus.seattemplate_id');
        
        if ($route_id) {	
        	
        	if ($children) {
        		$query->where('(bustrip.parent_id='.$parent_id.' OR bustrip.id='.$parent_id.')');
        	}else{
        		$query->where('l.route_id='.$route_id);
        	}
        }
        if ($date) {
        	
        	//DATE_FORMAT(`r`.`date`,"%Y-%m-%d")='.$this->_db->quote($depart_date)
        	$query->where(' l.start BETWEEN '.$db->quote($date_time_start).' AND '.$db->quote($date_time_end));
        }
        $pay_status = $this->getState('filter.pay_status');
        
        if($pay_status){
        	$query->where('od.pay_status='.$db->quote($pay_status));
        }
        //
        $query->where('l.passenger_status='.$db->quote(OrderStatus::$CONFIRMED->getValue()));
     
      	//$query->unionAll($query1);
      	$sql1 = (string) $query1;
      	$sql = (string) $query;
      
      	$usql = "($sql1) UNION ALL ($sql)";

        return $usql;
    }
    function getItems(){
    	$route_id = $this->getState('filter.route_id');
    	$items = parent::getItems();
    	
    	if(count($items)>0)
    		foreach ($items as $item){
    		
    		if($route_id==$item->route_id){
    			 $item->aseat=$item->seat?$item->seat:$item->oseat;
    			 $item->aseat=$item->pseat;
    		}else {//if($route_id==$subject->return_route_id){
			
    			 //$item->aseat=$item->return_seat?$item->return_seat:$item->oreturn_seat;
				 $item->aseat=$item->seat?$item->seat:$item->oseat;
	    			 $item->aseat=$item->pseat;
    		}
    		if (property_exists($item, 'oparams'))
    		{
    			$registry = new Joomla\Registry\Registry;
    			$registry->loadString($item->oparams);
    			$item->oparams = $registry->toArray();
    		}

    		if ($item->route_id == $route_id){
				$boarding_id=isset($item->oparams['chargeInfo']['onward']['boarding_id'])?$item->oparams['chargeInfo']['onward']['boarding_id']:null;  
				$dropping_id=isset($item->oparams['chargeInfo']['onward']['dropping_id'])?$item->oparams['chargeInfo']['onward']['dropping_id']:null;
    		}
			else {
    		//if ($item->return_route_id == $route_id){
			
				//$boarding_id=isset($item->oparams['chargeInfo']['return']['boarding_id'])?$item->oparams['chargeInfo']['onward']['boarding_id']:null;  
				//$dropping_id=isset($item->oparams['chargeInfo']['return']['dropping_id'])?$item->oparams['chargeInfo']['onward']['dropping_id']:null;
    			
    			$dropping_id=isset($item->oparams['chargeInfo']['return']['boarding_id'])?$item->oparams['chargeInfo']['onward']['boarding_id']:null;  
				$boarding_id=isset($item->oparams['chargeInfo']['return']['dropping_id'])?$item->oparams['chargeInfo']['onward']['dropping_id']:null;
    		}
    		AImporter::model('busstop');
    		$model=new BookProModelBusstop();
    		if (isset($boarding_id)){
    			$item->boarding = $model->getItem($boarding_id);
    		}
    		if (isset($dropping_id)){
    			$item->dropping = $model->getItem($dropping_id);
    		}
    		//var_dump($item);
    	}
    	
    	return $items;
    }
    
    
  
    
  }

?>