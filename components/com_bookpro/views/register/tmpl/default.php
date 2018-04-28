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
    AImporter::css('customer');
    JHtml::_('jquery.framework'); 
    JHtml::_('behavior.framework');
    //AImporter::js('master');
     
    JHtml::_('behavior.modal','a.modal_term');
    ob_start();
    AImporter::helper('bookpro');
	BookProHelper::addJqueryValidate();
	
?>
		
<script type="text/javascript">
	jQuery(document).ready(function($){
		$("#registerform").validate({
		    lang: '<?php echo $local ?>',
			rules: {
				firstname: "required",
				lastname: "required",
				username: {
					required: true,
					minlength: 2
				},
				password: {
					required: true,
					minlength: 5
				},
				password2: {
					required: true,
					minlength: 5,
					equalTo: "#password"
				},
				email: {
					required: true,
					email: true
				},
				
				accept_term: {
					required: true
				}
			}
		});

		
	});
</script>	

<?php
    $js=ob_get_contents();

    ob_end_clean(); // get the callback function
    $find = array('<script type="text/javascript">',"</script>"); 
    $js=str_ireplace($find,'',$js);
    $this->document->addScriptDeclaration($js);
    $input=JFactory::getApplication()->input;
    $group_id = $input->get('group_id');

?>
<div class="row-fluid">
    <div class="span6">
        <form class="form-validate" action="index.php" method="post" id="registerform" name="registerform">
            <fieldset>
                <legend>                     
                    <span><?php  echo JText::_('COM_BOOKPRO_CUSTOMER_REGISTER');
                        ?> 
                    </span>
                </legend>
                <p>
                    <?php echo JText::_('COM_BOOKPRO_REGISTER_NOTES')?>
                </p> 

                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="username"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_USERNAME' ); ?>
                        </label>
                        <div class="controls">
                            <input onkeyup="checkUsername()" class="inputbox" type="text" name="username" autocomplete="off" id="username" size="20" maxlength="50" value="" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_USERNAME' ); ?>" />
                            <span id="statusUSR"></span>                   
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="password"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_PASSWORD' ); ?>
                        </label>
                        <div class="controls">
                            <input class="inputbox" type="password" name="password" id="password" size="20" maxlength="50" value="" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_PASSWORD' ); ?>"  /> 
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="password2"><?php echo JText::_('COM_BOOKPRO_CUSTOMER_CONFIRM_PASSWORD' ); ?>
                        </label>
                        <div class="controls">
                            <input class="inputbox" type="password" name="password2" id="password2" size="30" maxlength="50" value="" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_CONFIRM_PASSWORD'); ?>" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="email"><?php echo JText::_('COM_BOOKPRO_CUSTOMER_EMAIL' ); ?>
                        </label>
                        <div class="controls">
                            <input onkeyup="checkEmail()" class="inputbox" type="email" name="email" id="email" size="30" maxlength="30" autocomplete="off" value="<?php echo isset($this->customer->email)?$this->customer->email:null;?>"  placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_EMAIL' ); ?>"/>
                            <span id="statusEMAIL"></span>
                        </div>
                    </div>
		
                    <?php if($config->get('rs_gender', 1)) {?>
                            <div class="control-group">
                                <label class="control-label" for="gender"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_GENDER' ); ?>
                                </label>
                                <div class="controls">
                                	<?php echo JHtml::_('select.genericlist',BookProHelper::getGender(), 'gender','class="input-small gender" placeholder="'.JText::_( 'COM_BOOKPRO_CUSTOMER_GENDER' ).'"','value','text',isset($this->customer->gender)?$this->customer->gender:'') ?>
                                </div>
                                <?php // echo JHtmlSelect::booleanlist('gender','class="radio inline" placeholder="'.JText::_( 'COM_BOOKPRO_CUSTOMER_GENDER' ).'"',isset($this->customer->gender)?$this->customer->gender:'',JText::_('COM_BOOKPRO_MALE'),JText::_('COM_BOOKPRO_FEMALE'))?>
                            </div>	
                        <?php  } ?>
                        
                    <div class="control-group">
                        <label class="control-label" for="firstname"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_FIRSTNAME' ); ?>
                        </label>
                        <div class="controls">
                            <input class="inputbox" type="text" id="firstname" name="firstname" id="firstname" size="30" maxlength="50" value="<?php echo isset($this->customer->firstname)?$this->customer->firstname:null;?>" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_FIRSTNAME' ); ?>" />
                        </div>
                    </div>

<?php if($config->get('rs_midlename', 1)) {?>
                        <div class="control-group">
                            <label class="control-label" for="midlename"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_MIDLENAME' ); ?>
                            </label>
                            <div class="controls">
                                <input class="inputbox" type="text" name="midlename" id="midlename" size="30" maxlength="50" value="<?php echo isset($this->customer->midlename)?$this->customer->midlename:null;?>" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_MIDLENAME' ); ?>" />


                    <?php if($config->get('rs_lastname', 1)) {?>
                        <div class="control-group">
                            <label class="control-label" for="lastname"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_LASTNAME' ); ?>
                            </label>
                            <div class="controls">
                                <input class="inputbox" type="text" name="lastname" id="lastname" size="30" maxlength="50" value="<?php echo isset($this->customer->lastname)?$this->customer->lastname:null;?>" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_LASTNAME' ); ?>" />
                            </div>
                        </div>	
                        <?php } ?>

                    <?php if($config->get('rs_address', 1)) {?>
                        <div class="control-group">
                            <label class="control-label" for="address"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_ADDRESS' ); ?>
                            </label>

                            <div class="controls">
                                <input class="inputbox" type="text" name="address" id="address" size="30" maxlength="50" value="<?php echo isset($this->customer->address)?$this->customer->address:null;?>"  placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_ADDRESS' ); ?>" />
                            </div>
                        </div>	
                        <?php } ?>
                        
					<?php if ($config->get('rs_mobile', 1)) {  ?>
						<div class="control-group">
							<label class="control-label" for="mobile"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_MOBILE' ); ?>
							</label>
							<div class="controls">
								<input class="inputbox" type="text" name="mobile" id="mobile" size="30" maxlength="50" value="<?php echo isset($this->customer->mobile)?$this->customer->mobile:null; ?>" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_MOBILE' ); ?>" />
							</div>
						</div>
					<?php } ?>      
                        
                    <?php if($config->get('rs_telephone', 1)) {?>

                        <div class="control-group">
                            <label class="control-label" for="telephone"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_PHONE' ); ?>
                            </label>
                            <div class="controls">
                                <input class="inputbox" type="text" name="telephone" id="telephone" size="30" maxlength="50" value="<?php echo isset($this->customer->telephone)?$this->customer->telephone:null;?>" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_PHONE' ); ?>" />
                            </div>
                        </div>	
                    <?php } ?>	
                    
                    
                    <?php if($config->get('rs_city', 1)) {?>
                        <div class="control-group">
                            <label class="control-label" for="city"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_CITY' ); ?>
                            </label>
                            <div class="controls">
                                <input class="inputbox" type="text" name="city" id="city" size="30" maxlength="50" value="<?php echo isset($this->customer->city)?$this->customer->city:null;?>" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_CITY' ); ?>" />
                            </div>
                        </div>	

                        <?php } ?>
                    <?php if($config->get('rs_states', 1)) {?>
                        <div class="control-group">
                            <label class="control-label" for="states"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_STATES' ); ?>
                            </label>

                            <div class="controls">
                                <input class="inputbox" type="text" name="states" id="states" size="30" maxlength="50" value="<?php echo isset($this->customer->states)?$this->customer->states:null;?>"  placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_STATES' ); ?>" />
                            </div>
                        </div>	
                        <?php } ?>	
                    <?php if($config->get('rs_zip', 1)) {?>
                        <div class="control-group">
                            <label class="control-label" for="zip"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_ZIP' ); ?>
                            </label>

                            <div class="controls">
                                <input class="inputbox" type="text" name="zip" id="zip" size="30" maxlength="50" value="<?php echo isset($this->customer->zip)?$this->customer->zip:null;?>" placeholder="<?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_ZIP' ); ?>" />
                            </div>
                        </div>
                        <?php } ?>
                    <?php if($config->get('rs_country', 1)) {?>
                        <div class="control-group">
                            <label class="control-label" for="country_id"><?php echo JText::_( 'COM_BOOKPRO_CUSTOMER_COUNTRY' ); ?>
                            </label>

                            <div class="controls">
                                <?php echo BookProHelper::getCountryList('country_id',isset($this->customer->country_id)?$this->customer->country_id:null,'','class="required validate-select"',$group_id); ?>
                            </div>
                        </div>	
                        <?php } ?>


                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" value="30" name="accept_term" checked="checked" id='accept_term' class="accept_term"> 
                                <a  href="index.php?option=com_content&id=<?php echo $config->get('privacy_content_id')?>&view=article&tmpl=component&task=preview" class='modal_term' rel="{handler: 'iframe', size: {x: 680, y: 370}}"><b><?php echo JText::_("COM_BOOKPRO_ACCEPT_PRIVACY_TERM")?>
                                </b> </a>
                            </label>
                            <input type="submit" name="submit" class="btn btn-primary" id="submit" value="<?php echo JText::_('COM_BOOKPRO_SUBMIT');?>" />
                        </div>
                    </div>
                </div>
                <input type="hidden" name="state" value="1"/>
                <input type="hidden" name="option" value="com_bookpro" /> 
                <input type="hidden" name="controller" value="customer" />
                <input type="hidden" name="task" value="register" /> 
                <input type="hidden" name="group_id" value="<?php echo $config->get('customer_usergroup', 2); ?>" />                        
                <input type="hidden" name="return" value="<?php echo $input->get('return')?>" /> 
                <input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid');?>" id="Itemid"/> 
                <?php echo JHtml::_( 'form.token' ); ?>
            </fieldset>
        </form>         
    </div>              
   
</div>



