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

AImporter::model('bustrip','orderinfos','passengers');
AImporter::helper('bus','currency');
AImporter::css('bus');

$bustrips = BusHelper::getInFosList($this->order->id);

$passModel=new BookProModelPassengers();
$state = $passModel->getState();
$state->set('order_id',$this->order->id);


$this->passengers=$passModel->getItems();
$totalpax=count($this->passengers);
$config=AFactory::getConfig();

?>
 <h2 class="block_head"> <span><?php echo JText::_('COM_BOOKPRO_BUSTRIP_INFO')?> </span> </h2>
    <table class="bus-list">
      <thead>
        <tr>
          <th><?php echo JText::_('COM_BOOKPRO_BUSTRIP_ROUTE')?></th>
          <th><?php echo JText::_('COM_BOOKPRO_BUSTRIP_DATE_TIME')?></th>
          <th><?php echo JText::_('COM_BOOKPRO_BUSTRIP_PRICE')?></th>
        </tr>
      </thead>
      <tbody>
        <?php 
                if(count($bustrips)>0){
                    foreach ($bustrips as $bustrip) {
						
                        $stations=$bustrip->stations;
                       
                        $last=end($stations);
                        
            ?>
        <tr>
          <td valign="top"><div id="journey"> <span class="depart"> <?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_DEPART_FROM',$bustrip->from_name) ?> </span> 
          <span class="arrival"><?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_ARRIVAL_TO',$bustrip->to_name) ?> </span> <span><?php echo $bustrip->brandname ?></span> </div></td>
          <td>
          <div id="journey_sum"> 
          	<?php $layout = new JLayoutFile('station', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts'); 
					$html = $layout->render($bustrips);
					echo $html;
					?>
           </div>
          
          </td>
          <td><span class="seat"><?php echo JText::sprintf('COM_BOOKPRO_BUSTRIP_SEAT_TEXT',$totalpax) ?></span> 
          <span class="price"><?php 
          $layout = new JLayoutFile('price', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts');
          $html = $layout->render($bustrip->price);
          echo $html;
          ?></span></td>
        </tr>
        <?php } 
		}
			else{
            ?>
        <tr>
          <td colspan="3"><?php echo JText::_('COM_BOOKPRO_NO_RECORD')?></td>
        </tr>
        <?php 
                }
           ?>
     
      </tbody>
    </table>