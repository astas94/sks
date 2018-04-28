<?php
/**
 * @package     Bookpro
 * @author         Ngo Van Quan
 * @link         http://joombooking.com
 * @copyright     Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version     $Id: default.php 84 2012-08-17 07:16:08Z quannv $
 **/

defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.html.html.select' );
JHtml::_('jquery.framework');
$doc = JFactory::getDocument();
$doc->addScript('components/com_bookpro/assets/js/bootstrap-tooltip.js');
$doc->addScript('components/com_bookpro/assets/js/bootstrap-popover.js');
$doc->addScript('components/com_bookpro/assets/js/jquery-create-seat.js');
//$doc->addScript('components/com_bookpro/assets/js/jquery.ui-contextmenu.js');

$doc->addScript('components/com_bookpro/assets/js/view-seattemplate.js');
$doc->addStyleSheet('components/com_bookpro/assets/css/jquery-create-seat.css');
$doc->addStyleSheet('components/com_bookpro/assets/css/view-seattemplate.css');


$block_layout=json_decode($this->item->block_layout);
//var_dump($block_layout);
if ($block_layout){
	$row=$block_layout->row ?$block_layout->row:6;
	
	$column=$block_layout->column?$block_layout->column:10;
}else{
	$row = 6;
	$column = 10;
}
//echo ($row.'----------------------'.$column)

if (isset($_GET["bustrip"]))
	        {
	            $int=(int)$_GET["bustrip"];
	            $this->bustripopt= $int;
	        }
	        else {
	             $this->bustripopt=0;
	        }
	             //var_dump ($this);

?>

  <form action="<?php echo JRoute::_('index.php?option=com_bookpro&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">
       <div class="form-inline">
           <label for="title"><?php echo JText::_('COM_BOOKPRO_TITLE'); ?>: </label>
             <input type="text" name="jform[title]" value="<?php echo $this->item->title  ?>">
              
               <label for="row"><?php echo JText::_('COM_BOOKPRO_SELECT_ROW'); ?>: </label>
              <input type="text" id="block_layout_row" name="block_layout[row]" value="<?php echo $row ?>" class="input-small"> 
               <label for="column"><?php echo JText::_('COM_BOOKPRO_SELECT_COLUMN'); ?>: </label>
             <input type="text" id="block_layout_column" name="block_layout[column]" value="<?php echo $column ?>" class="input-small"> 
              <input type="button" id="change" name="change" value="Изменить" class="btn"> 
           
          </div>
       <br/>
       <br/>
       <div id="note">
       <div class="control">
       <div class="control">
       	<?php echo JText::_('COM_BOOKPRO_SEAT_NOTE').':';?>
       	</div>
       	<?php echo JText::_('COM_BOOKPRO_SEAT_TYPE').': '.JText::_('COM_BOOKPRO_NOTE_SEAT_TYPE'); ?>
       	</div>
       	<div class="control">
       	<?php echo JText::_('COM_BOOKPRO_SEAT_NUMBER').': '.JText::_('COM_BOOKPRO_NOTE_SEAT_NUMBER'); ?>
       	</div>
       </div>
      <div id="create-seat">
        <?php for($i=0;$i<$row*$column;$i++): ?>
        <div data-original-title="<?php echo $i+1 ?>" class="item">
          <table class="admintable">
            <tr>
              <td class="key"><label for="alias"><?php echo JText::_('COM_BOOKPRO_SEAT_TYPE'); ?>: </label></td>
              <td><?php
              
              if (isset($block_layout->block_type[$i])){
              	$block_type = $block_layout->block_type[$i];
              }else{
              	$block_type = 'seat';
              }
              
              echo BookProHelper::getBlockObjectTypes('block_layout[block_type][]',$block_type,'class="input-small"') ?>
              </td>
            </tr>
            <tr>
              <td class="key"><label for="seat"><?php echo JText::_('COM_BOOKPRO_SEAT_NUMBER'); ?>: </label></td>
              <td>
              <?php 
              	if (isset($block_layout->seatnumber[$i])){
              		$seatnumber = $block_layout->seatnumber[$i];
              	}else{
              		$seatnumber = '';
              	}
              ?>
              <input name="block_layout[seatnumber][]" value="<?php echo $seatnumber ?>" type="text" style="width:50px;"></td>
            </tr>
          </table>
        </div>
        <?php endfor; ?>
      </div>
   
    <div style="display: none;" id="popover_content_wrapper">
      <div class="save">
        <input type="button" value="Save"/>
      </div>
    </div>
    <div class="clr"></div>
   
    
    <input id="task" type="hidden"
        name="task" value="save" />
    <input type="hidden" name="boxchecked"
        value="1" />
    <input type="hidden" name="bustripopt"
        value="<?php echo ($this->bustripopt); ?>" />
   
    <?php echo JHTML::_('form.token'); ?>
  </form>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
    $("#create-seat").css({
        width:($('#create-seat .item').width()+8)*<?php echo $column ?>
        
        
    });
    
});
</script> 
