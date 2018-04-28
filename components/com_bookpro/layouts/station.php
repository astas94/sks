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
$station = $displayData->stations;

$boardings = BusHelper::getStationSelectByType ( $station, 1 );
$droppings = BusHelper::getStationSelectByType ( $station, 2 );

if (count ( $station ) > 0) {
	
	if (count ( $boardings ) > 0) {
		
		?>
							
								<?php echo JText::_('COM_BOOKPRO_SELECT_BOARDING_POINT')?>
								<?php
		
echo JHtmlSelect::genericlist ( $boardings, $displayData->board_field, 'class="boarding_point"', 'id', 'stoptitle', null, $displayData->board_field );
		?>
							
							<?php } ?>
							
						<?php if (count ( $droppings ) > 0) {	?>			
							
							
							<?php echo JText::_('COM_BOOKPRO_SELECT_DROPPING_POINT')?>
							<?php
		
echo JHtmlSelect::genericlist ( $droppings, $displayData->dropping_field, 'class="boarding_point"', 'id', 'stoptitle', null, $displayData->dropping_field );
	}
}
?>