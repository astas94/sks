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

class DateHelper {
	public static function formatDate($date, $joomla_format = "DATE_FORMAT_LC3") {
		if ($date == '0000-00-00 00:00:00')
			return 'N/A';
		$format = JText::_ ( $joomla_format );
		return JHTML::_ ( 'date', $date, $format );
	}
	static function dayofweek() {
		$days = array (
				1 => 'ПН',
				2 => 'ВТ',
				3 => 'СР',
				4 => 'ЧТ',
				5 => 'ПТ',
				6 => 'СБ',
				7 => 'ВС' 
		);
		return $days;
	}
	static function convertHourToDay($hour){
		if ($hour < 24){
			return JText::sprintf('COM_BOOKPRO_REFUND_HOUR_TXT',$hour);
		}else{
			$day =$hour/24;
			$day = (int) $day;
			$new_hour = $hour%24;
			return JText::sprintf('COM_BOOKPRO_REFUND_HOUR_DAY_TXT',$day,$new_hour);
		}
			
		
	}
	static function toLongDate($date) {
		if ($date == '0000-00-00 00:00:00')
			return 'N/A';
		$configJ = JComponentHelper::getParams ( 'com_bookpro' );
		$format = $configJ->get ( 'date_long', 'D, d M Y' );
		return JFactory::getDate($date)->format($format);
	}
	
	static function toNormalDate($date) {
		if ($date == '0000-00-00 00:00:00')
			return 'N/A';
		$configJ = JComponentHelper::getParams ( 'com_bookpro' );
		$format = $configJ->get ( 'date_normal', 'd-m-Y H:i:s' );
		return JHTML::_ ( 'date', $date, $format );
	}
	static function toShortDate($date) {
		if ($date == '0000-00-00 00:00:00')
			return 'N/A';
		$configJ = JComponentHelper::getParams ( 'com_bookpro' );
		$format = $configJ->get ( 'date_day_short', 'Y-m-d' );
		return JFactory::getDate($date)->format($format);
	}

static function toShortTime($date) {
		if ($date == '0000-00-00 00:00:00')
			return 'N/A';
		$configJ = JComponentHelper::getParams ( 'com_bookpro' );
		$format = $configJ->get ( 'date_time_short', 'H:i' );
		return JFactory::getDate($date)->format($format);
	}
	
	static function JfactoryGetDateAndFormat($date, $format = "DATE_FORMAT_LC3") {
		if ($date == '0000-00-00 00:00:00') {
			return '';
		} else {
			return JFactory::getDate ( $date )->format ( $format );
		}
	}
	public static function formatSqlDate($date, $format = "DATE_FORMAT_LC3") {
		if ($date == '0000-00-00 00:00:00') {
			
			return JText::_ ( "COM_BOOKPRO_NOT_AVAILABLE" );
		} else {
			
			return JHTML::_ ( 'date', $date, $format );
		}
	}
	public static function formatTime12($value) {
		return date ( "g:i a", strtotime ( $value ) );
	}
	public static function formatMultiDate($date, $joomla_format = "DATE_FORMAT_LC3") {
		$datearr = explode ( ';', $date );
		$format = JText::_ ( $joomla_format );
		$result = array ();
		for($i = 0; $i < count ( $datearr ); $i ++) {
			$dateObj = JFactory::getDate ( $datearr [$i] );
			$result [] = JHTML::_ ( 'date', $dateObj, $format );
		}
		return $result;
	}
	static function getDateArray($numberofday, $start) {
		for($i = 0; $i < $numberofday; $i ++) {
			$sdate = JFactory::getDate ( $start );
			$sdate->add ( new DateInterval ( 'P' . abs ( $i ) . 'D' ) );
			$date_arr [] = $sdate;
		}
		return $date_arr;
	}
	function getOffsetDay($count, $start) {
		$date = $start + $count * 24 * 60 * 60;
		return $date;
	}
	public static function getCountDay($start, $end) {
		$start = strtotime ( $start );
		$end = strtotime ( $end );
		$days_between = ceil ( abs ( $end - $start ) / 86400 );
		return $days_between;
	}
	public static function dateBeginDay($date) {
		return JFactory::getDate ( JFactory::getDate ( $date )->format ( 'Y-m-d 00:00:00' ) );
	}
	public static function dateEndDay($date) {
		return JFactory::getDate ( JFactory::getDate ( $date )->format ( 'Y-m-d 23:59:59' ) );
	}
	public static function dateBeginWeek($date, $tzoffset = 0) {
		$date = strtotime ( 'last Monday', $date );
		
		return $date;
	}
	public static function dateEndWeek($date, $tzoffset = 0) {
		$date = strtotime ( 'next Sunday', $date );
		return $date;
	}
	function startMonth($m, $y) {
		$date = date ( 'Y-m-d H:i:s', mktime ( 0, 0, 0, $m, 01, $y ) );
		return $date;
	}
	function endMonth($d, $m, $y) {
		$date = date ( 'Y-m-d H:i:s', mktime ( 23, 59, 59, $m, $d, $y ) );
		return $date;
	}
	public static function dateBeginMonth($date, $tzoffset = 0) {
		$fromdate = date ( '01-m-Y 00:00:00', $date );
		
		// $date = strtotime('first day this month',$date);
		$fromdate = strtotime ( $fromdate );
		return $fromdate;
	}
	public static function dateEndMonth($date, $tzoffset = 0) {
		$todate = date ( 't-m-Y 23:59:59', $date );
		
		$todate = strtotime ( $todate );
		return $todate;
	}
	
	/**
	 * Convert date into given format with given time zone offset.
	 *
	 * @param $date string
	 *        	date to convert
	 * @param $format string
	 *        	datetime format
	 * @param $tzoffset int
	 *        	time zone offset
	 * @return BookProDate
	 */
	public static function convertDate($date, $format = '%Y-%m-%d %H:%M:%S', $tzoffset = false) {
		static $cache;
		$key = $date . $format . $tzoffset;
		if (! isset ( $cache [$key] )) {
			if ($tzoffset) {
				$mainframe = JFactory::getApplication ();
				/* @var $mainframe JApplication */
				$jdate = JFactory::getDate ( $date, $mainframe->getCfg ( 'config' ) );
				/* @var $date JDate */
				$jdate->setOffset ( $mainframe->getCfg ( 'config' ) );
			} else {
				$jdate = JFactory::getDate ( $date );
				/* @var $jdate JDate */
			}
			$output = new BookProDate ();
			$output->orig = $date;
			$output->uts = $jdate->toUnix ();
			$output->dts = $jdate->toFormat ( $format, $tzoffset );
			$cache [$key] = $output;
		}
		return $cache [$key];
	}
	/**
	 * @param string $type: P- PHP format, M- Mootools, J: Javascript
	 * @return date formart of javascript
	 */
	static function getConvertDateFormat($type = 'P') {
		$type = strtoupper ( $type );
		$configJ = JComponentHelper::getParams ( 'com_bookpro' );
		$php_format = $configJ->get ( 'date_day_short', 'Y-m-d' );
		
		if ($type == "P") {
			return $php_format;
		} else {
			
			// $type is param for PHP and Mooltoos and Javascript
			if ($type == "M") {
				$SYMBOLS_MATCHING = array (
						// Day
						'd' => '%d',
						'D' => '%D',
						'j' => '%j',
						'l' => '%l',
						'N' => '%N',
						'S' => '%S',
						'w' => '%w',
						'z' => '%z',
						// Week
						'W' => '%W',
						// Month
						'F' => '%F',
						'm' => '%m',
						'M' => '%M',
						'n' => '%n',
						't' => '%t',
						// Year
						'L' => '%L',
						'o' => '%o',
						'Y' => '%Y',
						'y' => '%y',
						// Time
						'a' => '%a',
						'A' => '%A',
						'B' => '%B',
						'g' => '%g',
						'G' => '%G',
						'h' => '%h',
						'H' => '%H',
						'i' => '%i',
						's' => '%s',
						'u' => '%u' 
				);
			} elseif ($type == "J") {
				$SYMBOLS_MATCHING = array (
						// Day
						'd' => 'dd',
						'D' => 'D',
						'j' => 'd',
						'l' => 'DD',
						'N' => '',
						'S' => '',
						'w' => '',
						'z' => 'o',
						// Week
						'W' => '',
						// Month
						'F' => 'MM',
						'm' => 'mm',
						'M' => 'M',
						'n' => 'm',
						't' => '',
						// Year
						'L' => '',
						'o' => '',
						'Y' => 'yy',
						'y' => 'y',
						// Time
						'a' => '',
						'A' => '',
						'B' => '',
						'g' => '',
						'G' => '',
						'h' => '',
						'H' => '',
						'i' => '',
						's' => '',
						'u' => '' 
				);
				
				
			}elseif ($type == "B") {
				$SYMBOLS_MATCHING = array (
						// Day
						'd' => 'dd',
						'D' => 'D',
						'j' => 'd',
						'l' => 'DD',
						'N' => '',
						'S' => '',
						'w' => '',
						'z' => 'o',
						// Week
						'W' => '',
						// Month
						'F' => 'MM',
						'm' => 'mm',
						'M' => 'M',
						'n' => 'm',
						't' => '',
						// Year
						'L' => '',
						'o' => '',
						'Y' => 'yyyy',
						'y' => 'y',
						// Time
						'a' => '',
						'A' => '',
						'B' => '',
						'g' => '',
						'G' => '',
						'h' => '',
						'H' => '',
						'i' => '',
						's' => '',
						'u' => '' 
				);
			}
			$jqueryui_format = "";
			$escaping = false;
			
			for($i = 0; $i < strlen ( $php_format ); $i ++) {
				$char = $php_format [$i];
				if ($char === '\\') 				// PHP date format escaping character
				{
					$i ++;
					if ($escaping)
						$jqueryui_format .= $php_format [$i];
					else
						$jqueryui_format .= '\'' . $php_format [$i];
					$escaping = true;
				} else {
					if ($escaping) {
						$jqueryui_format .= "'";
						$escaping = false;
					}
					if (isset ( $SYMBOLS_MATCHING [$char] ))
						$jqueryui_format .= $SYMBOLS_MATCHING [$char];
					else
						$jqueryui_format .= $char;
				}
			}
			return $jqueryui_format;
		}
	}
	/**
	 * Convert javascript string to PHP datetime
	 */
	static function createFromFormat($js_string_date) {
		$configJ = JComponentHelper::getParams ( 'com_bookpro' );
		if(strlen($js_string_date)>10)
			$php_format=$configJ->get('date_normal');
		else
		  $php_format = $configJ->get ( 'date_day_short', 'Y-m-d' );
		
		$date =  JDate::createFromFormat($php_format, $js_string_date );
		
		return $date;
	}
	/**
	 * 
	 * @param unknown $start_time
	 * @param unknown $end_time
	 * @return duration in hour minute;
	 */
	static function getDuration($start_time,$end_time){
		$start_time=JFactory::getDate()->format('Y-m-d').' '.$start_time;
		$start_time=JFactory::getDate($start_time);
		$end_time=JFactory::getDate($end_time)->format('Y-m-d').' '.$end_time;
		$end_time=JFactory::getDate($end_time);
		$interval= $end_time->diff($start_time);
		$hour=$interval->days*24+$interval->h;
		$minute=$interval->i;
		return $hour.':'.$minute;
		
	}
	static function formatTime($value) {
		$config = JComponentHelper::getParams ( 'com_bookpro' );
		$value = JFactory::getDate ()->format ( 'Y-m-d' ) . ' ' . $value;
		return JFactory::getDate ( $value )->format ( trim ( $config->get ( 'timespace' ) ) );
	}
}