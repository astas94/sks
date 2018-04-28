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
AImporter::helper('currency','bookpro');

$from = JFactory::getApplication ()->getUserStateFromRequest ( 'filter.from', 'filter_from' );
$to = JFactory::getApplication ()->getUserStateFromRequest ( 'filter.to', 'filter_to', null );
$this->roundtrip = JFactory::getApplication ()->getUserStateFromRequest ( 'filter.roundtrip', 'filter_roundtrip', 1 );
$this->start = JFactory::getApplication ()->getUserStateFromRequest ( 'filter.start', 'filter_start' );
$this->end = JFactory::getApplication ()->getUserStateFromRequest ( 'filter.end', 'filter_end' );
$this->adult = JFactory::getApplication ()->getUserStateFromRequest ( 'filter.adult', 'filter_adult', 1 );
$this->start = DateHelper::createFromFormat ( $this->start )->format ( 'Y-m-d' );
$this->start_time = JFactory::getApplication ()->getUserStateFromRequest ( 'filter.time', 'filter_time', null );
//echo ($this->start_time);
/*
		$from = 452;//JFactory::getApplication ()->getUserStateFromRequest ( 'filter.from', 'filter_from' );
		$to = 459;//JFactory::getApplication ()->getUserStateFromRequest ( 'filter.to', 'filter_to', null );
		$this->roundtrip = 0;//JFactory::getApplication ()->getUserStateFromRequest ('filter.roundtrip', 'filter_roundtrip', false,'boolean' );
		$this->start = '24.02.2016';//JFactory::getApplication ()->getUserStateFromRequest ( 'filter.start', 'filter_start' );
		echo($to);
		$this->adult = 1;//JFactory::getApplication()->getUserStateFromRequest ( 'filter.adult', 'filter_adult', 1 );
		$this->child = 0;// JFactory::getApplication()->getUserStateFromRequest ( 'filter.child', 'filter_child', 0 );
		$this->senior = 0;//JFactory::getApplication()->getUserStateFromRequest ( 'filter.senior', 'filter_senior',0 );
		$this->start = DateHelper::createFromFormat ($this->start )->format ( 'Y-m-d' );*/
$config=JComponentHelper::getParams('com_bookpro');
/*
$cart = JModelLegacy::getInstance('BusCart', 'bookpro');
$cart->load();

$session_select_seat=$cart->listseat;
$session_select_seat=explode(',', trim($cart->listseat));

*/
//echo "<pre>";print_r($displayData);die;

$going_trips = $displayData;
//var_dump($going_trips[0]->start_time);
//echo 'test000'.$going_trips;
?>
<div class="table-responsive">

<table class="bus-list tablesorter-bootstrap" id="going-list">
	<thead>
		<tr>
			<?php if($config->get('mode')){?>
			<th style="width: 30%;"><?php echo JText::_('COM_BOOKPRO_AGENT')?></th>
			<?php } ?>
			<th style="width: 15%;cursor: pointer;" title="Click to sort by depart time" ><?php echo JText::_('COM_BOOKPRO_ROUTE_DEPART_TIME')?></th>
			<th style="width: 15%;cursor: pointer;" title="Click to sort by arrival time" ><?php echo JText::_('COM_BOOKPRO_ROUTE_ARRIVAL_TIME')?></th>
			<th><?php echo JText::_('COM_BOOKPRO_BUSTRIP_PRICE')?></th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($going_trips)==0) { ?>
		<tr>
			<td colspan="6"><?php echo JText::_('COM_BOOKPRO_BUSTRIP_NOT_FOUND')?>
			</td>
		</tr>
		<?php }?>
		<?php if($going_trips):?>
		<?php $i=1; foreach($going_trips as $row):
				if ($this->start_time==null || strpos($row->start_time, $this->start_time) !== false && strpos($row->start_time, $this->start_time) == 0){
		?>
		 
		<tr class="busitem tablesorter-hasChildRow">
			<?php if($config->get('mode')){?>
			<td valign="top"><span class="bus_title"><?php echo $row->brandname?> </span>
            
				<?php echo $row->bus_name ."<br/>"?>
				
				<?php if($row->agent_logo){ ?>
            	  <img alt="image" src="<?php echo JUri::base().$row->agent_logo;?>" style="max-width: 150px;">
              <?php } ?>   
			</td>
			<?php } ?>
			
			<td valign="top">
			<div class="date-time">
				<?php echo JFactory::getDate($row->start_time)->format('H:i'); ?>
			</div>
			<div id="journey_sum">
				<?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_DURATION_TXT',$row->duration); ?>
			</div>
			</td>
			
			<td valign="top">
			<div class="date-time">
				<?php echo JFactory::getDate($row->end_time)->format('H:i'); ?>
			</div>
			</td>
			
			<td class="price">
			
				 <input type="radio" class="radio_bus" id="bustrip<?php echo $i?>"
				name="bustrip_id" value="<?php echo $row->id?>" /> 
				<?php echo BookProHelper::renderLayout('price', $row);?>
								<?php 
				
				//echo "<pre>";print_r($row);die;
				
				$a_row=$row;
				
				$a_row->return = 0;
				?>
				<?php $a_row->hidden_input_submit_name="listseat_".$a_row->id;?>
				<?php $layout = new JLayoutFile('block', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts/bus'); 
				    //var_dump ($layout);
					$html = $layout->render($a_row);
					if ($html=='Мест нет'){ ?>
					    <div class="viewseat btn btn-warning btn-small"><?php echo JText::_('Мест нет')?></div>
					<?php } 
					else { ?>
					    <div class="viewseat btn btn-success btn-small"><?php echo JText::_('COM_BOOKPRO_VIEW_SEAT')?></div>
					<?php }
					?>
				
			
			</td>

		</tr>
		<tr class="tr_viewseat <?php //echo $row->seat_layout ?> tablesorter-childRow" style="display: none;">
			<td colspan="3">

				
				<?php $layout = new JLayoutFile('block', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts/bus'); 
				    //var_dump ($layout);
					$html = $layout->render($a_row);
					if ($html=='Мест нет'){
					    echo ('Мест нет');
					}
					else {
					    echo $html;
					}
					?>
				<?php if ($html!='Мест нет') { ?>
				<div class="well well-small">
				<div class="form-inline">
					
						<?php 
						$a_row->board_field = 'boarding'.$a_row->id;
						$a_row->form_board = 'stop'.$a_row->id;
						$a_row->dropping_field = 'dropping'.$a_row->id;
						$a_row->form_dropping = 'stopdrop'.$a_row->id;
						
												
						?>
						<!-- Display station list -->
						
						<?php echo BookProHelper::renderLayout('station', $a_row) ?>
						
						
						<?php if($this->roundtrip ==0){ ?>
							<button onclick="submitForm()" type="button" name="btnSubmit" class="btn btn-primary"><?php echo JText::_('COM_BOOKPRO_CONTINUE') ?></button>
						<?php }  ?>
						</div>
				</div>	
				<?php } ?>
			</td>
		</tr>
		<?php $i++; } endforeach;?>

		<?php endif;?>
	</tbody>

</table>
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
				

	 $("#going-list").tablesorter({
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


			
			
		
});
</script>
