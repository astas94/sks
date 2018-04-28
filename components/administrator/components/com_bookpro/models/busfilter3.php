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

class BookProModelBusFilter3 extends JModelList
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
////////S
        $depart_todate = $this->getUserStateFromRequest($this->context . '.filter.depart_todate', 'filter_depart_todate','');
////////E
        $children = $this->getUserStateFromRequest($this->context . '.filter.children', 'filter_children','');
        $pay_status = $this->getUserStateFromRequest($this->context . '.filter.pay_status', 'filter_pay_status','');
		//
        $this->setState('filter.pay_status', $pay_status);
        $this->setState('filter.search', $search);
        $this->setState('filter.route_id', $route_id);
        $this->setState('filter.children', $children);
        $this->setState('filter.depart_date', $depart_date);
////////S
        //return "";
        $this->setState('filter.depart_todate', $depart_todate);
////////E
        $this->setState('filter.agent_id', $agent_id);
        
        $this->setState('filter.state', $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_state', '', 'string'));
        parent::populateState('firstname', 'ASC');
    }
   	
    protected function getListQuery() {

    	AImporter::helper('orderstatus','date','bus');
    	OrderStatus::init();
    	AImporter::model('bustrip');
        $db = $this->getDbo();
        $route_id = $this->getState('filter.route_id');

	$route_id=0;
        
        if($route_id!=0){
                // Get parent ID if exist
                
                $model=new BookProModelBusTrip();
                $route=$model->getItem($route_id);
                //echo "<pre>";print_r($route);die;
                $parent_id=$route->parent_id?$route->parent_id:$route_id;
        }        
        ///
        
        $query1 = $db->getQuery(true);
                      
        $children = $this->getState('filter.children');
        
        $date = $this->getState('filter.depart_date');
        if ($date){
        	$date = JFactory::getDate(DateHelper::createFromFormat($date)->format('Y-m-d'))->format('Y-m-d');
        }

        $todate = $this->getState('filter.depart_todate');
        if ($todate){
        	$todate = JFactory::getDate(DateHelper::createFromFormat($todate)->format('Y-m-d'))->format('Y-m-d');
        }
       
        $query1->select('bus.title as title_bus,r.*,r.return_start AS start_date,c.title as group_title,od.created as created_order_date,od.pay_status as created_order_payment');
        $query1->select('CONCAT(`rdest1`.`title`,'.$db->quote('-').',`rdest2`.`title`) AS triptitle ');
        $query1->select('od.order_number,od.params AS oparams,rbustrip.code AS tripcode,od.return_seat as oseat');
        $query1->from('#__bookpro_passenger AS r');
        $query1->join('LEFT', '#__bookpro_cgroup AS c ON c.id = r.group_id');
        //if ($route_id!=0){
        $query1->join('LEFT', '#__bookpro_bustrip AS rbustrip ON rbustrip.id = r.return_route_id');
        //    }
        $query1->join('LEFT', '#__bookpro_dest AS rdest1 ON rbustrip.from = rdest1.id');
        $query1->join('LEFT', '#__bookpro_dest AS rdest2 ON rbustrip.to = rdest2.id');
        $query1->join('LEFT', '#__bookpro_orders AS od ON od.id = r.order_id');
        $query1->join('LEFT', '#__bookpro_bus as bus ON rbustrip.bus_id=bus.id');
        //$query1->join('LEFT', '#__bookpro_bus_seattemplate as seattemplate ON seattemplate.id=bus.seattemplate_id');
        
         
        	if ($children && $route_id!=0) {
        		$query1->where('(rbustrip.parent_id='.$parent_id.' OR rbustrip.id='.$parent_id.')');
        		//$query1->leftJoin('#__bookpro_bustrip AS parent ON parent.id = rbustrip.parent_id');
        		//$query1->where(' DATE_FORMAT(r.return_start,"%Y-%m-%d") BETWEEN '.$db->quote($date).' AND '.$db->quote($todate));
        		$query1->where(' DATE_FORMAT(od.created,"%Y-%m-%d") BETWEEN '.$db->quote($date).' AND '.$db->quote($todate));
        		
        	}else{
        		if ($route_id!=0){$query1->where('r.return_route_id='.$route_id);}
        		//$query1->where(' DATE_FORMAT(r.return_start,"%Y-%m-%d") BETWEEN '.$db->quote($date).' AND '.$db->quote($todate));
        		$query1->where(' DATE_FORMAT(od.created,"%Y-%m-%d") BETWEEN '.$db->quote($date).' AND '.$db->quote($todate));
        	}
        	$query1->where('od.pay_status <> "PENDING"');
        	        	
        
      
        //$query1->where('od.order_status='.$db->quote(OrderStatus::$CONFIRMED->getValue()));

        //echo $query1->dump();
       
        $query = $db->getQuery(true);
        $query->select('bus.title as title_bus,l.*,`l`.`start` AS start_date,c.title as group_title,od.created as created_order_date,od.pay_status as created_order_payment');
        $query->select('CONCAT(`dest1`.`title`,'.$db->quote('-').',`dest2`.`title`) AS triptitle ');
        
        $query->select('od.order_number,od.params as oparams,bustrip.code AS tripcode,od.seat AS oseat');
        $query->from('#__bookpro_passenger AS l');
        $query->join('LEFT', '#__bookpro_cgroup AS c ON c.id = l.group_id');
        //if ($route_id!=0) {
        $query->join('LEFT', '#__bookpro_bustrip AS bustrip ON bustrip.id = l.route_id');
        //    }
        $query->join('LEFT', '#__bookpro_dest AS dest1 ON bustrip.from = dest1.id');
        $query->join('LEFT', '#__bookpro_dest AS dest2 ON bustrip.to = dest2.id');
        $query->join('LEFT', '#__bookpro_orders AS od ON od.id = l.order_id');
        $query->join('LEFT', '#__bookpro_bus as bus ON bustrip.bus_id=bus.id');
        //$query->join('LEFT', '#__bookpro_bus_seattemplate as seattemplate ON seattemplate.id=bus.seattemplate_id');
        
        	
        	
        	if ($children && $route_id!=0) {
        		$query->where('(bustrip.parent_id='.$parent_id.' OR bustrip.id='.$parent_id.')');
        	}else{
        		if ($route_id!=0){$query->where('l.route_id='.$route_id);}
        	}
        
        if ($date) {
        	
        	//DATE_FORMAT(`r`.`date`,"%Y-%m-%d")='.$this->_db->quote($depart_date)
        	//$query->where(' DATE_FORMAT(l.start,"%Y-%m-%d") BETWEEN '.$db->quote($date).' AND '.$db->quote($todate));
        	$query->where(' DATE_FORMAT(od.created,"%Y-%m-%d") BETWEEN '.$db->quote($date).' AND '.$db->quote($todate));
        	$query->where('od.pay_status <> "PENDING"');
        }
        $pay_status = $this->getState('filter.pay_status');
        
       if($pay_status){
        	$query->where('od.pay_status='.$db->quote($pay_status));
       }

        //
        //$query->where('od.order_status='.$db->quote(OrderStatus::$CONFIRMED->getValue()));
     
      	//$query->unionAll($query1);
      	$sql1 = (string) $query1;
      	$sql = (string) $query;
      
      	$usql = "($sql1) UNION ALL ($sql)";
      //	$result000 = mysqli_query($db,$usql);
      //  var_dump($usql);

        return $usql;
        
    }
    
    function getItems2() {
        // Get a storage key.
        //$store = $this->getStoreId();

        // Try to load the data from internal storage.
        //if (isset($this->cache[$store])) {
         //   return $this->cache[$store];
        //}
        $query = $this->getListQuery();
        $this->query = $query;
        $db = JFactory::getDbo();
        $db->setQuery($query);
        
        echo("----------------------");
        $rows = $db->loadObjectList();
        echo("----------------------");
        $this->cache[$store] = $rows;
        $this->_items = $rows;
        //var_dump ($rows[0]);
        //echo ($rows);

        return $rows;
    }
    
    
    function getItems(){
    	$route_id = $this->getState('filter.route_id');
    	$items = parent::getItems();
    	//$items = $this->getItems2();
    	
    	//echo $route_id;
	//echo $items;
    	if(count($items)>0)
    		foreach ($items as $item){
    		
    		if(($route_id==$item->route_id)||($route_id==0)){
    			 $item->aseat=$item->seat?$item->seat:$item->oseat;
    		}else {//if($route_id==$subject->return_route_id){
			
    			 //$item->aseat=$item->return_seat?$item->return_seat:$item->oreturn_seat;
				 $item->aseat=$item->seat?$item->seat:$item->oseat;
    		}
    		if (property_exists($item, 'oparams'))
    		{
    			$registry = new Joomla\Registry\Registry;
    			$registry->loadString($item->oparams);
    			$item->oparams = $registry->toArray();
    		}
    		if (($item->route_id == $route_id)||($route_id==0)){
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
    	//var_dump ($items);
    	return $items;
    }
    
    
  
    
  }

?>