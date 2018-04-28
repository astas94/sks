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
$subject = $displayData;
?>


<h2><?php echo $subject->title ?></h2>

<table width="100%" class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th align="left"><?php echo JText::_('COM_BOOKPRO_BUSTRIP_ROUTE')?></th>
			<th align="left"><?php echo JText::_('COM_BOOKPRO_BUSTRIP_DATE_TIME'); ?></th>
			
		</tr>
	</thead>
	<tr>
			<td valign="top">
				<div id="journey">
					<div class="depart">
					<?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_DEPART_FROM',$subject->from_name) ?>
					</div> 
					<div class="arrival"><?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_ARRIVAL_TO',$subject->to_name) ?>
					</div>
					<div><?php echo $subject->brandname; ?></div>
				</div></td>
			<td>
			<div id="journey_sum">
				<span class="date"> <?php echo  JText::sprintf('COM_BOOKPRO_BUSTRIP_DEPART_DATE',JFactory::getDate($subject->depart_date)->format('d-m-Y')) ?>
							
							</span>
			<?php $layout = new JLayoutFile('station', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts'); 
					$html = $layout->render($subject);
					echo $html;
					?>
					
				</div>	
			
					</td>
			
		</tr>
</table>
<?php 
	$passengers = $subject->passengers;
	$layout = new JLayoutFile('passengers', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts');
	$html = $layout->render($subject);
	echo $html;
?>

