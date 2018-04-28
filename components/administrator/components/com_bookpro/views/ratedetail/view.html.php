<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 80 2012-08-10 09:25:35Z quannv $
 **/

defined('_JEXEC') or die;
AImporter::model('roomrate','bustrip');
//AImporter::helper('flight');
class BookproViewRatedetail extends JViewLegacy
{
	
	
	public function display($tpl = null)
	{
		$app = JFactory::getApplication();
		$input = $app->input;
		$id = $input->get('id',0);
		$model = new BookProModelRoomRate();
		$bustripModel=new BookProModelBusTrip();
		$this->rate = $model->getItem($id);
		$this->bustrip=$bustripModel->getComplexItem($this->rate->room_id);
		//$this->flight=FlightHelper::getObjectInFo($this->bustrip_id);
		parent::display($tpl);
	}

	
}