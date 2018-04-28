<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 26 2012-07-08 16:07:54Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');
JHtml::_('jquery.framework');
AImporter::css('calendar');
$document = JFactory::getDocument();
 $document->addScript(JUri::base().'components/com_bookpro/assets/js/pncalendar.js');
require_once JPATH_COMPONENT_ADMINISTRATOR.'/classes/calendar.php';
$this->bustrip=$this->obj;
?>
<script type="text/javascript">

var ajaxurl = "<?php echo JUri::base().'index.php?option=com_bookpro&controller=bustrip&task=calendar&bustrip_id='.$this->bustrip->id ?>";
var pn_appointments_calendar = null;
jQuery(function() {
    pn_appointments_calendar = new PN_CALENDAR();
    pn_appointments_calendar.init();
});
</script>
<script type="text/javascript">
function deleteRate(id,month,year){
	
	var ajaxurl = "<?php echo JUri::base().'index.php?option=com_bookpro&controller=bustrip&task=deleteRate&bustrip_id='.$this->bustrip->id ?>";
	 var data = {
             action: "pn_get_month_cal",
             month: month,
             year: year,
             id:id
         };
         jQuery.post(ajaxurl, data, function(response) {
        	
             jQuery('#pn_calendar').html(response);
         });
}
</script>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<?php
       
       $calendar = new PN_Calendar();
       echo $calendar->draw();
 ?>

<input type="hidden" name="room_id" value=<?php echo JFactory::getApplication()->input->get('bustrip_id')  ?>/>
 </form>	


