<?php

/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: currency.php 16 2012-06-26 12:45:19Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');
?>

<div class="register-row">
    	<label> <?php echo JText::_( 'COM_BOOKPRO_CARD_SELECT' ); ?> </label>
    	<span>Visa</span><input type="radio" name="creditcardtype" id="Visa" value="Visa">
    	<span>MasterCard</span><input type="radio" name="creditcardtype" id="MasterCard" value="MasterCard" >
    	<span>Discover</span><input type="radio" name="creditcardtype" id="Discover" value="Discover" >
    	<span>Amex</span><input type="radio" name="creditcardtype" id="Amex" value="Amex" >
    </div>		
	<div class="register-row" >
    	<label for="first name"> <?php echo JText::_( 'COM_BOOKPRO_CARD_NUMBER'); ?> </label>
    	<input type="text" name="cardnumber" value="" style="width:150px; height:22px;" id="cardnumber">
    </div>
    <div class="register-row" >
    	<label for="first name"> <?php echo JText::_( 'COM_BOOKPRO_CARD_EXPIRED'); ?> </label>
    	<?php echo JText::_( 'COM_BOOKPRO_MONTH'); ?>
		<select name="month" style="width:50px; margin-right:10px; height:25px;" id="month" >
			<option value="01">01</option>
			<option value="02">02</option>
			<option value="03">03</option>
			<option value="04">04</option>
			<option value="05">05</option>
			<option value="06">06</option>
			<option value="07">07</option>
			<option value="08">08</option>
			<option value="09">09</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
		</select>
    	<?php echo JText::_( 'COM_BOOKPRO_YEAR'); ?>
    	<?php $year = getdate(); echo JHtmlSelect::integerlist($year['year'], $year['year']+10, 1, 'year','class="inputbox" style="width:70px; height:25px;" id="year"','')?>
    </div>	
    <div class="register-row" >
    	<label for="first name"> <?php echo JText::_( 'COM_BOOKPRO_CARD_HOLDER' ); ?> </label>
    	<input type="text" name="cardhodername" value="" style="width:150px; height:22px;" id="cardhodername">
    </div>	
    <div class="register-row" >
    	<label for="first name"> <?php echo JText::_( 'COM_BOOKPRO_CARD_CVV' ); ?> </label>
    	<input type="text" name="cvv2number" value="" style="width:80px;" id="cvv2number">
    </div> 