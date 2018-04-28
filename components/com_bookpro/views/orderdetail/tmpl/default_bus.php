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

?>

<div class="well well-small wellwhite">

<?php

$this->order->passenger_onward = 0;
$this->order->passenger_return = 0;

$exist=0;

foreach($this->order->passengers as $passenger)
{
	if ($passenger->passenger_status == "CONFIRMED") $exist=1;
}

if($exist == 1)

{

$this->order->passenger_onward = 1;

?>

		<div class="row-fluid">
				<?php echo BookProHelper::renderLayout('tripinfo', $this->order)?>
		</div>	
		<div class="row-fluid">
			<?php 
				echo BookProHelper::renderLayout('passengers', $this->order);
			?>
		</div>

<?php

}

$this->order->passenger_onward = 0;
$this->order->passenger_return = 0;

$exist=0;

foreach($this->order->passengers as $passenger)
{
	if ($passenger->passenger_status_return == "CONFIRMED") $exist=1;
}

if($exist == 1)

{

$this->order->passenger_return = 1;

?>

		<div class="row-fluid">
				<?php echo BookProHelper::renderLayout('tripinfo', $this->order)?>
		</div>	
		<div class="row-fluid">
			<?php 
				echo BookProHelper::renderLayout('passengers', $this->order);
			?>
		</div>

<?php

}

?>

		<div class="row-fluid" >
		<div class="span6 offset6">
		<?php echo BookProHelper::renderLayout('charge', $this->order) ?>
		</div>
		</div>
	

</div>