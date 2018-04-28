<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: airport.php 66 2012-07-31 23:46:01Z quannv $
 **/


// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ();

class ChartHelper{
	
	//data of chart
	protected $data;
	//id of chart
	protected $id;
	//check user permission
	protected $isBackend;
	protected $isAgent;
	protected $date;
	protected $typeChart;
	protected $optionChart;
	protected $titleChart;
	
	public function __construct($id = false, $typeChart = false, $option = false, $title = false){
		
		//Check is backend or frontend
		$uri = JFactory::getURI()->getPath();
		$uriArray = explode("/", $uri);
		if(strtolower($uriArray[2]) == 'administrator'){
			$this->isBackend = true;			
		}
		else{
			$this->isBackend = false;
		}
		
		$this->isAgent = BookProHelper::isAgent();
		if($id){
			$this->id = $id;
		}
		if($typeChart){
			$this->typeChart= $typeChart;
		}
		else{
			$this->typeChart = 'LineChart';
		}
		
		$this->optionChart = $option;			
		$this->titleChart = $title;
		
	}
	
	//get customer id by user
	protected function getCustomerId(){
		$user =& JFactory::getUser();
		$user_id = (int)$user->id;
		$customer = JFactory::getDbo();
		$cquery = $customer->getQuery(true);
		$cquery->select('id,user');
		$cquery->from($customer->quoteName('#__bookpro_customer'));
		$cquery->where('user = '.$user_id);
		$customer->setQuery($cquery);
		$cObject = $customer->loadObjectlist();
	
		if($cObject){
			$user_id = (int)$cObject[0]->id;
		}
		//prevent if no customer match the user
		else{
			return false;
		}
	
		return $user_id;
	
	}
	
	/*
	 * get revenue of month
	 */
	protected function getRevenueData($range, $fromDate = false, $toDate = false){
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('total, created');
		$query->from($db->quoteName('#__bookpro_orders'));
		$query->where('order_status LIKE '.$db->quote('CONFIRMED'));
		
	
		//Filter result with date
		$dStart = new JDate('now');
		switch (strtolower($range)){
			case 'lastyear':
				$dStart->modify ( '-1 year' );				
				break;
			case 'lastmonth':
				$dStart->modify ( '-1 month' );				
				break;
			default:
				$dStart->modify ( '-1 month' );
				break;
		
		}
		if ($this->validateDate($fromDate) && $this->validateDate($toDate)){
			
			$query->where(' created >= '.$db->quote(JFactory::getDate($fromDate)->toSql()));
			$query->where(' created < '.$db->quote(JFactory::getDate($toDate.' 23:59:59')->toSql()));
			
		}
		else{
			$dStart = $dStart->toSql();
			$query->where('created >= '.$db->quote($dStart));
			
		}
		
		$db->setQuery($query);
		$data = $db->loadObjectList();
		
		return $data;
	}
	
	
	
	//process data with year
	protected function lastYear($data){
		
		foreach($data as $i=>$item){
			$day = new JDate($item->created);
			$data[$i]->created = $day->format('Y-M');
		}
		
		$dStart = new JDate('now');
		$dStart->modify ( '-1 year' );
		
		$newData = array();
		for($i = 0; $i<12; $i++){
			$dStart->modify('+1 month');
			$newData[$i]['date'] = $dStart->format('Y-M');
			$newData[$i]['total']=0;
			
		}
		
		
		foreach($data as $row) {
			foreach($newData as $i=>$value){
				if ($value['date'] == $row->created)
					$newData[$i]['total'] += $row->total;
			}
		}
		
		return $newData;
	}
	
	//process data with month
	protected function lastMonth($data){
		
		foreach($data as $item){
			$day = new JDate($item->created);
			$item->created = $day->format('M-d');
		}
		
		$dStart = new JDate('now');
		$dStart->modify ( '-1 month' );
		
		$newData = array();
		for($i = 0; $i<30; $i++){
			$dStart->modify('+1 day');
			$newData[$i]['date'] = $dStart->format('M-d');
			$newData[$i]['total']=0;
		}
	
		foreach($data as $row) {
			foreach($newData as $i=>$value){
				if ($value['date'] == $row->created)
					$newData[$i]['total'] += $row->total;
			}
		}
		
		return $newData;
	}
	
	protected function specificDate($data, $fromDate, $toDate){
		
		$from = strtotime($fromDate)/86400;
		$to = strtotime($toDate)/86400;// 86400 = (60*60*24)s = 1 day;
		$range = intval($to-$from);
		if($range <= 0){
			JFactory::getApplication()->enqueueMessage(JText::_('COM_BOOKPRO_FROM_DATE_GREATER_THAN_TO_DATE'), 'error');
			return false;
		}
		if($range > 60){
			JFactory::getApplication()->enqueueMessage(JText::_('COM_BOOKPRO_TIME_IS_TOO_LONG'), 'error');
			return false;
		}
		
		foreach($data as $item){
			$day = new JDate($item->created);
			$item->created = $day->format('Y-m-d');
		}
		
		$dStart = new JDate($fromDate);
		$dTo = new JDate($toDate);
		$dTo->modify('+1 day');
		$newData = array();		
		$i = 0;
		while($dStart != $dTo){
			$newData[$i]['date'] = $dStart->format('Y-m-d');
			$newData[$i]['total']=0;
			$i++;
			$dStart->modify('+1 day');
		}
		
		foreach($data as $row) {
			foreach($newData as $i=>$value){
				if ($value['date'] == $row->created)
					$newData[$i]['total'] += $row->total;
			}
		}
		
		return $newData;
		
		
		
	}
	/*
	 * drawing revenue chart
	 */
	public function getRevenueChart($range, $fromDate = false, $toDate = false){
		
		$preData = $this->getRevenueData($range,$fromDate,$toDate);
		
		if(!$fromDate || !$toDate || $fromDate == '' || $toDate == ''){
			switch (strtolower($range)){
				case 'lastyear':
					$newData = $this->lastYear($preData);
					break;
				case 'lastmonth':
					$newData = $this->lastMonth($preData);
					break;
				default:
					$newData = $this->lastMonth($preData);
					break;
						
			}
			
		}
		else{
			$newData = $this->specificDate($preData, $fromDate, $toDate);
		}
		
        
         //write data
		$total_array = count($newData);
        $chart = '';
        $chart = "['".JText::_('COM_BOOKPRO_FLIGHT_DATE')."','".JText::_('COM_BOOKPRO_ORDER_TOTAL')." ".JComponentHelper::getParams('com_bookpro')->get('currency_symbol')."']";
               
        for($i = 0;$i<$total_array;$i++){
        	$chart .= ",['".$newData[$i]['date']."',".$newData[$i]['total']."]";
        }
        $data=new JObject();
        $data->data = $chart;
        $data->id = $this->id;
        $data->type = $this->typeChart;
        $data->option = $this->optionChart;
        
        $layout = new JLayoutFile('statistic_chart', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts');
        $html = $layout->render($data);
        return $html;
		
	}
	
	
	public function passengerChart(){
	
	}
	
	public function passengerPerFlightChart(){
	
	}
	
	public function revenuePerAgentChart(){
	
	}
	
	function validateDate($date, $format = 'Y-m-d')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	
	
}
