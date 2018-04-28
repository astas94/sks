<?php 
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 80 2012-08-10 09:25:35Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JToolBarHelper::save('roomrate.savedayrate');
JToolBarHelper::title('Edit rate');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		var checked = true;
		var input 	= null; 
			jQuery('#formvalidate input').each(function(){
				if(!jQuery(this).val()){
						jQuery(this).focus();
						input = jQuery(this).attr('placeholder');
						checked = false; 
						return false; 		
					}
				});
		if(checked){
			Joomla.submitform(task, document.getElementById('adminForm'));
			}else{
				alert(input+' is required');
			}
	}
</script>

<h2><?php echo $this->bustrip->title ?>&nbsp-&nbsp<?php echo $this->bustrip->code ?></h2>
<strong>
<?php echo JFactory::getDate($this->rate->date)->format('d-m-Y') ?>(<?php echo $this->bustrip->start_time ?> - <?php echo $this->bustrip->end_time ?>)
</strong>

<form action="index.php" method="post" name="adminForm" id='adminForm'	class="form-validate">
	
	<fieldset>
	<input type="hidden" name="jform[id]" value="<?php echo $this->rate->id ?>" />
	<table style="width:300px" id="formvalidate">
				<tr>
				  <td></td>
				  <td><?php echo JText::_('COM_BOOKPRO_ONEWAY'); ?></td>		
				  <td><?php echo JText::_('COM_BOOKPRO_ROUNDTRIP'); ?></td>
				</tr>
				<tr>
				  <td><?php echo JText::_('COM_BOOKPRO_ADULT'); ?></td>
				  <td><input class="input-small required" type="text" placeholder="<?php echo JText::_('COM_BOOKPRO_ADULT'); ?> " 
				  name="jform[adult]" value="<?php echo $this->rate->adult?>" /></td>		
				  <td><input class="input-small required" placeholder="<?php echo JText::_('COM_BOOKPRO_ADULT_ROUNDTRIP'); ?>" type="text"
			name="jform[adult_roundtrip]" value="<?php echo $this->rate->adult_roundtrip?>" /></td>
				</tr>
				<tr>
				  <td><?php echo JText::_('COM_BOOKPRO_CHILD'); ?></td>
				  <td><input class="input-small required" type="text" name="jform[child]" placeholder="<?php echo JText::_('COM_BOOKPRO_CHILD'); ?>" value="<?php echo $this->rate->child ?>" /></td>		
				  <td><input class="input-small required" type="text" placeholder="<?php echo JText::_('COM_BOOKPRO_CHILD_ROUNDTRIP'); ?>"
				name="jform[child_roundtrip]" value="<?php echo $this->rate->child_roundtrip ?>" /></td>
				</tr>
				<tr>
				  <td><?php echo JText::_('COM_BOOKPRO_INFANT') ?></td>
				  <td><input class="input-small required" type="text" name="jform[infant]" placeholder="<?php echo JText::_('COM_BOOKPRO_INFANT') ?>"
				id="infant" value="<?php echo $this->rate->infant ?>" /></td>		
				  <td><input class="input-small required" type="text" placeholder="<?php echo JText::_('COM_BOOKPRO_INFANT_ROUNDTRIP'); ?>"
				name="jform[infant_roundtrip]" 	value="<?php echo $this->rate->infant_roundtrip ?>" /></td>
				</tr>
			</table>
	
</fieldset>	

<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_bookpro" />
<?php echo JHtml::_('form.token'); ?>
</form>