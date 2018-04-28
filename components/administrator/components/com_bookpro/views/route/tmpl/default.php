<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 81 2012-08-11 01:16:36Z quannv $
 **/


defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.formvalidation');
JToolBarHelper::title('Route map');
JToolBarHelper::cancel();
JFactory::getDocument()->addScript('https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true');

$tempstr=$this->obj->route;
usort($this->destinations, function($a, $b) use ($tempstr) {
//$tempstr=$this->obj->route;
$a0=strrpos($tempstr, $a->id);
$b0=strrpos($tempstr,  $b->id);
    if ($a0 == $b0 ) {
        return 0;
    }
    return ($a0 < $b0 ) ? -1 : 1;
});

foreach ($this->destinations as $value) {
	if($value->latitude &&$value->longitude )
		$geo[]=$value->latitude.','.$value->longitude;
}
$strgeo='["'.implode('|', $geo).'"]';

?>

 <style>
      #map-canvas {
        height: 500px;
        margin: 0px;
        padding: 0px
      }
   </style>
   <script type="text/javascript">
   function initialize() {

	   var r= <?php echo $strgeo ?>;
		var coordinates = r[0].split("|");
	var flightPlanCoordinates = new Array();
	for(i=0;i<coordinates.length;i++)
	{  
	 var point =new google.maps.LatLng(coordinates[i].split(',')[0],coordinates[i].split(',')[1]);
	 flightPlanCoordinates.push(point);   
	}   
	   
		  var mapOptions = {
		    zoom: 3,
		    center: flightPlanCoordinates[0],
		    mapTypeId: google.maps.MapTypeId.TERRAIN
		  };

		  var map = new google.maps.Map(document.getElementById('map-canvas'),
		      mapOptions);
			
			
		 
		  var flightPath = new google.maps.Polyline({
		    path: flightPlanCoordinates,
		    geodesic: true,
		    strokeColor: '#FF0000',
		    strokeOpacity: 1.0,
		    strokeWeight: 2
		  });

		  flightPath.setMap(map);
		}

		google.maps.event.addDomListener(window, 'load', initialize);
</script>
   


<center>
<form action="index.php" method="post" name="adminForm" id="adminForm"
	class="form-validate">
	
	<div class="container-fluid">
	<div class="span4">
	<div class="well">
	<?php 
	echo JText::_('COM_BOOKPRO_NAME_CODE').$this->obj->code;

$tempstr=$this->obj->route;
usort($this->destinations, function($a, $b) use ($tempstr) {
//$tempstr=$this->obj->route;
$a0=strrpos($tempstr, $a->id);
$b0=strrpos($tempstr,  $b->id);
    if ($a0 == $b0 ) {
        return 0;
    }
    return ($a0 < $b0 ) ? -1 : 1;
});
	
	foreach ($this->destinations as $value) {
	 
		$route[]='<div style="border:1px solid gray;border-radius:10px;">'.'<a href=" '.JUri::base().'index.php?option=com_bookpro&view=bustrip&layout=edit&id='.$value->id.' ">'.'<b>'.$value->title.'</a>'.'</div>';
		
	}	
	$glue="<div style='font-weight:bold;'>&#8595;</div>";
	$html=implode($glue, $route);
	echo $html;

	?>
	</div>
	</div>	
	<div class="span8">
	
	<div id="map-canvas"></div>
	
	</div>

	
	</div>
	<input type="hidden" name="option" value="<?php echo OPTION; ?>" /> <input
		type="hidden" name="controller"
		value="<?php echo CONTROLLER_BUSTRIP; ?>" /> <input type="hidden"
		name="task" value="save" /> <input type="hidden" name="boxchecked"
		value="1" /> <input type="hidden" name="cid[]"
		value="<?php echo $this->obj->id; ?>" id="cid" />

	<?php echo JHtml::_('form.token'); ?>
</form>
</center>
