<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php  23-06-2012 23:33:14
 **/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

/**
 * BookPro Model
 */
class BookProModelBookPro extends JModelItem
{
	/**
	 * @var string msg
	 */
	protected $msg;

	public function __construct($config=array()){
		parent::__construct($config);

	}
	
	public function getRouteTitle($from,$to){

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('title')->from('#__bookpro_dest')->where('id='.$from);
		$query->union('SELECT title FROM #__bookpro_dest WHERE id='.$to);
		$db->setQuery($query);
		$result = $db->loadResultArray();
		$str = $result[0] . $result[1];
		return $str;

	}


	

	
	
	public function getToAirportByFrom($from){
		$db = JFactory::getDBO();
		$query =$db->getQuery(true);
		$query->select('f.`desto` AS `key` ,`d2`.`value` AS `value`');
		$query->from('#__bookpro_flight AS f');
		$query->leftJoin('#__bookpro_dest AS d2 ON f.desto =d2.id');
		$query->where(array('f.desfrom='.$from,'f.state=1'));
		$query->group('f.desto');
		$sql = (string)$query;
		$db->setQuery($sql);
		$flight = $db->loadObjectList();
		return $flight;

	}
	
	
	
	


}