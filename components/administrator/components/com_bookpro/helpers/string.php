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
AImporter::helper('date');
class AString
{

    function getSafe($string)
    {
        $chTable = array('ä' => 'a' , 'Ä' => 'A' , 'á' => 'a' , 'Á' => 'A' , 'č' => 'c' , 'Č' => 'C' , 'ć' => 'c' , 'Ć' => 'C' , 'ď' => 'd' , 'Ď' => 'D' , 'ě' => 'e' , 'Ě' => 'E' , 'é' => 'e' , 'É' => 'E' , 'ë' => 'e' , 'Ë' => 'E' , 'í' => 'i' , 'Í' => 'I' , 'ľ' => 'l' , 'Ľ' => 'L' , 'ń' => 'n' , 'Ń' => 'N' , 'ň' => 'n' , 'Ň' => 'N' , 'ó' => 'o' , 'Ó' => 'O' , 'ö' => 'o' , 'Ö' => 'O' , 'ř' => 'r' , 'Ř' => 'R' , 'ŕ' => 'r' , 'Ŕ' => 'R' , 'š' => 's' , 'Š' => 'S' , 'ś' => 's' , 'Ś' => 'S' , 'ť' => 't' , 'Ť' => 'T' , 'ů' => 'u' , 'Ů' => 'U' , 'ú' => 'u' , 'Ú' => 'U' , 'ü' => 'u' , 'Ü' => 'U' , 'ý' => 'y' , 'Ý' => 'Y' , 'ž' => 'z' , 'Ž' => 'Z' , 'ź' => 'z' , 'Ź' => 'Z');
        $string = strtr($string, $chTable);
        $string = str_replace('-', ' ', $string);
        $string = preg_replace(array('/\s+/' , '/[^A-Za-z0-9\-]/'), array('-' , ''), $string);
        $string = JString::strtolower($string);
        $string = JString::trim($string);
        return $string;
    }
    public static function formatTourDate($str,$glue){
    	$date= explode(',', $str);
    	$result=array();
    	for ($i = 0; $i < count($date); $i++) {
    		$result[]=DateHelper::formatDate($date[$i]);
    	}
    	return implode($glue,$result);
    }
    public static function formatDate($date){
    	$check_in=new JDate($date);
    	return date_format($check_in,'F j, Y');
    }
    public static function formatprice($value,$config){
     
    	if ($value) {
    		$value = number_format($value, 2, ',', ',');
    		$length = JString::strlen($value);
    		if (JString::substr($value, $length - 2) == '00')
    			$newval= JString::substr($value, 0, $length - 3);
    		elseif (JString::substr($value, $length - 1) == '0')
    			$newval= JString::substr($value, 0, $length - 1);
    		else
    			$newval=$value;
    	}
    	return $value?$config->mainCurrency.$newval:JText::_('N/A');
    }
}

?>