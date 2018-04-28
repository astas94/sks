<?php 
	/**
	 * @package 	Bookpro
	 * @author 		Ngo Van Quan
	 * @link 		http://joombooking.com
	 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
	 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
	 * @version 	$Id$
	 **/
	
	defined('_JEXEC') or die('Restricted access');
	echo '<script type="text/javascript">window.onload = function() { window.print(); }</script>';
	
?>

<style>

#content, #header, #footer {
    width: 650px; /* Considered a "safe" print pixel width and matches EAN email width format */
    margin: 0 auto;
}

#utility-bar {
    font-size: .75em;
    display: block;
    margin: 11px 0;
}

.primary-page-content {
    width: 420px;
}

.alternate-page-options {
    width: 214px;
}

.static-map-image {
    height: 102px !important; /* size the map div to the size of the column since the map is a background image */
}

#hotel-details-actions {
    visibility: hidden;
    display: none;
}

.single-content-section {
    margin-bottom: 6px;
}

dl {
    width: 100%;
    overflow: hidden;
}

dt,
dd {
    float: left !important;
    line-height: 1.5em;
}

dt {
   
    clear: left;
}

dd {
    width: 70%;
}
.round-box {
border-style: solid;
border-width: 1px;
padding: 10px;
border-color: #ccc;
}

</style>
<div id="content">
<h2 class="page-title-header round-box"><?php echo JText::_('COM_BOOKPRO_RECEIPT') ?></h2>

<div id="receipt-booking-details" class="single-content-section round-box">
    <p>Booking Details</p>
    <dl>
        <dt> <?php echo JText::_('COM_BOOKPRO_ORDER_CREATED') ?>:</dt>
        <dd><?php echo JHtml::_('date',$this->order->created)?>:</dd>
        <dt><?php echo JText::_('COM_BOOKPRO_ORDER_NUMBER') ?>:</dt>
        <dd><?php echo $this->order->order_number ?></dd>
        <dt><?php echo JText::_('COM_BOOKPRO_BILLING_NAME') ?>:</dt>
        <dd><?php echo $this->customer->firstname.' '. $this->customer->lastname ?></dd>
        <dt><?php echo JText::_('COM_BOOKPRO_BILLING_ADDRESS') ?>:</dt>
        <dd><?php echo $this->customer->address ?></li>
    	</dd>
    </dl>
</div>

<div class="well well-small wellwhite">

		
		<div class="row-fluid">
				<?php echo BookProHelper::renderLayout('tripinfo', $this->order)?>
		</div>	
		<div class="row-fluid">
			<?php 
				echo BookProHelper::renderLayout('passengers', $this->order);
			?>
		</div>
		<div class="row-fluid" >
		<div class="span6 offset6">
		<?php echo BookProHelper::renderLayout('charge', $this->order) ?>
		</div>
		</div>
	

</div>
</div>