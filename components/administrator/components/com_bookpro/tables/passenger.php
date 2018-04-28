<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: passenger.php 26 2012-07-08 16:07:54Z quannv $
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );
class TablePassenger extends JTable {
	var $id;
	var $title;
	var $firstname;
var $midlename;
	var $lastname;
	var $gender;
	var $age;
	var $passport;
	var $ppvalid;
	var $country_id;
	var $birthday;
	var $customer_id;
	var $documenttype;
	var $order_id;
	var $group_id;
	var $seat;
	var $return_seat;
	var $route_id;
	var $return_route_id;
	var $price;
	var $return_price;
	var $start;
	var $return_start;
	var $params;
	/**
	 * Construct object.
	 *
	 * @param JDatabaseMySQL $db
	 *        	database connector
	 */
	function __construct(& $db) {
		parent::__construct ( '#__' . PREFIX . '_passenger', 'id', $db );
	}
	
	/**
	 * Init empty object.
	 */
	function check() {
		
		if(!$this->id){
			$this->pnr=uniqid('T');			
		}
		
		return true;
	}
	public function store($updateNulls = false) {
			
			AImporter::helper ( 'date' );


if (DateHelper::createFromFormat ( $this->start )){

$this->start = JFactory::getDate ( DateHelper::createFromFormat ( $this->start )->format('d-m-Y H:i:s') )->toSql ();
}


			//$this->start = JFactory::getDate ( DateHelper::createFromFormat ( $this->start )->format('d-m-Y H:i:s') )->toSql ();


			if ($this->return_start != null && $this->return_start != $this->_db->getNullDate ()){
				
				//$this->return_start = JFactory::getDate ( DateHelper::createFromFormat ( $this->return_start )->format('d-m-Y H:i:s') );
			}
			//echo("test");die;
			
			if (($this->birthday) ){
				if (DateHelper::createFromFormat ( $this->birthday )){
					$this->birthday = JFactory::getDate ( DateHelper::createFromFormat ( $this->birthday )->format('d-m-Y H:i:s') )->toSql ();
				}
			}
			
			if ($this->ppvalid) {
			if (DateHelper::createFromFormat ( $this->ppvalid )){
				$this->ppvalid = JFactory::getDate ( DateHelper::createFromFormat ( $this->ppvalid )->format('d-m-Y H:i:s') )->toSql ();
				}
				}
		
		
		return parent::store ( $updateNulls );
	}
}

?>