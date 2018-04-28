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

class TableCurrency extends JTable
{
  
    var $id;
    var $currency_name;
    var $currency_code;
    var $currency_symbol;
    var $currency_exchange_rate;
    var $thousand_currency;
    var $currency_display;
    var $status;
    
   
    /**
     * Construct object.
     * 
     * @param JDatabaseMySQL $db database connector
     */
    function __construct(& $db)
    {
        parent::__construct('#__bookpro_currency', 'id', $db);
    }

    /**
     * Init empty object.
     */
    function init()
    {
        $this->id = 0;
        $this->currency_name='';
        $this->currency_code = '';
        
        
        $this->currency_exchange_rate = 0;
        $this->currency_display = '';
        $this->thousand_currency =0;
    	$this->state;    
       
    }
	function check()
	{
	 
	    return true;
	}
}

?>