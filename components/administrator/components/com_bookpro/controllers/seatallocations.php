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
class BookproControllerSeatallocations extends JControllerForm{
 
	public function getBustrip(){
	 
		$id=$_GET['id'];

		AImporter::model('bustrips');
		$input=JFactory::getApplication()->input;
		$agent_id=$input->get('agent_id');
		if ($agent_id){
			$param = array('order'=>'lft','bustrip-agent_id'=>$agent_id,'order_Dir'=>'ASC','bustrip-state'=>1);
			$model = new BookProModelBusTrips();
			$model->init($param);
			$lists=$model->getData();
		}else{
			$lists = array();
		}
	 
				$items = "";
		
				foreach ($lists as $list){
					$title = str_repeat('--', $list->level - 1). $list->title;
					$title.=' -('.$list->code.')';
					if($list->id==$id){
						$items.= "<option value='".$list->id."' selected>".$title."</option>";
					}else{
						$items.= "<option value='".$list->id."'>".$title."</option>";
					}
				}
				echo $items;
				
				return;
			 
	}
}
?> 


 