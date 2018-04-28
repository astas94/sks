<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: view.html.php 26 2012-07-08 16:07:54Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');

//import needed JoomLIB helpers
AImporter::helper( 'bookpro');
AImporter::model('bustrip');


class BookProViewRoomRates extends JViewLegacy
{
 
    var $bustrip;
    
    function display($tpl = null)
    {
        $document = JFactory::getDocument();
        $document->addScript(JUri::base().'components/com_bookpro/assets/js/pncalendar.js');
        $bustrip_id=JFactory::getApplication()->input->get('bustrip_id');
        $model=new BookProModelBusTrip();
        $this->bustrip=$model->getComplexItem($bustrip_id);
        
        parent::display($tpl);
        
       
    }                                                             
}

?>