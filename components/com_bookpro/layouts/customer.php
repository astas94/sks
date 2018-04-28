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
$config=JComponentHelper::getParams('com_bookpro');
$this->customer = $displayData;
$user = JFactory::getUser();
if (!$user->guest) {
    $account=JBFactory::getAccount();
}
						if($account && $account->isNormal){
						  $firstname=$account->firstname;
						  $midlename=$account->midlename;
						  $lastname=$account->lastname;
						  $mobile=$account->mobile;
						  $email=$account->email;
						  //var_dump ($account);
						}
?>
<div class="well-small" style="background-color: white;">
		
		<div class="head-box">
			<span><?php echo JText::_('Данные покупателя')?> </span>
		</div>
<div class="form-horizontal">
		<fieldset>
		
		<div class="control-group">
			<label class="control-label" for="firstname"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_FIRSTNAME' ); ?>
			</label>
			<div class="controls">
				<input class="inputbox required" type="text" id="firstname" required
				name="firstname" id="firstname" size="30" maxlength="50"
				value="<?php echo isset($account->firstname)?$account->firstname:null ?>" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_FIRSTNAME' ); ?>" />
			</div>
		</div>

<?php if ($config->get('rs_midlename', 1)){?>
			<div class="control-group">
				<label class="control-label" for="midlename"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_MIDLENAME' ); ?>
				</label>
				<div class="controls">
					<input class="inputbox required" type="text" name="midlename"
					id="midlename" size="30" maxlength="50"
					value="<?php echo isset($account->midlename)?$account->midlename:null ?>" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_MIDLENAME' ); ?>"/>
				</div>
			</div>
		<?php } ?>

		<?php if ($config->get('rs_lastname', 1)){?>
			<div class="control-group">
				<label class="control-label" for="lastname"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_LASTNAME' ); ?>
				</label>
				<div class="controls">
					<input class="inputbox required" type="text" name="lastname" required
					id="lastname" size="30" maxlength="50"
					value="<?php echo isset($account->lastname)?$account->lastname:null ?>" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_LASTNAME' ); ?>"/>
				</div>
			</div>
		<?php } ?>
		<?php if ($config->get('rs_address', 1)){?>
			
			<div class="control-group">
				<label class="control-label" for="address"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_ADDRESS' ); ?>
				</label>
				<div class="controls">
					<input class="inputbox required" type="text" name="address"
					id="address" size="30" maxlength="50"
					value="<?php echo isset($account->address)?$account->address:null ?>" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_ADDRESS' ); ?>"/>
				</div>
			</div>
		
		
		<?php } ?>
		<?php if ($config->get('rs_city', 1)) { ?>
			<div class="control-group">
				<label class="control-label" for="city"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_CITY' ); ?>
				</label>
				<div class="controls">
					<input class="inputbox required" type="text" name="city"
					id="city" size="30" maxlength="50"
					value="<?php echo isset($account->city)?$account->city:null ?>"
					placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_CITY' ); ?>"/>
				</div>
			</div>
		

		<?php } ?>
		<?php if ($config->get('rs_states', 1)) {?>
			<div class="control-group">
				<label class="control-label" for="states"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_STATES' ); ?>
				</label>
				<div class="controls">
					<input class="inputbox required" type="text" name="states"
					id="states" size="30" maxlength="50"
					value="<?php echo isset($account->states)?$account->states:null ?>"
					placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_STATES' ); ?>"/>
				</div>
			</div>
		
			<?php } ?>
			
			<?php if ($config->get('rs_zip', 1)){ ?>
				<div class="control-group">
					<label class="control-label" for="zip"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_ZIP' ); ?>
					</label>
					<div class="controls">
						<input class="inputbox required" type="text" name="zip" id="zip"
						size="30" maxlength="50" value="<?php echo isset($account->zip)?$account->zip:null ?>" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_ZIP' ); ?>"/>
					</div>
				</div>
		
		
		<?php } ?>
		<?php if ($config->get('rs_country', 1)){ ?>
				<div class="control-group">
					<label class="control-label" for="country_id"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_COUNTRY' ); ?>
					</label>
					<div class="controls">
						<?php echo BookProHelper::getCountryList('country_id',isset($account->country_id)?$account->country_id:null,'placeholder="'.JText::_( 'COM_BOOKPRO_CUSTOMER_COUNTRY' ).'"' ,'')?>
					</div>
				</div>
		
		<?php } ?>
		
		<?php if ($config->get('rs_mobile', 1)) {  ?>
			<div class="control-group">
				<label class="control-label" for="mobile"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_MOBILE' ); ?>
				</label>
				<div class="controls">
					<input class="inputbox required" type="text" name="mobile" required
				id="mobile" size="30" maxlength="50"
				value="<?php echo isset($account->mobile)?$account->mobile:null ?>" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_MOBILE' ); ?>" />
				</div>
			</div>
		
		<?php } ?>
		
		<?php if ($config->get('rs_telephone', 1)) { ?>
			<div class="control-group">
				<label class="control-label" for="telephone"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_PHONE' ); ?>
				</label>
				<div class="controls">
					<input class="inputbox required" type="text" name="telephone"
				id="telephone" size="30" maxlength="50"
				value="<?php echo isset($account->telephone)?$account->telephone:null ?>" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_PHONE' ); ?>" />
				</div>
			</div>
		
		<?php } ?>
			<div class="control-group">
				<label class="control-label" for="email"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_EMAIL' ); ?>
				</label>
				<div class="controls">
					<input class="inputbox required" type="text" name="email" id="email" required
				size="30" maxlength="50"
				value="<?php echo isset($account->email)?$account->email:null ?>" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_EMAIL' ); ?>" />
				</div>
			</div>
			
			</fieldset>
			</div>
</div>