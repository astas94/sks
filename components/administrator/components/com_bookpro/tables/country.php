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
class TableCountry extends JTable
{
  
    var $id;
    var $country_name;
    var $country_code;
    var $desc;
    var $visainfo;
    var $state;
    var $region_id;
   
    /**
     * Construct object.
     * 
     * @param JDatabaseMySQL $db database connector
     */
    function __construct(& $db)
    {
        parent::__construct('#__bookpro_country', 'id', $db);
    }
    function init(){
    	$this->id = 0;
        $this->country_name = '';
        $this->country_code = '';
        $this->desc='';
        $this->visainfo='';
        $this->state=1;
        $this->region_id=0;
    }
}