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
AImporter::helper('currency');
$config=JComponentHelper::getParams('com_bookpro');
$return_trips = $displayData;
?>
<div class="table-responsive">
<table class="bus-list returnbus" id="return-list" n>
<thead>
		<tr>
		<?php if($config->get('mode')){?>
			<th style="width: 30%;"><?php echo JText::_('COM_BOOKPRO_AGENT')?>
			</th>
			<?php }?>
			<th style="width: 15%;cursor: pointer;" title="Click to sort by depart time" ><?php echo JText::_('COM_BOOKPRO_ROUTE_DEPART_TIME')?></th>
			<th style="width: 15%;cursor: pointer;" title="Click to sort by arrival time" ><?php echo JText::_('COM_BOOKPRO_ROUTE_ARRIVAL_TIME')?></th>
			
			<th><?php echo JText::_('COM_BOOKPRO_BUSTRIP_PRICE')?>
			</th>
		</tr>
	</thead>
		<tbody>
		<?php if (count($return_trips)==0) { ?>
			<tr><td colspan="3">
				
				<span class="warning"><?php echo JText::_('COM_BOOKPRO_BUSTRIP_NOT_FOUND')?></span> 
			
				<input type="button" id="return_submit" value="<?php echo JText::_('COM_BOOKPRO_CONTINUE_WITHOUT_RETURN')?>" class="btn btn-primary">
			
			</td></tr>
		<?php }?>
		<?php if($return_trips):?>
		<?php 
		$i=1; foreach($return_trips as $row):
			
		?>
	
		<tr class="busitem tablesorter-hasChildRow">	
		<?php if($config->get('mode')){?>		
			<td valign="top"><span class="bus_title"><?php echo $row->brandname?> </span>
			<?php echo $row->bus_name."<br>"?>
			 <?php if($row->agent_logo){ ?>
            <img alt="image" src="<?php echo JUri::base().$row->agent_logo;?>" style="max-width: 150px;">
                <?php } ?>
			</td>
			<?php } ?>
			
			<td valign="top">
			<div class="date-time">
				<?php echo JFactory::getDate($row->start_time)->format('H:i A'); ?>
			</div>
			<div id="journey_sum">
				<?php 
			
				echo JText::sprintf('COM_BOOKPRO_BUSTRIP_DURATION_TXT',$row->duration); ?>
			</div>
			</td>
			
			<td valign="top">
			<div class="date-time">
				<?php echo JFactory::getDate($row->end_time)->format('H:i A'); ?>
			</div>
			</td>
			
			<td class="price">			
			<?php 
			
			 ?> <input type="radio" class="radio_bus" id="return_bustrip<?php echo $i?>" name="return_bustrip_id" value="<?php echo $row->id?>" /> 
				<?php 
				$layout = new JLayoutFile('price', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts');
				$html = $layout->render($row);
				echo $html;
				?>
				
			</td>
			
		</tr>
		
		<?php $i++; endforeach;?>
	<?php endif;?>
	</tbody>
	
</table>
<input type="hidden" id="filter_roundtrip_return" name="filter_roundtrip" value="1" />
</div>
<script type="application/javascript">
 
jQuery(document).ready(function($) {
	
	 		$.tablesorter.themes.bootstrap = {
			    // these classes are added to the table. To see other table classes available,
			    // look here: http://getbootstrap.com/css/#tables
			    table        : 'table table-bordered table-striped',
			    caption      : 'caption',
			    // header class names
			    header       : 'bootstrap-header', // give the header a gradient background (theme.bootstrap_2.css)
			    sortNone     : '',
			    sortAsc      : '',
			    sortDesc     : '',
			    active       : '', // applied when column is sorted
			    hover        : '', // custom css required - a defined bootstrap style may not override other classes
			    // icon class names
			    icons        : '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
			    iconSortNone : 'bootstrap-icon-unsorted', // class name added to icon when column is not sorted
			    iconSortAsc  : 'icon-chevron-up glyphicon glyphicon-chevron-up', // class name added to icon when column has ascending sort
			    iconSortDesc : 'icon-chevron-down glyphicon glyphicon-chevron-down', // class name added to icon when column has descending sort
			    filterRow    : '', // filter row class
			    footerRow    : '',
			    footerCells  : '',
			    even         : '', // even row zebra striping
			    odd          : ''  // odd row zebra striping
			  };
	
	 $("#return-list").tablesorter({
			theme : "bootstrap",
			cssChildRow: "tablesorter-childRow",
		    widthFixed: true,

		    headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!

		    // widget code contained in the jquery.tablesorter.widgets.js file
		    // use the zebra stripe widget if you plan on hiding any rows (filter widget)
		    widgets : [ "uitheme", "zebra" ],

		    widgetOptions : {
		      // using the default zebra striping class name, so it actually isn't included in the theme variable above
		      // this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
		      zebra : ["even", "odd"]
		    }
			});

		$('#return_submit').click(function() {

			$("#filter_roundtrip_return").val('0');
			$("#bustrip_form").submit();
			
		});
});
</script>
