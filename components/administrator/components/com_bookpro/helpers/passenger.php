<?php



/**

 * @package 	Bookpro

 * @author 		Ngo Van Quan

 * @link 		http://joombooking.com

 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan

 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html

 * @version 	$Id: bookpro.php 80 2012-08-10 09:25:35Z quannv $

 **/



defined('_JEXEC') or die('Restricted access');



class PassengertHelper

{
	static function getListPassengerForBustrip($bustrips,$date){
		AImporter::model('orderinfos','passengers');
		$passengers = array();
		
		foreach ($bustrips as $bustrip){
				 
			$orderinfosModel = new BookProModelOrderInfos();
			$objs = $orderinfosModel->getListsByObj($bustrip->id,$date);
			
			if (count($objs)) {
				foreach ($objs as $obj){
					$passModel = new BookProModelPassengers();
					$lists = array('order_id'=>$obj->order_id);
					$passModel->init($lists);
					$pass = $passModel->getData();
					if (count($pass)) {
						foreach ($pass as $pas){
							$pas->boarding_location = $bustrip->fromName;
							
							$passengers[] = $pas;
						}
					}
					//$pass= $passModel->getObjectOrderId($obj->order_id);
					
				}
			}	 
		}
		return $passengers;
	}
	
	static function formatPassenger(&$passengers){
		
		AImporter::helper('bus');
		for ($i = 0; $i < count($passengers); $i++) {
			$passengers[$i]->bustrip=BusHelper::getBusDetail($passengers[$i]->route_id);
			//boarding, dropping
			$item=&$passengers[$i];
			if(!$item->onward){
				$passengers[$i]->bustrip=BusHelper::getBusDetail($passengers[$i]->return_route_id);
			}
			
			
			//$item->onward=false;
			//echo ('test='.($item->onward));
			if($item->onward){
			//echo ('test2');
				$item->astart=$item->start;
				$item->aseat=$item->seat?$item->seat:$item->oseat;
			}else//if($route_id==$subject->return_route_id){
			{
				$item->astart=$item->return_start;
				$item->aseat=$item->return_seat?$item->return_seat:$item->oreturn_seat;
			}
			if (property_exists($item, 'oparams'))
			{
				$registry = new Joomla\Registry\Registry;
				$registry->loadString($item->oparams);
				$item->oparams = $registry->toArray();
			}
			if ($item->onward){
				$boarding_id=isset($item->oparams['chargeInfo']['onward']['boarding_id'])?$item->oparams['chargeInfo']['onward']['boarding_id']:null;
				$dropping_id=isset($item->oparams['chargeInfo']['onward']['dropping_id'])?$item->oparams['chargeInfo']['onward']['dropping_id']:null;
			}
			if (!$item->onward){
				 
				$boarding_id=isset($item->oparams['chargeInfo']['return']['boarding_id'])?$item->oparams['chargeInfo']['onward']['boarding_id']:null;
				$dropping_id=isset($item->oparams['chargeInfo']['return']['dropping_id'])?$item->oparams['chargeInfo']['onward']['dropping_id']:null;
			}
			AImporter::model('busstop');
			$model=new BookProModelBusstop();
			if (isset($boarding_id)){
				$item->boarding = $model->getItem($boarding_id);
			}
			if (isset($dropping_id)){
				$item->dropping = $model->getItem($dropping_id);
			}
			
		}
		//echo "<pre>";print_r($passengers);die;
		return $passengers;
		
	}
	
}


?>

