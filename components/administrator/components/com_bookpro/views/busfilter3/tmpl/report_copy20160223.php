<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: default.php 81 2012-08-11 01:16:36Z quannv $
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );

function cmp($a, $b)
{
    return strcmp($a->name, $b->name);
};

AImporter::helper ( 'currency', 'bookpro', 'date' );
AImporter::model ( 'order' );
$itemsCount = count ( $this->items );
$date = $this->state->get ( 'filter.depart_date' );
$route_id = $this->state->get ( 'filter.route_id' );

$params = JComponentHelper::getParams ( 'com_bookpro' );
$input = JFactory::getApplication ()->input;
$company_name = $params->get ( 'company_name' );
$logo = $params->get ( 'company_logo' );
$address = $params->get ( 'company_address' );
if($route_id){
AImporter::model ( 'bustrip' );
$model = new BookProModelBusTrip ();
$this->route = $model->getComplexItem ( $route_id );
echo '<script type="text/javascript">window.onload = function() { window.print(); }</script>';
}else 
	
{
	echo "Must select route";
	return;
}

?>
<div style="width: 680px;margin:0;">
<table style="text-align: left;width:100%;margin:0;">
	<tr>
		<td style="border: none; width: 30%;">
		    <img src="<?php echo JUri::root().$logo; ?>" style="width: 300px;" >
			<h3 align="center">ООО "СКСавто"</h3>
			</td>
        <td style="border: none; width: 20%;"></td>
		<td style="border: none; width: 50%; text-align: left;"><strong><?php echo $this->route->title ?><br />
			<?php echo JText::sprintf('COM_BOOKPRO_PASSENGER_DEPART_DATE',JFactory::getDate($date)->format('d-m-Y')).' '?>
			<?php echo JHTML::date($this->route->start_time,"H:i",null )?><br />
			<?php echo JText::_('COM_BOOKPRO_BUSTRIP_CODE').':'.$this->route->code;?><br />
			<?php echo JText::_('COM_BOOKPRO_BUS').':'.$this->route->bus_name;?>
			</strong
			</td>
	</tr>

</table>

<hr style="margin:0;" />

<h3 align="center" style="margin: 0;"><?php echo JText::_('ПОСАДОЧНАЯ ВЕДОМОСТЬ') ?></h3>
<?php 
//var_dump($this->items);
$orderModel = new BookProModelOrder ();
$route_circle = explode (",",$this->route->route);
//var_dump ($route_circle);
//echo $this->route->route;
    $full_count = 0;
	$full_total = 0;
foreach ($route_circle as $route_item){  
    $circle_count=0;
    $sum_count = 0;
	$sum_total = 0;
	//var_dump($route_item);
    for($i = 0; $i < $itemsCount; $i ++) {
		$subject = &$this->items [$i];
		//$temp_bustrip = $model->getComplexItem ( $subject->oparams["chargeInfo"]["onward"]["id"] );
		//var_dump ($subject->oparams["chargeInfo"]);
		//var_dump ($subject);
		            $order = $orderModel->getComplexItem ( $subject->order_id);
            for($jj = 0; $jj < count($order->bustrips); $jj++) {
			    if ($order->bustrips[$jj]->code==$subject->tripcode){
			        $bustripfrom=$order->bustrips[$jj]->from_name;
			        //var_dump ($order);
			        $bustripto=$order->bustrips[$jj]->to_name;
			        $fromid = $order->bustrips[$jj]->from;
			    }
			}
		
		if ($route_item == $fromid){
		    //var_dump ($subject);
		   // echo ("---------------".$itemsCount);
		    $sum_count=$sum_count+1;
            $full_count=$full_count+1;
		    
		    //var_dump($temp_bustrip);

			if ($circle_count==0){
			    $array_dest = array();
			    $array_dest_title = array();
    		    $array_count = array();
    		    foreach ($route_circle as $route_item_temp){
    		        for($j = 0; $j < $itemsCount; $j ++) {
    		            $subject_temp = &$this->items [$j];
    		            //var_dump($subject_temp->oparams["chargeInfo"]["onward"]["id"]);
    		            //$bustrip_temp = $model->getComplexItem ( $subject_temp->oparams["chargeInfo"]["onward"]["id"] );
    		            $order3 = $orderModel->getComplexItem ( $subject_temp->order_id);
                        for($jj = 0; $jj < count($order3->bustrips); $jj++) {
            			    if ($order3->bustrips[$jj]->code==$subject_temp->tripcode){
            			        //$bustripfrom=$order->bustrips[$jj]->from_name;
            			        //var_dump ($order);
            			        //$bustripto=$order->bustrips[$jj]->to_name;
            			        $fromid2 = $order3->bustrips[$jj]->from;
            			        $toid2 = $order3->bustrips[$jj]->to;
            			        $toid2name = $order3->bustrips[$jj]->to_name;
            			    }
            			}
    		            if ($route_item_temp==$toid2 && $route_item == $fromid2){
    		                $key = array_search($route_item_temp, $array_dest);
    		                if ($key===false){
    		                    array_push($array_dest, $route_item_temp);
    		                    array_push($array_count, 1);
    		                    //$order_temp = $orderModel->getComplexItem ( $subject_temp->order_id);
    		                    //for($jj = 0; $jj < count($order_temp->bustrips); $jj++) {
                    			    //if ($order_temp->bustrips[$jj]->code==$subject_temp->tripcode){
                    			        //$bustripfrom=$order->bustrips[$jj]->from_name;
                    			        //$bustripto=$order->bustrips[$jj]->to_name;
                    			        array_push($array_dest_title, $toid2name);
                    			    //}
                    			//}
    		                }
    		                else {
    		                    $array_count[$key]=$array_count[$key]+1;
    		                }
    		            }
    		        }
    		    }
    		    //var_dump ($array_dest_title);
			    //var_dump ($array_count); 
			    ?>
			    <br />
			    <p style="font-size:12px;margin:0;">
			    <strong style="font-size:12px;"><?php
			    echo ($bustripfrom); ?></strong><br/>
			    <?php echo JText::_('Проезд до остановки'); ?>
			    </p>
			    <?php
    			
    			$circle_count=1; ?>
			    <table class="table table-bordered" cellpadding="0" border="1" style="width:300px;font-size:12px;margin: 0;">
    			    <tr>
    			        <td style="padding:2px;">
    			            Остановка
    			        </td>
    			        <td style="padding:2px;">
    			            Кол. пассажиров
    			        </td>
    			    </tr>

			    <?php
			    for($j = 0; $j < count($array_dest); $j ++) {
	        ?>
			        <tr>
			            <td style="padding:2px;">
    			            <?php  echo $array_dest_title[$j];?>
    			        </td>
    			        <td style="padding:2px;">
    			            <?php  echo $array_count[$j];?>
    			        </td>
			        </tr>
	        <?php
			    }
			    
			    
			    
    			 ?>
    			
    			</table>
    			
    			<table class="table table-bordered" cellpadding="5" border="1" style="font-size:12px;margin: 0;">
    			    <tr>
    			        <td style="padding:2px;">
    			            Место
    			        </td>
    			        <td style="padding:2px;">
    			            Остановка
    			        </td>
    			        <td style="padding:2px;">
    			            Тип
    			        </td>
    			        <td style="padding:2px;">
    			            Паспорт
    			        </td>
    			        <td style="padding:2px;">
    			            Фамилия
    			        </td>
    			        <td style="padding:2px;">
    			            Цена
    			        </td>
    			        <td style="padding:2px;">
    			            № билета
    			        </td> 
    			    </tr>
    			
    			<?php
    			//$temp_table_rows=array();
			}
			$temp_price = ($order->total/count(explode (",",$subject->aseat))) ;
    	            //var_dump($order->passengers[0]->return_route_id);
    	            if ($order->passengers[0]->return_route_id != "0"){
    	                $temp_price=$temp_price/2;
    	                $price_val= number_format($order->total/2,2);
    	            }
    	            else {
    	                $price_val= number_format($order->total,2);
    	            }
    	            $sum_total=$sum_total+$temp_price;$full_total=$full_total+$temp_price;
			$temp_table_rows[]=array ('seat' => $subject->aseat, 'to' => $bustripto, 'type' => $subject->group_title, 'passport' => $subject->passport, 'name' => ($subject->lastname).' '.($subject->firstname).' '.$subject->midlename ,'price' => $price_val, 'order_number' => $subject->order_number );
			
			?>

			<?php
		}
    }
    //var_dump ($temp_table_rows);
    if ($temp_table_rows!=null){
        $seats_temp=null;
        foreach ($temp_table_rows as $key => $row) {
            $seats_temp[$key]  = $row['seat'];
        }
        array_multisort($seats_temp, SORT_ASC,  $temp_table_rows);
        //array_multisort($temp_table_rows[0], SORT_ASC, SORT_STRING);
        foreach ($temp_table_rows as $temp_table_rows_item){
        ?>
        			<tr>
    	        <td style="padding:2px;">
    	            <?php  echo $temp_table_rows_item["seat"] ?>
    	        </td>
    	        <td style="padding:2px;">
    	            <?php echo $temp_table_rows_item["to"];?>
    	        </td>
    	        <td style="padding:2px;">
    	            <?php echo $temp_table_rows_item["type"];?>
    	        </td>
    	        <td style="padding:2px;">
    	            <?php echo $temp_table_rows_item["passport"]; ?>
    	        </td>
    	        <td style="padding:2px;">
    	            <?php echo $temp_table_rows_item["name"]; ?>
    	        </td>
    	        <td style="padding:2px;">
    	            <?php echo $temp_table_rows_item["price"]; ?>
    	        </td>
    	        <td style="padding:2px;">
    	            <?php echo $temp_table_rows_item["order_number"]; ?>
    	        </td>
			</tr>
	<?php
        }
    }
    $temp_table_rows=null;
    if($circle_count==1) { ?>
    </table>
    <strong style="font-size:12px;"> Итого пассажиров: <?php echo $sum_count; ?>. Сумма: <?php echo $sum_total; ?> рублей</strong> <br />
    <?php }
    //echo $this->route->from_name;
}

//var_dump($this); 

?>

<h4><strong> Общее количество пассижиров: <?php echo $full_count; ?>. Общая сумма: <?php echo $full_total; ?> рублей </strong></h4>


</div>
