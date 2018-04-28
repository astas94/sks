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
$config = JComponentHelper::getParams('com_bookpro');
AImporter::helper('bus');
$passengers = BusHelper::getPassengerForm($displayData['adult'],$displayData['child'],$displayData['senior']);

?>

<h2 class="block_head">
	<span><?php echo JText::_('COM_BOOKPRO_PASSENGER_INFO')?> </span>

</h2>
<div class="form-horizontal">
				
				<?php 
				$i = 0;
					foreach ($passengers as $passenger){
					   // echo ("test1111");
					//assign logged account to first passenger information
					if($i==0){
						
						$user = JFactory::getUser();
						if (!$user->guest) {
						    $account=JBFactory::getAccount();
						}
						//var_dump ($user);
						if($account && $account->isNormal && (!$user->guest)){
						  $firstname=$account->firstname;
						  $midlename=$account->midlename;
						  $lastname=$account->lastname;
						  //var_dump ($account);
						}

					}
    
    			  ?>
				<div class="accordion" id="accordion2">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#passenger<?php echo $i; ?>">
								<?php echo $passenger->title ?>
							</a>
						</div>
						<div class="accordion-body collapse in" id="passenger<?php echo $i; ?>">
							<div class="accordion-inner">
								 <?php if ($config->get('ps_gender')){?>
							<div class="control-group">
									<label class="control-label"> <?php echo JText::_('COM_BOOKPRO_PASSENGER_GENDER')?>
									</label>
									<div class="controls">
										
										<?php 
										
					    			  echo JHtml::_('select.genericlist',BookProHelper::getGender(), $passenger->fieldname.'[gender]','class="inputbox input-small"','value','text',1); ?>
									</div>
									</div>
									<?php }?>
							 
									<div class="control-group">
										<label class="control-label"> <?php echo JText::_('COM_BOOKPRO_PASSENGER_FIRSTNAME')?>
										</label>
										<div class="controls">
											<input type="text" name="<?php echo $passenger->fieldname.'[firstname]' ?>" required
												class="input-medium" value="<?php if (($i==0) & isset($firstname)) echo $firstname ?>" />
										</div>
									</div>


<?php if ($config->get('ps_midlename')){?>
									<div class="control-group">
										<label class="control-label"> <?php echo JText::_('COM_BOOKPRO_PASSENGER_MIDLENAME')?>
										</label>
										<div class="controls">
											<input type="text" name="<?php echo $passenger->fieldname.'[midlename]' ?>" required
												class="input-medium" value="<?php if (($i==0) & isset($midlename)) echo $midlename ?>"   />
										</div>
									</div>
									<?php }?>							 


									<?php if ($config->get('ps_lastname')){?>
									<div class="control-group">
										<label class="control-label"> <?php echo JText::_('COM_BOOKPRO_PASSENGER_LASTNAME')?>
										</label>
										<div class="controls">
											<input type="text" name="<?php echo $passenger->fieldname.'[lastname]' ?>" required
												class="input-medium" value="<?php if (($i==0) & isset($lastname)) echo $lastname ?>"   />
										</div>
									</div>
									<?php }?>
									 <?php if ($config->get('ps_birthday')){?>	
									<div class="control-group">
										<label class="control-label"> <?php echo JText::_('COM_BOOKPRO_PASSENGER_BIRTHDAY')?>
										</label>
										<div class="controls">
											<div class="date birthday">
 					  							<input type="text" class="input-small" name="<?php echo $passenger->fieldname.'[birthday]' ?>" id="<?php echo 'birthday'.$i ?>"><span class="btn add-on"><i class="icon-calendar"></i></span>
											
											</div>
										</div>
									</div>
									<?php } ?>
									 
									
									 <?php if ($config->get('ps_passport')){?>
									<div class="control-group">
										<label class="control-label"> <?php echo JText::_('COM_BOOKPRO_PASSENGER_PASSPORT')?>
										</label>
										<div class="controls">
											<input type="text" name="<?php echo $passenger->fieldname.'[passport]' ?>" required class="input-medium" placeholder="0000000000" />
										</div>
									</div>
									<?php } ?>
									<?php if ($config->get('ps_ppvalid')){?>
						
									<div class="control-group">
										<label class="control-label"> <?php echo JText::_('COM_BOOKPRO_PASSENGER_PASSPORT_EXPIRED')?>
										</label>
										<div class="controls">
										
										<div class="input-append date expired">
 					  							<input type="text" class="input-small" name="<?php echo $passenger->fieldname.'[passportValid]' ?>" id="<?php echo 'passportValid'.$i ?>"><span class="add-on"><i class="icon-th"></i></span>
											
											</div>
											
										</div>
									</div>
									<?php } ?>
									<?php if ($config->get('ps_country')){?>
									<div class="control-group">
										<label class="control-label"> <?php echo JText::_('COM_BOOKPRO_PASSENGER_COUNTRY')?>
										</label>
										<div class="controls">
											<?php echo BookProHelper::getCountryList($passenger->fieldname.'[country_id]', 0,'')?>
											<input id="age" type="hidden" name="age[]" value="1">
										</div>
									</div>
									<?php } ?>
									
									
									
									<?php if ($config->get('ps_notes')){?>
									<div class="control-group">
										<label class="control-label"> <?php echo JText::_('COM_BOOKPRO_PASSENGER_NOTES')?>
										</label>
										<div class="controls">
											<textarea rows="2" cols="" name="<?php echo $passenger->fieldname.'[notes]' ?>"></textarea>
										</div>
									</div>
									<?php } ?>
									
									<input type="hidden" name="<?php echo $passenger->fieldname.'[group_id]' ?>" value="<?php echo $passenger->group_id ?>"/>
									
									
							</div>
						</div>
					</div>
						
				
					
				</div>
				
				<?php 
				$i++;
					} ?>
		

	</div>

