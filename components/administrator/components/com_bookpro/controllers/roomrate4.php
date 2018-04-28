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
use Joomla\Registry\Format\Json;
use Joomla\Registry\Registry;
// import needed JoomLIB helpers

AImporter::model ( 'roomratelog', 'bustrip' );
class BookProControllerRoomRate4 extends JControllerLegacy 

{
    function deleteondate($ids,$datestartdate,$dateenddate,$db){
        for ($i = 0; $i < count($ids); $i++) {
		    
		    $query = $db->getQuery(true);
    	    $query->select($db->quoteName(array('id','date','date_end')));
            $query->from($db->quoteName('#__bookpro_roomrate'));
            $query->where($db->quoteName('room_id') . ' = '. $db->quote($ids[$i]->id));
            $db->setQuery($query);
            $result = $db->loadObjectList();
            for ($j = 0; $j < count($result); $j++) {
                $curstarttime=strtotime($result[$j]->date);
                $curendtime=strtotime($result[$j]->date_end);
                
                if ($curendtime<$datestartdate or $dateenddate<$curstarttime){
                    
                }
                else if ($curstarttime>=$datestartdate and $dateenddate>=$curendtime) {
                    //echo ($curendtime.'---------'.$datestartdate.'++++++++'.$dateenddate'-----------'$curstarttime);die;
                    $query = $db->getQuery(true);
                    $conditions = array(
                         $db->quoteName('id') . ' = ' . $db->quote($result[$j]->id)
                    );
                    
                    $query->delete($db->quoteName('#__bookpro_roomrate'));
                    $query->where($conditions);
         
                    $db->setQuery($query);
                    $db->execute();
                    //die;
                }
                else if ($curstarttime>=$datestartdate and $dateenddate<$curendtime) {
                    //echo ($curendtime.'---------'.$datestartdate.'++++++++'.$dateenddate'-----------'$curstarttime);die;
            	    $query = $db->getQuery ( true );
            	    
            	    $tempdate = $dateenddate + 86400;

                    //echo($result[$j]->id);die;
                    //$tempdate->modify('+1 day');
            
                    $fields = array(
                        $db->quoteName('date') . ' = '. $db->quote(date("Y-m-d H:i:s",$tempdate))
                    );
                    $conditions = array(
                         $db->quoteName('id') . ' = ' . $db->quote($result[$j]->id)
                    );
                    $query->update($db->quoteName('#__bookpro_roomrate'))->set($fields)->where($conditions);
            
                    $db->setQuery($query);
                    $db->execute();
                }
                else if ($curstarttime<$datestartdate and $dateenddate>=$curendtime) {
                    //echo ($curendtime.'---------'.$datestartdate.'++++++++'.$dateenddate'-----------'$curstarttime);die;
            	    $query = $db->getQuery ( true );
            	    
            	    $tempdate = $datestartdate - 86400;

                    //echo($result[$j]->id);die;
                    //$tempdate->modify('+1 day');
            
                    $fields = array(
                        $db->quoteName('date_end') . ' = '. $db->quote(date("Y-m-d H:i:s",$tempdate))
                    );
                    $conditions = array(
                         $db->quoteName('id') . ' = ' . $db->quote($result[$j]->id)
                    );
                    $query->update($db->quoteName('#__bookpro_roomrate'))->set($fields)->where($conditions);
            
                    $db->setQuery($query);
                    $db->execute();
                }
                else if ($curstarttime<$datestartdate and $dateenddate<$curendtime) {
                    $query = $db->getQuery ( true );
            	    $tempdate = $datestartdate - 86400;
                    $fields = array(
                        $db->quoteName('date_end') . ' = '. $db->quote(date("Y-m-d H:i:s",$tempdate))
                    );
                    $conditions = array(
                         $db->quoteName('id') . ' = ' . $db->quote($result[$j]->id)
                    );
                    $query->update($db->quoteName('#__bookpro_roomrate'))->set($fields)->where($conditions);
                    $db->setQuery($query);
                    $db->execute();
                    
            	    $query = $db->getQuery(true);
    	            $query->select('*');
                    $query->from($db->quoteName('#__bookpro_roomrate'));
                    $query->where($db->quoteName('id') . ' = '. $db->quote($result[$j]->id));
                    $db->setQuery($query);
                    $tempresult = $db->loadObject();
                    //var_dump($result);die;
                    $tempdate = $dateenddate + 86400;
                    $query = $db->getQuery(true);
                    $columns = array('date', 'adult', 'room_id', 'child', 'infant', 'discount', 'adult_roundtrip', 'child_roundtrip', 'infant_roundtrip', 'date_end', 'weekdays');
                    $values = array(date("'Y-m-d H:i:s'", $tempdate), $tempresult->adult, $tempresult->room_id, $tempresult->child, $tempresult->infant, 0, $tempresult->adult_roundtrip,  $tempresult->child_roundtrip, $tempresult->infant_roundtrip, date("'Y-m-d H:i:s'", $curendtime),  $db->quote($tempresult->weekdays) );
                    $query
                        ->insert($db->quoteName('#__bookpro_roomrate'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));
                     
                    $db->setQuery($query);
                    $db->execute();
                }
                //var_dump (strtotime($result[$j]->date));die;
            }
            //echo(2);die;
		    //var_dump($result);die;
		}
    }
    
    function addonechangeprice() 
	{
	    $mainframe = JFactory::getApplication ();
		$input = JFactory::getApplication ()->input;
		$weekdays = $input->get ( 'weekday' , '','ARR');
		$weekdays=implode ($weekdays,',');
		$room_id = $input->get ( 'idval' );
		$this->setRedirect('index.php?option=com_bookpro&view=roomrate3&bustrip_id='.$room_id);
		$idrouteto = $input->get ( 'idrouteto' , '','ARR');
		$idroutefrom = $input->get ( 'idroutefrom' , '','ARR');
		$price = $input->get ( 'price' , '','ARR');
		
		$priceret = array();
		$pricech = array();
		$pricechret = array();
		$priceinf = array();
		$priceinfret = array();
		for ($i = 0; $i < count($price); $i++) {
		    array_push ($priceret,$price[$i]*2);
		    array_push ($pricech,$price[$i]/2);
		    array_push ($pricechret,$price[$i]);
		    array_push ($priceinf,$price[$i]/2);
		    array_push ($priceinfret,$price[$i]);
		}
		
		//$priceret = $input->get ( 'priceret' , '','ARR');
		//$pricech = $input->get ( 'pricech' , '','ARR');
		//$pricechret = $input->get ( 'pricechret' , '','ARR');
		//$priceinf = $input->get ( 'priceinf' , '','ARR');
		//$priceinfret = $input->get ( 'priceinfret' , '','ARR');
		$startdate = $input->get ( 'startdate' );
		$datestartdate=strtotime($startdate);
		$enddate = $input->get ( 'enddate' );
		$dateenddate=strtotime($enddate);
		$db = JFactory::getDbo();
		$idto = null;
		$idfrom=null;
		$db->transactionStart ();
		for ($i = 0; $i < count($idrouteto); $i++) {
    	    $query = $db->getQuery(true);
    	    $query->select($db->quoteName(array('id')));
            $query->from($db->quoteName('#__bookpro_bustrip'));
            $query->where('('.$db->quoteName('id') . ' = '. $db->quote($room_id) . ' OR ' .$db->quoteName('parent_id') . ' = '. $db->quote($room_id) . ') AND '.$db->quoteName('from') . ' = '. $db->quote($idroutefrom[$i]) .' AND '.$db->quoteName('to') . ' = '. $db->quote($idrouteto[$i]));
            $db->setQuery($query);
            $result = $db->loadObject();
		    $idto == null? $idto = array($result) : array_push($idto, $result);

		    $query = $db->getQuery(true);
            $query->select($db->quoteName(array('id')));
            $query->from($db->quoteName('#__bookpro_bustrip'));
            $query->where('('.$db->quoteName('associated_parent_id') . ' = '. $db->quote($room_id) . ') AND '.$db->quoteName('from') . ' = '. $db->quote($idrouteto[$i]) .' AND '.$db->quoteName('to') . ' = '. $db->quote($idroutefrom[$i]));
            $db->setQuery($query);
            $result = $db->loadObject();
            if ($result != null){
		        $idfrom == null? $idfrom = array($result) : array_push($idfrom, $result);
            }
		   
		}
		//var_dump ($idfrom);die;
		
		$this->deleteondate($idto,$datestartdate,$dateenddate,$db);
		$this->deleteondate($idfrom,$datestartdate,$dateenddate,$db);
		
		
		for ($i = 0; $i < count($idrouteto); $i++) {
    		$query = $db->getQuery(true);
            $columns = array('date', 'adult', 'room_id', 'child', 'infant', 'discount', 'adult_roundtrip', 'child_roundtrip', 'infant_roundtrip', 'date_end', 'weekdays');
            $values = array(date("'Y-m-d H:i:s'", strtotime($startdate)), $price[$i], $idto[$i]->id, $pricech[$i], $priceinf[$i], 0, $priceret[$i],  $pricechret[$i], $priceinfret[$i], date("'Y-m-d H:i:s'", strtotime($enddate)),  $db->quote($weekdays) );
            $query
                ->insert($db->quoteName('#__bookpro_roomrate'))
                ->columns($db->quoteName($columns))
                ->values(implode(',', $values));
             
            $db->setQuery($query);
            $db->execute();
            
            if ($idfrom != null){
                $query = $db->getQuery(true);
                $columns = array('date', 'adult', 'room_id', 'child', 'infant', 'discount', 'adult_roundtrip', 'child_roundtrip', 'infant_roundtrip', 'date_end', 'weekdays');
                $values = array(date("'Y-m-d H:i:s'", strtotime($startdate)), $price[$i], $idfrom[$i]->id, $pricech[$i], $priceinf[$i], 0, $priceret[$i],  $pricechret[$i], $priceinfret[$i], date("'Y-m-d H:i:s'", strtotime($enddate)),  $db->quote($weekdays) );
                $query
                    ->insert($db->quoteName('#__bookpro_roomrate'))
                    ->columns($db->quoteName($columns))
                    ->values(implode(',', $values));
                 
                $db->setQuery($query);
                $db->execute();
            }
		}
		$db->transactionCommit ();
		
	}
    function getTimePrice() 
	{
	    $mainframe = JFactory::getApplication ();
		$input = JFactory::getApplication ()->input;
	    $room_id = $input->get ( 'idval' );
	    $optvalue = $input->get ( 'optvalue' );
	    //var_dump ($input);die;
	    $this->setRedirect('index.php?option=com_bookpro&view=roomrate3&bustrip_id='.$room_id.'&timeopt='.$optvalue);
	}
	
	function deleteonechangeprice() 
	{
	    $mainframe = JFactory::getApplication ();
		$input = JFactory::getApplication ()->input;
		$room_id = $input->get ( 'idval' );
		$this->setRedirect('index.php?option=com_bookpro&view=roomrate3&bustrip_id='.$room_id);
	    $idprice = $input->get ( 'idprice' , '','ARR');
		$idpriceret = $input->get ( 'idpriceret' , '','ARR');
	    
	    $db = JFactory::getDbo();
	    $db->transactionStart ();
	    for ($i = 0; $i < count($idprice); $i++) {
            $query = $db->getQuery(true);
            
            $conditions = array(
                 $db->quoteName('id') . ' = ' . $db->quote($idprice[$i])
            );
            
            $query->delete($db->quoteName('#__bookpro_roomrate'));
            $query->where($conditions);
 
            $db->setQuery($query);
            $db->execute();
            
            $query = $db->getQuery(true);
            
            $conditions = array(
                 $db->quoteName('id') . ' = ' . $db->quote($idpriceret[$i])
            );
            
            $query->delete($db->quoteName('#__bookpro_roomrate'));
            $query->where($conditions);
 
            $db->setQuery($query);
            $db->execute();
	    }
	    //die;
	    $db->transactionCommit ();
	}
    
    function saveonechangeprice() 
	{
	    $mainframe = JFactory::getApplication ();
		$input = JFactory::getApplication ()->input;
		$weekdays = $input->get ( 'weekday' , '','ARR');
		//$weekdays = $input->get ( 'weekday' , '','ARR');
		$weekdays=implode ($weekdays,',');
		$timeopt = $input->get ( 'timeopt' );
		//var_dump ($timeopt);die;
		$price = $input->get ( 'price' , '','ARR');
		$priceret = $input->get ( 'priceret' , '','ARR');
		$pricech = $input->get ( 'pricech' , '','ARR');
		$pricechret = $input->get ( 'pricechret' , '','ARR');
		$priceinf = $input->get ( 'priceinf' , '','ARR');
		$priceinfret = $input->get ( 'priceinfret' , '','ARR');
		$idrouteto = $input->get ( 'idrouteto' , '','ARR');
		$idroutefrom = $input->get ( 'idroutefrom' , '','ARR');
		$idprice = $input->get ( 'idprice' , '','ARR');
		$idpriceret = $input->get ( 'idpriceret' , '','ARR');
		$room_id = $input->get ( 'idval' );
	    $this->setRedirect('index.php?option=com_bookpro&view=roomrate3&bustrip_id='.$room_id.'&timeopt='.$timeopt);
	    
	    $db = JFactory::getDbo ();
	    $db->transactionStart ();
	    for ($i = 0; $i < count($price); $i++) {
    	    $query = $db->getQuery ( true );
    
            $fields = array(
                $db->quoteName('adult') . ' = '. $db->quote($price[$i]),
                $db->quoteName('adult_roundtrip') . ' = '. $db->quote($priceret[$i]),
                $db->quoteName('child') . ' = '. $db->quote($pricech[$i]),
                $db->quoteName('child_roundtrip') . ' = '. $db->quote($pricechret[$i]),
                $db->quoteName('infant') . ' = '. $db->quote($priceinf[$i]),
                $db->quoteName('infant_roundtrip') . ' = '. $db->quote($priceinfret[$i]),
                $db->quoteName('weekdays') . ' = '. $db->quote($weekdays)
            );
            $conditions = array(
                 $db->quoteName('id') . ' = ' . $db->quote($idprice[$i])
            );
            $query->update($db->quoteName('#__bookpro_roomrate'))->set($fields)->where($conditions);
    
            $db->setQuery($query);
            $db->execute();
            
             $query = $db->getQuery ( true );
    
            $fields = array(
                $db->quoteName('adult') . ' = '. $db->quote($price[$i]),
                $db->quoteName('adult_roundtrip') . ' = '. $db->quote($priceret[$i]),
                $db->quoteName('child') . ' = '. $db->quote($pricech[$i]),
                $db->quoteName('child_roundtrip') . ' = '. $db->quote($pricechret[$i]),
                $db->quoteName('infant') . ' = '. $db->quote($priceinf[$i]),
                $db->quoteName('infant_roundtrip') . ' = '. $db->quote($priceinfret[$i]),
                $db->quoteName('weekdays') . ' = '. $db->quote($weekdays)
               
            );
            $conditions = array(
                 $db->quoteName('id') . ' = ' . $db->quote($idpriceret[$i])
            );
            $query->update($db->quoteName('#__bookpro_roomrate'))->set($fields)->where($conditions);
    
            $db->setQuery($query);
            $db->execute();
	    }
        $db->transactionCommit ();
	    
	    //var_dump($input); die;
	    
	}
	
	/**
	 * Cancel edit operation.
	 * Check in subject and redirect to subjects list.
	 */
	function delonechange() 
	{
	    $mainframe = JFactory::getApplication ();
		$input = JFactory::getApplication ()->input;
		$room_id = $input->get ( 'idval' );
		$del_id = $input->get ( 'depart0' );
		$route = $input->get ( 'route', '', 'RAW' );
		
		
		$route_arr = explode (",",$route);
		
		$key = array_search($del_id, $route_arr);
		array_splice($route_arr, $key, 1);
		
		//$route = str_replace (','.$del_id.',','',$route);
		$route = implode ( "," ,  $route_arr );
		//var_dump($route); die;
		
		//$route = str_replace ($del_id.',','',$route);
		//$route = str_replace (','.$del_id,'',$route);
		
		$route_arr_ret= array_reverse ($route_arr);
	    $routeret = implode ( "," ,  $route_arr_ret );
	    
	    $db = JFactory::getDbo ();
	    $db->transactionStart ();
    	    $query = $db->getQuery ( true );
    
            $fields = array(
                $db->quoteName('route') . ' = ' . $db->quote($route)
            );
            $conditions = array(
                '('.$db->quoteName('id') . ' = '. $db->quote($room_id) . ' OR ' .$db->quoteName('parent_id') . ' = '. $db->quote($room_id) . ')'
            );
            $query->update($db->quoteName('#__bookpro_bustrip'))->set($fields)->where($conditions);
    
            $db->setQuery($query);
            $db->execute();
            
            $query = $db->getQuery ( true );

            $fields = array(
                $db->quoteName('route') . ' = ' . $db->quote($routeret)
            );
            $conditions = array(
                $db->quoteName('associated_parent_id') . ' = '. $db->quote($room_id)
            );
            $query->update($db->quoteName('#__bookpro_bustrip'))->set($fields)->where($conditions);
    
            $db->setQuery($query);
            $db->execute();
	    
			// Delete all existing rate and log
			$query = $db->getQuery ( true );
			$query->delete ( '#__bookpro_bustrip' )->where ( '(( '.$db->quoteName('parent_id').'=' . $room_id . ' OR ' .$db->quoteName('parent_id').'='  . $room_id. ' OR ' .$db->quoteName('associated_parent_id').'=' . $room_id . ' ) AND ( ' . $db->quoteName('from').'='   . $del_id . ' OR ' . $db->quoteName('to').'=' . $del_id . ' ))');
			$db->setQuery ( $query );
			//echo ($routeret.'------------'.$db->getQuery()); die;
			$db->execute ();
		$db->transactionCommit ();
		
		$this->setRedirect('index.php?option=com_bookpro&view=roomrate2&bustrip_id='.$room_id);
	}
	 
	function addonechange() 
	{
	    
	    $mainframe = JFactory::getApplication ();
		$input = JFactory::getApplication ()->input;

	    $room_id = $input->get ( 'idval' );
	    $code = $input->get ( 'code' );
	    $route = $input->get ( 'route', '', 'RAW' );
	    
	    $routereverttime = $input->get ( 'routereverttime', '', 'RAW' );
	    $routetime = $input->get ( 'routetime', '', 'RAW' );
	    
	    $routenumber = $input->get ( 'routenumber' );
	    
	    $route_arr = explode (",",$route);
	    
	    if (in_array('0', $route_arr )){
	            //$mainframe->enqueueMessage ( JText::_ ( 'Subject editing canceled' ) );
	            
	        JError::raiseWarning( 100, 'Выберите уже добавленный пункт назначения' );
	        $this->setRedirect('index.php?option=com_bookpro&view=roomrate2&bustrip_id='.$room_id);
	        return;
	    }
	    
	    $routetime_arr = explode (",",$routetime);
	    //echo (var_dump($routetime_arr).'------------'); die;
	    $routereverttime_arr = explode (",",$routereverttime);
	    
	    array_splice( $route_arr, $routenumber+1, 0, 0 ); 
	    $route = implode ( "," ,  $route_arr );
	    $route_arr_ret= array_reverse ($route_arr);
	    $routeret = implode ( "," ,  $route_arr_ret );
	    
	    //echo ('------------'.var_dump($route_arr)); die;
	    $db = JFactory::getDbo ();
	    $db->transactionStart ();
	    
	    
	    $query = $db->getQuery ( true );

        $fields = array(
            $db->quoteName('route') . ' = ' . $db->quote($route)
        );
        $conditions = array(
            '('.$db->quoteName('id') . ' = '. $db->quote($room_id) . ' OR ' .$db->quoteName('parent_id') . ' = '. $db->quote($room_id) . ')'
        );
        $query->update($db->quoteName('#__bookpro_bustrip'))->set($fields)->where($conditions);

        $db->setQuery($query);
        $db->execute();
	    
	    $new_time =  substr($routetime_arr[$routenumber],0,6)."30";
	    $new_time_ret =  substr($routereverttime_arr[count($route_arr) - 1 -$routenumber-1],0,6)."30";
	    
	    $query = $db->getQuery(true);
 
        // Select all records from the user profile table where key begins with "custom.".
        // Order it by the ordering field.
        $query->select($db->quoteName(array('id','code','agent_id')));
        $query->from($db->quoteName('#__bookpro_bustrip'));
        $query->where($db->quoteName('associated_parent_id')." = ".$db->quote($room_id)." AND ". $db->quoteName('parent_id')." = ".$db->quote(0));
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
         
        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $result = $db->loadObject();
	    
	    //echo ($routenumber.'------------'.var_dump($result)); die;
	    
	    for ($i = 0; $i < count($route_arr); $i++) {
            if ($i!=($routenumber+1)){
                if ($i<=$routenumber)   {
                    
                    $query = $db->getQuery(true);
 
                    // Insert columns.
                    $columns = array('parent_id', 'level', 'route', 'from','to', 'start_time','end_time','code','associated_parent_id','agent_id');
                     
                    // Insert values.
                    $values = array($room_id, 2, $db->quote($route), $route_arr[$i], '0', $db->quote($routetime_arr[$i]), $db->quote($new_time), $db->quote($code), 0, $result->agent_id);
                     
                    // Prepare the insert query.
                    $query
                        ->insert($db->quoteName('#__bookpro_bustrip'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));
                     
                    // Set the query using our newly populated query object and execute it.
                    $db->setQuery($query);
                    $db->execute();
                    
                }
                else {
                    $query = $db->getQuery(true);
 
                    // Insert columns.
                    $columns = array('parent_id', 'level', 'route', 'from','to', 'start_time','end_time','code','associated_parent_id','agent_id');
                     
                    // Insert values.
                    $values = array($room_id, 2, $db->quote($route), '0', $route_arr[$i], $db->quote($new_time), $db->quote($routetime_arr[$i-1]),  $db->quote($code), 0,$result->agent_id);
                     
                    // Prepare the insert query.
                    $query
                        ->insert($db->quoteName('#__bookpro_bustrip'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));
                     
                    // Set the query using our newly populated query object and execute it.
                    $db->setQuery($query);
                    $db->execute();
                
                }
            }
        }
        
        
        $query = $db->getQuery ( true );

        $fields = array(
            $db->quoteName('route') . ' = ' . $db->quote($routeret)
        );
        $conditions = array(
            $db->quoteName('associated_parent_id') . ' = '. $db->quote($room_id)
        );
        $query->update($db->quoteName('#__bookpro_bustrip'))->set($fields)->where($conditions);

        $db->setQuery($query);
        $db->execute();
        
        for ($i = 0; $i < count($route_arr); $i++) {
            if ($i!=(count($route_arr)-$routenumber-2)){
                if ($i<(count($route_arr)-$routenumber-1))   {
                    $query = $db->getQuery(true);
 
                    // Insert columns.
                    $columns = array('parent_id', 'level', 'route', 'from','to', 'start_time','end_time','code','associated_parent_id','agent_id');
                     
                    // Insert values.
                    $values = array($result->id, 2, $db->quote($routeret), $route_arr_ret[$i], '0', $db->quote($routereverttime_arr[$i]), $db->quote($new_time_ret), $db->quote($result->code), $room_id,$result->agent_id);
                     
                    // Prepare the insert query.
                    $query
                        ->insert($db->quoteName('#__bookpro_bustrip'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));
                     
                    // Set the query using our newly populated query object and execute it.
                    $db->setQuery($query);
                    $db->execute();
                }
                else
                {
                    $query = $db->getQuery(true);
 
                    // Insert columns.
                    $columns = array('parent_id', 'level', 'route', 'from','to', 'start_time','end_time','code','associated_parent_id','agent_id');
                     
                    // Insert values.
                    $values = array($result->id, 2, $db->quote($routeret), '0',  $route_arr_ret[$i],  $db->quote($new_time_ret), $db->quote($routereverttime_arr[$i-1]), $db->quote($result->code), $room_id,$result->agent_id);
                    // echo ($i.'------------'.var_dump($values)); die;
                    // Prepare the insert query.
                    $query
                        ->insert($db->quoteName('#__bookpro_bustrip'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',', $values));
                     
                    // Set the query using our newly populated query object and execute it.
                    $db->setQuery($query);
                    $db->execute();
                }
            }
        }
        
        
	    $db->transactionCommit ();
	    $this->setRedirect('index.php?option=com_bookpro&view=roomrate2&bustrip_id='.$room_id);
	}
	 
	function changestaion($prev, $cur, $route, $id) 
    {
        //echo ($cur.'------------'.$prev.'------------'.$route); die;
        $route_arr = explode (",",$route);
        //echo ($cur.'------------'.$route.'------------',vw); die;
        for ($i = 0; $i < count($route_arr); $i++) {
            if ($route_arr[$i]==$prev)   {
                $route_arr[$i]=$cur;
            }
        }

        
        $route = implode ( "," ,  $route_arr );
        //echo ($cur.'------------'.$prev.'------------'.$route); die;
        
        $db = JFactory::getDbo ();
	    $db->transactionStart ();
	    
	    $query = $db->getQuery ( true );

        $fields = array(
            $db->quoteName('route') . ' = ' . $db->quote($route)
        );
        $conditions = array(
            '('.$db->quoteName('id') . ' = '. $db->quote($id) . ' OR ' .$db->quoteName('parent_id') . ' = '. $db->quote($id) . ')'
        );
        $query->update($db->quoteName('#__bookpro_bustrip'))->set($fields)->where($conditions);

        $db->setQuery($query);
        $db->execute();
        
        $query = $db->getQuery ( true );

        $fields = array(
            $db->quoteName('from') . ' = ' . $db->quote($cur)
        );
        $conditions = array(
            '('.$db->quoteName('id') . ' = '. $db->quote($id) . ' OR ' .$db->quoteName('parent_id') . ' = '. $db->quote($id) . ')' ,
            $db->quoteName('from') . ' = ' . $db->quote($prev)
        );
        $query->update($db->quoteName('#__bookpro_bustrip'))->set($fields)->where($conditions);

        $db->setQuery($query);
        $db->execute();
        
        $query = $db->getQuery ( true );

        $fields = array(
            $db->quoteName('to') . ' = ' . $db->quote($cur)
        );
        $conditions = array(
            '('.$db->quoteName('id') . ' = '. $db->quote($id) . ' OR ' .$db->quoteName('parent_id') . ' = '. $db->quote($id) . ')' ,
            $db->quoteName('to') . ' = ' . $db->quote($prev)
        );
        $query->update($db->quoteName('#__bookpro_bustrip'))->set($fields)->where($conditions);

        $db->setQuery($query);
        $db->execute();
        
        $route_arr= array_reverse ($route_arr);
        $route = implode ( "," ,  $route_arr );
        
        $query = $db->getQuery ( true );

        $fields = array(
            $db->quoteName('route') . ' = ' . $db->quote($route)
        );
        $conditions = array(
            $db->quoteName('associated_parent_id') . ' = '. $db->quote($id)
        );
        $query->update($db->quoteName('#__bookpro_bustrip'))->set($fields)->where($conditions);

        $db->setQuery($query);
        $db->execute();
        
        $fields = array(
            $db->quoteName('from') . ' = ' . $db->quote($cur)
        );
        $conditions = array(
            $db->quoteName('associated_parent_id') . ' = '. $db->quote($id) ,
            $db->quoteName('from') . ' = ' . $db->quote($prev)
        );
        $query->update($db->quoteName('#__bookpro_bustrip'))->set($fields)->where($conditions);

        $db->setQuery($query);
        $db->execute();
        
        $query = $db->getQuery ( true );

        $fields = array(
            $db->quoteName('to') . ' = ' . $db->quote($cur)
        );
        $conditions = array(
            $db->quoteName('associated_parent_id') . ' = '. $db->quote($id) ,
            $db->quoteName('to') . ' = ' . $db->quote($prev)
        );
        $query->update($db->quoteName('#__bookpro_bustrip'))->set($fields)->where($conditions);

        $db->setQuery($query);
        $db->execute();
	    
	    $db->transactionCommit ();
    }
	 
	function saveonechange() 
	{
	   
	    
	    $mainframe = JFactory::getApplication ();
		$input = JFactory::getApplication ()->input;
	    $curval = $input->get ( 'dest_idsel' );
	    $prevval = $input->get ( 'depart0' );
	    $room_id = $input->get ( 'idval' );
	    
		
	    
	    if ($curval!=$prevval){
	        $route = $input->get ( 'route', '', 'RAW' );
	        //echo (strpos($route,$curval.',').'------------'.strpos($route,','.$curval)); die;
	        $route_arr = explode (",",$route);
	        if (in_array($curval, $route_arr )){
	            //$mainframe->enqueueMessage ( JText::_ ( 'Subject editing canceled' ) );
	            
	            JError::raiseWarning( 100, 'Выбранный пункт назначения уже содержится в маршруте' );
	            $this->setRedirect('index.php?option=com_bookpro&view=roomrate2&bustrip_id='.$room_id);
	            return;
	        }
	        //return;
	        $this->changestaion ($prevval,$curval,$route,$room_id);
	        //echo ($route.'------------'.$prevval); die;
	    }
	    
	    
		
		$db = JFactory::getDbo ();
	    $db->transactionStart ();
	    
        $query = $db->getQuery ( true );
        $columns = array('start_time');
        // Insert values.
        $values = array($input->get ( 'depart1' ));
        $fields = array(
            $db->quoteName('start_time') . ' = ' . $db->quote($input->get ( 'depart1' )."00")
        );
        $conditions = array(
            '('.$db->quoteName('id') . ' = '. $db->quote($room_id) . ' OR ' .$db->quoteName('parent_id') . ' = '. $db->quote($room_id) . ')', 
            $db->quoteName('from') . ' = ' . $db->quote($input->get ( 'dest_idsel' ))
        );
        $query->update($db->quoteName('#__bookpro_bustrip'))->set($fields)->where($conditions);

        $db->setQuery($query);
        $db->execute();
        //var_dump((string)$db->getQuery());die;
        $query = $db->getQuery ( true );
        $columns = array('end_time');
        // Insert values.
        $values = array($input->get ( 'depart1' ));
        $fields = array(
            $db->quoteName('end_time') . ' = ' . $db->quote($input->get ( 'depart1' )."00")
        );
        $conditions = array(
            '('.$db->quoteName('id') . ' = '. $db->quote($room_id) . ' OR ' .$db->quoteName('parent_id') . ' = '. $db->quote($room_id) . ')', 
            $db->quoteName('to') . ' = ' . $db->quote($input->get ( 'dest_idsel' ))
        );
        $query->update($db->quoteName('#__bookpro_bustrip'))->set($fields)->where($conditions);

        $db->setQuery($query);
        $db->execute();
        
        $query = $db->getQuery ( true );
        $columns = array('end_time');
        // Insert values.
        
        $fields = array(
            $db->quoteName('end_time') . ' = ' . $db->quote($input->get ( 'depart2' )."00")
        );
        $conditions = array(
            $db->quoteName('associated_parent_id') . ' = '. $db->quote($room_id) , 
            $db->quoteName('to') . ' = ' . $db->quote($input->get ( 'dest_idsel' ))
        );
        $query->update($db->quoteName('#__bookpro_bustrip'))->set($fields)->where($conditions);

        $db->setQuery($query);
        //var_dump((string)$db->getQuery());die;
        $db->execute();
        
        $query = $db->getQuery ( true );
        $columns = array('start_time');
        // Insert values.
        
        $fields = array(
            $db->quoteName('start_time') . ' = ' . $db->quote($input->get ( 'depart2' )."00")
        );
        $conditions = array(
            $db->quoteName('associated_parent_id') . ' = '. $db->quote($room_id) , 
            $db->quoteName('from') . ' = ' . $db->quote($input->get ( 'dest_idsel' ))
        );
        $query->update($db->quoteName('#__bookpro_bustrip'))->set($fields)->where($conditions);

        $db->setQuery($query);
        //var_dump((string)$db->getQuery());die;
        $db->execute();
        
		$db->transactionCommit ();
		//echo "test";
		
		//$room_id = $input->get ( 'idval' );
        $this->setRedirect('index.php?option=com_bookpro&view=roomrate2&bustrip_id='.$room_id);
	
	    
	}
	 
	 
	function cancel() 

	{
//alert ('task');
		//$mainframe = JFactory::getApplication ();
		
		//$mainframe->enqueueMessage ( JText::_ ( 'Subject editing canceled' ) );
		
		//$mainframe->redirect ( 'index.php?option=com_bookpro&view=bustrips' );
				$mainframe = JFactory::getApplication ();
		$input = JFactory::getApplication ()->input;
		$room_id = $input->get ( 'idval' );
$this->setRedirect('index.php?option=com_bookpro&view=roomrate2&bustrip_id='.$room_id);
	}
	function emptyrate() {
		$mainframe = JFactory::getApplication ();
		$input = JFactory::getApplication ()->input;
		$room_id = $input->get ( 'room_id' );
		$db = JFactory::getDbo ();
		
		try {
			$db->transactionStart ();
			// Delete all existing rate and log
			$query = $db->getQuery ( true );
			$query->delete ( '#__bookpro_roomrate' )->where ( 'room_id=' . $room_id );
			$db->setQuery ( $query );
			$db->execute ();
			$db->transactionCommit ();
		} catch ( Exception $e ) {
			$mainframe->enqueueMessage ( $e->getMessage () );
			$db->transactionRollback ();
		}
		$this->setRedirect ( 'index.php?option=com_bookpro&view=roomrate&bustrip_id=' . $room_id );
	}
	
	function emptylog() {
		$mainframe = JFactory::getApplication ();
		$input = JFactory::getApplication ()->input;
		$room_id = $input->get ( 'room_id' );
		$db = JFactory::getDbo ();
	
		try {
			$db->transactionStart ();
			$query = $db->getQuery ( true );
			$query->delete ( '#__bookpro_roomratelog' )->where ( 'room_id=' . $room_id );
			$db->setQuery ( $query );
			$db->execute ();
				
			$db->transactionCommit ();
		} catch ( Exception $e ) {
			$mainframe->enqueueMessage ( $e->getMessage () );
			$db->transactionRollback ();
		}
		$this->setRedirect ( 'index.php?option=com_bookpro&view=roomrate&bustrip_id=' . $room_id );
	}
	
	
	
	
	
	/**
	 * Save subject and state on edit page.
	 */
	function apply() 

	{
		$this->save ( true );
	}
	
	/**
	 *
	 * Save subject.
	 *
	 *
	 *
	 * @param boolean $apply
	 *        	true state on edit page, false return to browse list
	 *        	
	 */
	
	function savedayrate() {
		$model = $this->getModel ( 'Roomrate', '', array () );
		$input = JFactory::getApplication ()->input;
		$data = $input->get ( 'jform', array (), 'array' );
		$model->save ( $data );
		JFactory::getApplication ()->enqueueMessage ( 'Update successful' );
		$this->setRedirect ( 'index.php?option=com_bookpro&view=bustrips' );
	}
	

	function delete()
	
	{
		$mainframe = JFactory::getApplication ();
	
		$input = JFactory::getApplication ()->input;
	
		$weekdays = $input->get ( 'weekday', null, 'array' );

		$startdate = new JDate ( $mainframe->getUserStateFromRequest ( 'rate.startdate', 'startdate', JFactory::getDate ()->format ( 'Y-m-d' ) ) );
		$startclone = clone $startdate;
		$enddate = new JDate ( $mainframe->getUserStateFromRequest ( 'rate.enddate', 'enddate', JFactory::getDate ()->add ( new DateInterval ( 'P60D' ) )->format ( 'Y-m-d' ) ) );
	
		$starttoend = $startdate->diff ( $enddate )->days;
	
		// delete old record
	
		$room_id = $input->get ( 'room_id' );
	
		$db = JFactory::getDbo ();
		
	
		try {
			$db->transactionStart ();
			$datearr=array();
			for($i = 0; $i <= $starttoend; $i ++) {
				$dw = ( int ) $startdate->format ( 'N' );
				if (in_array ( "$dw", $weekdays )) {
					$datearr[]='DATE_FORMAT(`date`,"%Y-%m-%d")='.$db->q($startdate->format('Y-m-d'));
				}
				$startdate = $startdate->add ( new DateInterval ( 'P1D' ) );
			}
			
			
			if(count($datearr)>0){
				$str=implode(' OR ', $datearr);			
				$query = $db->getQuery(true );
				$query->delete ( '#__bookpro_roomrate' )->where ( 'room_id=' . $room_id);
				$query->where('('.$str.')');
				//var_dump($query->dump());die;
				$db->setQuery ( $query );
				$db->execute ();
			}
				
			$db->transactionCommit ();
			$mainframe->enqueueMessage ( 'Saved successful' );
		} catch ( Exception $e ) {
			$db->transactionRollback ();
			JErrorPage::render ( $e );
			$mainframe->enqueueMessage ( $e->getMessage () );
		}
	
		$this->setRedirect ( 'index.php?option=com_bookpro&view=roomrate&bustrip_id=' . $room_id );
	}
	
	
	
	function save($apply = false) 

	{
//return true;
//jimport('joomla.log.log');
//JLog::addLogger(array('text_file' => 'roomrate.txt'));
//JLog::add ('test2015-08-07');
//alert ('asdsad');
		$mainframe = JFactory::getApplication ();
		
		$input = JFactory::getApplication ()->input;
		
		$weekdays = $input->get ( 'weekday', null, 'array' );
$weekdaysstring= implode(",", $weekdays );
	
//JLog::add ('test2015-08-07-'.json_encode($weekdaysstring));
		
		$startdate = new JDate ( $mainframe->getUserStateFromRequest ( 'rate.startdate', 'startdate', JFactory::getDate ()->format ( 'Y-m-d' ) ) );
		$startclone = clone $startdate;
		$enddate = new JDate ( $mainframe->getUserStateFromRequest ( 'rate.enddate', 'enddate', JFactory::getDate ()->add ( new DateInterval ( 'P60D' ) )->format ( 'Y-m-d' ) ) );
		
		$starttoend = $startdate->diff ( $enddate )->days;
		
		// delete old record
		
		$room_id = $input->get ( 'room_id' );
		
		$db = JFactory::getDbo ();
		
		try {
			$db->transactionStart ();


$values = array ();
					$query = $db->getQuery ( true );
					$query->insert ( '#__bookpro_roomrate' ); // ON DUPLICATE KEY UPDATE date='2014-11-25 00:00:00', room_id=20000,adult=10011
					$query->columns ( 'room_id,date,adult,child,infant,adult_roundtrip,child_roundtrip,infant_roundtrip,discount,date_end,weekdays' );
					// $query->insert ( '#__bookpro_roomrate' );
					// $query->columns ( 'room_id,date,adult,child,infant,adult_roundtrip,child_roundtrip,infant_roundtrip,discount' );
					
					$temp = array (
							$input->get ( 'room_id' ),
							$db->quote ( $startdate->toSql () ),
							$input->get ( 'adult', 0 ),
							$input->get ( 'child', 0 ),
							$input->get ( 'infant', 0 ),
							
							$input->get ( 'adult_roundtrip', 0 ),
							$input->get ( 'child_roundtrip', 0 ),
							$input->get ( 'infant_roundtrip', 0 ),
							$input->getFloat ( 'discount', 0 ) ,
$db->quote ( $enddate ->toSql () ),
$db->quote ( $weekdaysstring )
					);

					$values [] = implode ( ',', $temp );
					$query->values ( $values );
					$sql=(string)$query;
					
					  $updates=  array('room_id='.$input->get ( 'room_id' ),
							'date='.$db->quote ( $startdate->toSql ()),
							'adult='.$input->get ( 'adult', 0 ),
							'child='.$input->get ( 'child', 0 ),
							'infant='.$input->get ( 'infant', 0 ),
							'adult_roundtrip='.$input->get ( 'adult_roundtrip', 0 ),
							'child_roundtrip='.$input->get ( 'child_roundtrip', 0 ),
							'infant_roundtrip='.$input->get ( 'infant_roundtrip', 0 ),
							'discount='.$input->get ( 'discount', 0 ),
							'date_end='.$db->quote ( $enddate->toSql ()),
							'weekdays='.$db->quote ( $weekdaysstring)
							 );

					$sqltotal=$sql.' ON DUPLICATE KEY UPDATE '. implode(',', $updates) ;
					$db->setQuery ( $sqltotal );
					$db->execute ();

			
			
			
			// save rate log
			
			$params = array (
					'adult' => $input->get ( 'adult', 0 ),
					'child' => $input->get ( 'child', 0 ),
					'infant' => $input->get ( 'infant', 0 ),
					'adult_roundtrip' => $input->get ( 'adult_roundtrip', 0 ),
					'child_roundtrip' => $input->get ( 'child_roundtrip', 0 ),
					'infant_roundtrip' => $input->get ( 'infant_roundtrip', 0 ),
					'start' => $startclone->toSql (),
					'end' => $enddate->toSql (),
					'weekday' => implode ( ',', $weekdays ) 
			);
			
			$query = $db->getQuery ( true );
			$query->insert ( '#__bookpro_roomratelog' );
			
			$query->columns ( 'room_id,params' );
			$reg = new Registry ();
			$reg->loadArray ( $params );
			
			$data = array (
					
					$room_id,
					$db->q ( ( string ) $reg ) 
			);
			$query->values ( implode ( ',', $data ) );
			$db->setQuery ( $query );
			$db->execute ();
			
			// TODO Save log rate
			
			$db->transactionCommit ();
			$mainframe->enqueueMessage ( 'Saved successful' );
		} catch ( Exception $e ) {
			$db->transactionRollback ();
			JErrorPage::render ( $e );
			$mainframe->enqueueMessage ( $e->getMessage () );
		}
		
		$this->setRedirect ( 'index.php?option=com_bookpro&view=roomrate&bustrip_id=' . $room_id );
	}
}

?>