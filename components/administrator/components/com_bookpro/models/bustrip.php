<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bustrip.php 14 2012-06-26 12:42:05Z quannv $
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );

AImporter::helper ( 'bookpro' );
class BookProModelBusTrip extends JModelAdmin {
	public function getForm($data = array(), $loadData = true) {
		$form = $this->loadForm ( 'com_bookpro.bustrip', 'bustrip', array (
				'control' => 'jform',
				'load_data' => $loadData 
		) );
		if (empty ( $form ))
			return false;
		return $form;
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see JModelForm::loadFormData()
	 */
	protected function loadFormData() {
		$data = JFactory::getApplication ()->getUserState ( 'com_bookpro.edit.bustrip.data', array () );
		if (empty ( $data ))
			$data = $this->getItem ();
		return $data;
	}
	protected function populateState() {
		$table = $this->getTable ();
		$key = $table->getKeyName ();
		
		// Get the pk of the record from the request.
		
		$pk = JFactory::getApplication ()->input->getInt ( $key );
		if ($pk) {
			$this->setState ( $this->getName () . '.id', $pk );
		}
		
		// Load the parameters.
	}
	function getItem($pk = null) {
		$item = parent::getItem ( $pk );
		
		if ($item->id) {
			AImporter::model ( 'busstops' );
			$model = new BookproModelBusstops ();
			$state = $model->getState ();
			$state->set ( 'filter.bustrip_id', $item->id );
			$state->set ( 'filter.state', 1 );
			$stops = $model->getItems ();
			$item->busstops = $stops;
		}
		return $item;
	}
	function getComplexItem($pk = null, $date = null) {
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select ( 'bustrip.*' );
		$query->select ( 'CONCAT(`dest1`.`title`,' . $this->_db->quote ( ' - ' ) . ',`dest2`.`title`) AS title' );
		$query->from ( '#__bookpro_bustrip AS bustrip' );
		$query->select ( 'agent.company,agent.brandname,agent.desc,agent.image as agent_logo' );
		$query->join ( 'LEFT', '#__bookpro_agent AS agent ON agent.id = bustrip.agent_id' );
		$query->select ( 'bus.title AS bus_name' );
		$query->join ( 'LEFT', '#__bookpro_bus AS bus ON bus.id = bustrip.bus_id' );
		$query->select ( 'seattemplate.block_layout AS block_layout' );
		$query->join ( 'LEFT', '#__bookpro_bus_seattemplate AS seattemplate ON `seattemplate`.`id` = `bus`.`seattemplate_id`' );
		$query->select ( 'dest1.title AS from_name' );
		$query->join ( 'LEFT', '#__bookpro_dest AS dest1 ON bustrip.from = dest1.id' );
		$query->select ( 'dest2.title AS to_name' );
		$query->join ( 'LEFT', '#__bookpro_dest AS dest2 ON bustrip.to = dest2.id' );
		$query->where ( 'bustrip.id = ' . $pk );
		$db->setQuery ( $query );
		$bustrip = $db->loadObject ();

		if ($bustrip->id) {

			$query = $db->getQuery ( true );
			$query->select ( '*' )->from ( '#__bookpro_busstop' )->where ( 'bustrip_id=' . $pk );
			$query->order ( 'depart' );
			$db->setQuery ( $query );
			$bustrip->stations = $db->loadAssocList ( 'id' );
		}
		if ($date) {
			$db = JFactory::getDbo ();
			$query = $db->getQuery ( true );
			$query->select ( 'rate.*' );
			$query->from ( '#__bookpro_roomrate AS rate' );
			$query->where ( 'rate.room_id=' . $pk );
			//$query->where ( 'DATE_FORMAT(rate.date,"%Y-%m-%d")=' . $db->quote ( JFactory::getDate ( $date )->format ( 'Y-m-d' ) ) );
$query->where (' STR_TO_DATE('.$db->quote(JFactory::getDate ( $date )->format('Y-m-d H:i:s')).', '.$db->quote('%Y-%m-%d %H:%i:%s').') BETWEEN rate.date AND rate.date_end' );
			$db->setQuery ( $query );
			$price = $db->loadObject ();
			$bustrip->price = $price;
		}
		return $bustrip;
	}
	
	function getComplexRoute($parent_id, $route_arr) {
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
        $bustrip = null;
        //var_dump ($route_arr);die;
        foreach ($route_arr as $arr_item){
			$query = $db->getQuery ( true );
			$query->select ( 'start_time' )->from ( '#__bookpro_bustrip' )->where ( '( '.$db->quoteName('parent_id').'=' . $parent_id . ' OR ' .$db->quoteName('id').'=' . $parent_id . ' ) AND '.$db->quoteName('from').'=' . $arr_item);
			//$query->order ( 'start_time' );
			$db->setQuery ( $query );
			//$bustrip = $db->loadObjectList (  );
			$bustrip==null? $bustrip=array($db->loadObject ()) :  array_push($bustrip,  $db->loadObject ());
        }
        //var_dump ($bustrip);die;
		return $bustrip;
	}
	
	function getComplexRoute2($parent_id, $route_arr) {
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
        $bustrip = null;
        //var_dump ($route_arr);die;
        foreach ($route_arr as $arr_item){
			$query = $db->getQuery ( true );
			$query->select ( 'end_time' )->from ( '#__bookpro_bustrip' )->where ( '( '.$db->quoteName('parent_id').'=' . $parent_id . ' OR ' .$db->quoteName('id').'=' . $parent_id . ' ) AND '.$db->quoteName('to').'=' . $arr_item);
			//$query->order ( 'start_time' );
			$db->setQuery ( $query );
			//$bustrip = $db->loadObjectList (  );
			$bustrip==null? $bustrip=array($db->loadObject ()) :  array_push($bustrip,  $db->loadObject ());
        }
        //var_dump ($bustrip);die;
		return $bustrip;
	}
	
	function getComplexReturnRoute($parent_id, $route_arr) {
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$bustrip = null;
        foreach ($route_arr as $arr_item){
			$query = $db->getQuery ( true );
			$query->select ( 'start_time' )->from ( '#__bookpro_bustrip' )->where ( 'associated_parent_id=' . $parent_id . ' AND '.$db->quoteName('from').'=' . $arr_item);
			//$query->order ( 'start_time DESC' );
			$db->setQuery ( $query );
			$temp=$db->loadObject ();
			if ($temp!=null){
			    $bustrip==null? $bustrip=array($db->loadObject ()) :  array_push($bustrip,  $db->loadObject ());
			}
        }	
			$query = $db->getQuery ( true );
			$query->select ( 'end_time' )->from ( '#__bookpro_bustrip' )->where ( 'associated_parent_id=' . $parent_id . ' AND parent_id=0' );
			//$query->order ( 'start_time DESC' );
			$db->setQuery ( $query );
			$temp=$db->loadObject ();
			if ($temp!=null){
			    array_push($bustrip,  $temp);
			}

        //var_dump ($bustrip);die;
		return $bustrip;
	}
	
	function getComplexReturnRoute2($parent_id, $route_arr) {
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$bustrip = null;
        foreach ($route_arr as $arr_item){
			$query = $db->getQuery ( true );
			$query->select ( 'end_time' )->from ( '#__bookpro_bustrip' )->where ( 'associated_parent_id=' . $parent_id . ' AND '.$db->quoteName('to').'=' . $arr_item);
			//$query->order ( 'start_time DESC' );
			$db->setQuery ( $query );
			$temp=$db->loadObject ();
			if ($temp!=null){
			    $bustrip==null? $bustrip=array($db->loadObject ()) :  array_push($bustrip,  $db->loadObject ());
			}
        }	
			//$query = $db->getQuery ( true );
			//$query->select ( 'end_time' )->from ( '#__bookpro_bustrip' )->where ( 'associated_parent_id=' . $parent_id . ' AND parent_id=0' );
			//$query->order ( 'start_time DESC' );
			//$db->setQuery ( $query );
			//array_push($bustrip,  $db->loadObject ());

        //var_dump ($bustrip);die;
		return $bustrip;
	}
	
	function save($data) {
	    //var_dump($data["id"]);
		if (! parent::save ( $data )) {
			return false;
		}
		$db = JFactory::getDbo ();
		$db->transactionStart ();
    	    $query = $db->getQuery ( true );
    
            $fields = array(
                $db->quoteName('bus_id') . ' = ' . $db->quote($data["bus_id"])
            );
            $conditions = array(
                '('.$db->quoteName('id') . ' = '. $db->quote($data["id"]) . ' OR ' .$db->quoteName('parent_id') . ' = '. $db->quote($data["id"]) . ')'
            );
            $query->update($db->quoteName('#__bookpro_bustrip'))->set($fields)->where($conditions);
    
            $db->setQuery($query);
            //echo ($query->dump());
            $db->execute();
        $db->transactionCommit ();
		
		//echo "<pre>";print_r($data);die;
		//TODO: Update record and add new is seperately
		$bustrip_id=$this->getState()->get('bustrip.id');
		//echo $bustrip_id;die;
		$busstops = JFactory::getApplication ()->input->post->get ( 'busstop', array (), 'array' );
		
		
		try {
			
			$db->transactionStart ();
			$query = $db->getQuery ( true );
			$query->delete ( '#__bookpro_busstop' )->where ( 'bustrip_id=' . $bustrip_id );
			$db->setQuery ( $query );
			$db->execute ();
			
			$query = $db->getQuery ( true );
			$query->insert ( '#__bookpro_busstop' );
			$query->columns ( 'id,bustrip_id,type,location,depart,price,state' );
			$values = array ();
			
			$ids = $busstops ['id'];
			$type = $busstops ['type'];
			
			JArrayHelper::toInteger($type);
			
				
			for($i = 0; $i < count ( $type ); $i ++) {
				if ($type [$i] > 0) {
					$temp = array (
							$ids [$i],
							$bustrip_id,
							$type [$i],
							$db->quote ( $busstops ['location'] [$i] ),
							$db->quote ( $busstops ['depart'] [$i] ),
							$db->quote($busstops ['price'] [$i]),
							1 
					);
					$values [] = implode ( ',', $temp );
				}
			}
			
			if(count($values)>0){
				$query->values ( $values );
				$db->setQuery ( $query );
				$db->execute ();
			}
			$db->transactionCommit ();
		} catch ( Exception $e ) {
			
			$db->transactionRollback ();
			JErrorPage::render($e);
			return false;
		}
		
		return true;
	}
	function getBookingTrip($params) {
		AImporter::model ( 'busstop' );
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select ( 'bustrip.*' );
		$query->select ( 'CONCAT(`dest1`.`title`,' . $this->_db->quote ( ' - ' ) . ',`dest2`.`title`) AS title' );
		$query->from ( '#__bookpro_bustrip AS bustrip' );
		$query->select ( 'agent.company,agent.brandname,agent.desc,agent.image as agent_logo' );
		$query->join ( 'LEFT', '#__bookpro_agent AS agent ON agent.id = bustrip.agent_id' );
		$query->select ( 'bus.title AS bus_name' );
		$query->join ( 'LEFT', '#__bookpro_bus AS bus ON bus.id = bustrip.bus_id' );
		$query->select ( 'seattemplate.block_layout AS block_layout' );
		$query->join ( 'LEFT', '#__bookpro_bus_seattemplate AS seattemplate ON `seattemplate`.`id` = `bus`.`seattemplate_id`' );
		$query->select ( 'dest1.title AS from_name' );
		$query->join ( 'LEFT', '#__bookpro_dest AS dest1 ON bustrip.from = dest1.id' );
		$query->select ( 'dest2.title AS to_name' );
		$query->join ( 'LEFT', '#__bookpro_dest AS dest2 ON bustrip.to = dest2.id' );
		
		//echo ("test123".$params ['onward'] ['id']);
		//return 0;
		//echo ("------------");
		if ($params ['onward'] ['id']==null){
		    return null;
		}
		//var_dump($params ['onward'] ['id']);
		
		//return 0;
		$query->where ( 'bustrip.id = ' . $params ['onward'] ['id'] );
		$db->setQuery ( $query );
		$bustrip = $db->loadObject ();
		
		//return 0;
		$bustrip->booked_seat = $params ['onward'] ['seat'];
		$bustrip->depart_date = $params ['onward'] ['date'];
		$busstopModel = new BookProModelBusstop ();
		if (isset ( $params ['onward'] ['boarding_id'] ))
			$bustrip->boarding = $busstopModel->getItem ( $params ['onward'] ['boarding_id'] );
		if (isset ( $params ['onward'] ['dropping_id'] ))
			$bustrip->dropping = $busstopModel->getItem ( $params ['onward'] ['dropping_id'] );
		
		$bustrips [] = $bustrip;
		
		if (isset ( $params ['return'] ['id'] )) {
			$query->clear ( 'where' );
			if ($params ['return'] ['id']==null){
    		    return null;
    		}
			$query->where ( 'bustrip.id = ' . $params ['return'] ['id'] );
			$db->setQuery ( $query );
			$bustrip = $db->loadObject ();
			$bustrip->booked_seat = $params ['return'] ['seat'];
			$bustrip->depart_date = $params ['return'] ['date'];
			if (isset ( $params ['return'] ['boarding_id'] ))
				$bustrip->boarding = $busstopModel->getItem ( $params ['return'] ['boarding_id'] );
			if (isset ( $params ['return'] ['dropping_id'] ))
				$bustrip->dropping = $busstopModel->getItem ( $params ['return'] ['dropping_id'] );
			
			$bustrips [] = $bustrip;
		}
		
		return $bustrips;
	}
	public function publish(&$pks, $value = 1) {
		$user = JFactory::getUser ();
		$table = $this->getTable ();
		$pks = ( array ) $pks;
		
		// Attempt to change the state of the records.
		if (! $table->publish ( $pks, $value, $user->get ( 'id' ) )) {
			$this->setError ( $table->getError () );
			
			return false;
		}
		
		return true;
	}
	public function rebuild() {
		// Get an instance of the table object.
		$table = $this->getTable ();
		
		if (! $table->rebuild ()) {
			$this->setError ( $table->getError () );
			return false;
		}
		
		// Clear the cache
		$this->cleanCache ();
		
		return true;
	}
}

?>