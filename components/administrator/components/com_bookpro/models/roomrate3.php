<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: room.php 48 2012-07-13 14:13:31Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');


class BookProModelRoomRate3 extends JModelAdmin
{
public function getForm($data = array(), $loadData = true)
	{
	
		$form = $this->loadForm('com_bookpro.bustrip', 'bustrip', array('control' => 'jform', 'load_data' => $loadData));
	
		if (empty($form))
			return false;
		return $form;
		}
		protected function loadFormData()
        {
            $data = JFactory::getApplication()->getUserState('com_bookpro.edit.bustrip.data', array());
            if (empty($data))
                $data = $this->getItem();
            return $data;
        }
	 
    public function getPriceBustrip($code_trip, $from, $to)
    {
        //return var_dump("sad");
        $db = $this->getDbo ();
		
		$query = "SELECT `jos_bookpro_roomrate`.`date`,`jos_bookpro_roomrate`.`id`,`jos_bookpro_roomrate`.`adult`,`jos_bookpro_roomrate`.`child`,`jos_bookpro_roomrate`.`infant`, `jos_bookpro_roomrate`.`adult_roundtrip`, `jos_bookpro_roomrate`.`child_roundtrip`,`jos_bookpro_roomrate`.`infant_roundtrip` FROM `jos_bookpro_roomrate`, `jos_bookpro_bustrip` WHERE `jos_bookpro_roomrate`.`room_id`=`jos_bookpro_bustrip`.`id` AND ((`jos_bookpro_bustrip`.`from`=".$from." AND `jos_bookpro_bustrip`.`to`=".$to.") OR (`jos_bookpro_bustrip`.`from`=".$to." AND `jos_bookpro_bustrip`.`to`=".$from.")) AND (`jos_bookpro_bustrip`.`id`=".$code_trip." OR `jos_bookpro_bustrip`.`parent_id`=".$code_trip." OR `jos_bookpro_bustrip`.`associated_parent_id`=".$code_trip.") ORDER BY `jos_bookpro_roomrate`.`date_end` DESC";
		
		$db->setQuery ( $query );
				$item = $db->loadObjectList ();
				return $item;
    }
    
    public function getPriceBustrip2($code_trip, $from, $to, $date)
    {
        //return var_dump("sad");
        $db = $this->getDbo ();
		
		$query = "SELECT `jos_bookpro_roomrate`.`id`,`jos_bookpro_roomrate`.`adult`,`jos_bookpro_roomrate`.`child`,`jos_bookpro_roomrate`.`infant`, `jos_bookpro_roomrate`.`adult_roundtrip`, `jos_bookpro_roomrate`.`child_roundtrip`,`jos_bookpro_roomrate`.`infant_roundtrip` FROM `jos_bookpro_roomrate`, `jos_bookpro_bustrip` WHERE `jos_bookpro_roomrate`.`room_id`=`jos_bookpro_bustrip`.`id` AND `jos_bookpro_roomrate`.`date`=".$db->quote($date)." AND ((`jos_bookpro_bustrip`.`from`=".$from." AND `jos_bookpro_bustrip`.`to`=".$to.") OR (`jos_bookpro_bustrip`.`from`=".$to." AND `jos_bookpro_bustrip`.`to`=".$from.")) AND (`jos_bookpro_bustrip`.`id`=".$code_trip." OR `jos_bookpro_bustrip`.`parent_id`=".$code_trip." OR `jos_bookpro_bustrip`.`associated_parent_id`=".$code_trip.")  ORDER BY `jos_bookpro_roomrate`.`date_end` DESC";
		//var_dump ($query);die;
		
		$db->setQuery ( $query );
				$item = $db->loadObjectList ();
				return $item;
    }
    
    public function getAllTimesInterval($code_trip, $from, $to)
    {
        $db = $this->getDbo ();
		
		$query = "SELECT DISTINCT `jos_bookpro_roomrate`.`date`, `jos_bookpro_roomrate`.`date_end`, `jos_bookpro_roomrate`.`weekdays` FROM `jos_bookpro_roomrate`, `jos_bookpro_bustrip` WHERE `jos_bookpro_roomrate`.`room_id`=`jos_bookpro_bustrip`.`id` AND ((`jos_bookpro_bustrip`.`from`=".$from." AND `jos_bookpro_bustrip`.`to`=".$to.") OR (`jos_bookpro_bustrip`.`from`=".$to." AND `jos_bookpro_bustrip`.`to`=".$from.")) AND (`jos_bookpro_bustrip`.`id`=".$code_trip." OR `jos_bookpro_bustrip`.`parent_id`=".$code_trip." OR `jos_bookpro_bustrip`.`associated_parent_id`=".$code_trip.") ORDER BY `jos_bookpro_roomrate`.`date_end` DESC";
		//var_dump($query);die;
		$db->setQuery ( $query );
				$item = $db->loadObjectList ();
				return $item;
    }

}

?>