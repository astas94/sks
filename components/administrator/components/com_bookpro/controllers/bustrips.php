
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

jimport('joomla.application.component.controlleradmin');

class BookproControllerBustrips extends JControllerAdmin
{
	/**
	 * (non-PHPdoc)
	 * @see JControllerLegacy::getModel()
	 */

	public function delete1(){
	    $this->setredirect('index.php?option=com_bookpro&view=bustrips');
	    $db = JFactory::getDbo();
	    $mainframe = JFactory::getApplication ();
		$input = JFactory::getApplication ()->input;
		$room_id = $input->get ( 'idval' );
		//echo($room_id);die;
		$db->transactionStart ();
		
		$query = $db->getQuery(true);
	    $query->select($db->quoteName(array('id')));
        $query->from($db->quoteName('#__bookpro_bustrip'));
        $query->where ( '( '.$db->quoteName('id').'=' . $room_id . ' OR ' .$db->quoteName('parent_id').'='  . $room_id. ' OR ' .$db->quoteName('associated_parent_id').'=' . $room_id . ' )');
        $db->setQuery($query);
        	//echo($query->dump().'asdasdasd');die;
        $result = $db->loadObjectList();
		
		foreach ($result as $arr_item) {
            //$value = $value * 2;
        	$query = $db->getQuery ( true );
    		$query->delete ( '#__bookpro_roomrate' )->where ( $db->quoteName('room_id').'=' . $arr_item->id );
    		$db->setQuery ( $query );
    			//echo ($routeret.'------------'.$db->getQuery()); die;
    	    $db->execute ();
        }
		
		//var_dump($result);die;
		
		$query = $db->getQuery ( true );
		$query->delete ( '#__bookpro_bustrip' )->where ( '( '.$db->quoteName('id').'=' . $room_id . ' OR ' .$db->quoteName('parent_id').'='  . $room_id. ' OR ' .$db->quoteName('associated_parent_id').'=' . $room_id . ' )');
		$db->setQuery ( $query );
			//echo ($routeret.'------------'.$db->getQuery()); die;
	    $db->execute ();
		$db->transactionCommit ();
	    
	    
	}
	

	 
	 
	public function getModel($name = 'Bustrip', $prefix = 'BookproModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	public function getBustrip(){
		 //die;
		$id=JFactory::getApplication()->input->get('id', 0);

		AImporter::model('bustrips');
		$input=JFactory::getApplication()->input;
		$agent_id=$input->get('agent_id');

		if ($agent_id) {
			
			$model = new BookProModelBusTrips();
			$state=$model->getState();
			$state->set('filter.agent_id',$agent_id);
			$state->set('filter.price',0);
			$state->set('list.limit',0);
			$lists=$model->getItems();
			
		}else{
			$lists = array();
		}
		
		$items = "";
		usort($lists, "custom_sort");

		foreach ($lists as $list){
		
// 			$title = str_repeat('--', $list->level - 1). $list->title;
// 			$title.=' -('.$list->code.')';
// 			$items.= "<option value='".$list->id."'>".$title."</option>";

			$title = str_repeat('--', $list->level - 1). $list->title;
			//var_dump($list);
			$title=''.$list->code.' '.$title;
			if($list->id==$id){
				$items.= "<option value='".$list->id."' selected>".$title."</option>";
			}else{
				$items.= "<option value='".$list->id."'>".$title."</option>";
			}
		}
		
		echo $items;
		return;		
	}
	
	 function custom_sort($a,$b) {
          return strcmp (($a->code),($b->code))>=0;

     }
	
	
}