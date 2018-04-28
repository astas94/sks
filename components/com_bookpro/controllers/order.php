<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 27 2012-07-08 17:15:11Z quannv $
 **/
defined ( '_JEXEC' ) or die ( 'Restricted access' );
class BookProControllerOrder extends JControllerLegacy {
	
	public function display($cachable = false, $urlparams = false) {
		
	}
	function cancelorder() {
		$order_id = JRequest::getVar ( 'order_id' );
		if (! class_exists ( 'BookProModelOrder' )) {
			AImporter::model ( 'orders' );
		}
		
		AImporter::helper ( 'bus', 'email', 'paystatus', 'refund' );
		$model = new BookProModelOrder ();
		$order = $model->getItem ( $order_id );
		
		$orderinfos = BusHelper::getInFosList ( $order->id );
		$orderinfo = $orderinfos [0];
		$cancel_amount = RefundHelper::refundPrice ( $orderinfo, $order );
		$order->refund_amount = $cancel_amount;
		
		PayStatus::init ();
		$order->order_status = 'CANCELLED';
		$table = JTable::getInstance ( 'Orders', 'Table' );
		
		$table->id = $order->id;
		$table->refund_amount = $cancel_amount;
		$table->order_status = "CANCELLED";
		// $table->pay_status = PayStatus::$REFUND->getValue();
		if (! $table->store ()) {
			JError::raiseError ( 500, $table->getError () );
		}
		$mail = new EmailHelper ();
		$mail->cancelOrder ( $order->id );
		$msg = JText::_ ( 'COM_BOOKPRO_CANCEL_CUSTOMER_MSG' );
		$this->setRedirect ( JURI::root () . 'index.php?option=com_bookpro&view=ticket&layout=ticket&order_number=' . $order->order_number, $msg, 'info' );
		return;
	}
	function print_ticket(){
		
		AImporter::model('passengers','order');
		AImporter::helper('passenger');
		//$cid = JFactory::getApplication()->input->get('cid', array(), 'array');
		$order_id = JFactory::getApplication()->input->get('order_id');
		
		$model = new BookProModelOrder ();
		$order = $model->getComplexItem ( $order_id );
		$cid=JArrayHelper::getColumn($order->passengers, 'id');
		$route_id=array($order->passengers[0]->route_id);
		//$route_id=array($order->passengers[0]->return_route_id);
		//echo ('asdasd'.count($route_id));
		if($order->passengers[0]->return_route_id){
			$route_id[]=$order->passengers[0]->return_route_id;
		}
				//echo ('asdasd'.count($route_id));
		//JArrayHelper::toInteger($cid);
		$model=new BookproModelpassengers();
		$result=array();
		foreach ($route_id as $id){
			$passengers=$model->getItemsByIds($cid,$id);
			//var_dump ($passengers);
			//$passengers["onward"]=false;
			$result=array_merge($result,$passengers);
			//echo ('asdasd111='.$cid);
		}
		//echo ('asdasd222='.count($result));
		//var_dump ($result);
if ($order->order_status == 'CONFIRMED'){
		//$view=$this->getView('ticket','html','BookProView');
		//$view->passengers=PassengertHelper::formatPassenger($result);
		//$view->display();
$layout = new JLayoutFile('invoice', $basePath = JPATH_ROOT .'/components/com_bookpro/layouts/bus');
		$html = $layout->render($order);
		echo $html;
}
		
	}
	function cancel() {
		$order_id = JRequest::getVar ( 'order_id' );
		if (! class_exists ( 'BookProModelOrder' )) {
			AImporter::model ( 'orders' );
		}
		$model = new BookProModelOrder ();
		$model->setId ( $order_id );
		$order = $model->getObject ();
		$order->order_status = 'CANCELLED';
		if (! $order->store ()) {
			JError::raiseError ( 500, $row->getError () );
		}
		$this->setRedirect ( JURI::root () . 'index.php?option=com_bookpro&view=mypage' );
		return;
	}
	function applycoupon() {
		$input = JFactory::getApplication ()->input;
		$code = $input->getString ( 'coupon' );
		$order_id = $input->getInt ( 'order_id' );
		
		AImporter::table ( 'orders', 'coupon' );
		$coupon = JTable::getInstance ( 'Coupon', 'table' );
		$coupon->load ( array (
				'code' => $code 
		) );
		
		$check = true;
		if ($coupon) {
			if (( int ) $coupon->total == 0) {
				$check = false;
				$msg = JText::_ ( 'COM_BOOKPRO_COUPON_INVALID' );
			} else {
				
				$order = JTable::getInstance ( 'Orders', 'table' );
				$order->load ( $order_id );
				
				if ($order->discount > 0) {
					$check = false;
					$msg = JText::_ ( 'COM_BOOKPRO_COUPON_APPLY_ERROR' );
				} else {
					
					if ($coupon->subtract_type == 1) {
					    $order->total=$order->subtotal;
						$discount = ($order->total * $coupon->amount) / 100;
						if(($order->total - $discount)>=1){
						    $order->total = $order->total - $discount;
						    $order->discount = $discount;
						}
						else {
						    $order->discount = $order->total - 1;
						    $order->total = 1;
						}
					} else {
					    $order->total=$order->subtotal;
					    if(( $order->total - $coupon->amount)>=1){
                            $order->total = $order->total - $coupon->amount;
						    $order->discount = $coupon->amount;	
						}
						else {
						    $order->discount = $order->total - 1;
						    $order->total = 1;
						}
					}
					$order->coupon_id = $coupon->id;
					$coupon->total = $coupon->total - 1;
					$coupon->store ();
					$order->store ();
					$msg = JText::_ ( 'COM_BOOKPRO_COUPON_VALID' );
				}
			}
		} else {
			$check = false;
			$msg = JText::_ ( 'COM_BOOKPRO_COUPON_INVALID' );
		}
		$this->setRedirect ( JURI::base () . 'index.php?option=com_bookpro&view=formpayment&order_id=' . $order_id . '&' . JSession::getFormToken () . '=1', $msg );
		return;
	}
	function changestatus() {
		$post = JRequest::get ( 'POST' );
		$oder_status = $post ['oder_status'];
		
		foreach ( $oder_status as $key => $value ) {
			$oder_m = new BookProModelOrder ();
			$oder_m->store ( array (
					'id' => $key,
					'order_status' => $value 
			) );
		}
		$url = 'index.php?option=com_bookpro&view=mypage';
		$this->setRedirect ( $url );
	}
	function detail() {
		$order_id = JRequest::getInt ( 'order_id' );
		$user = JFactory::getUser ();
		
		if ($user->get ( 'guest' ) == 1) {
			$return = 'index.php?option=com_bookpro&controller=order&task=viewdetail&order_id=' . $order_id;
			$url = 'index.php?option=com_users&view=login';
			$url .= '&return=' . urlencode ( base64_encode ( $return ) );
			$this->setRedirect ( $url, false );
			return;
		} else {
			
			if (! class_exists ( 'BookProModelOrder' )) {
				AImporter::model ( 'order' );
			}
			$model = new BookProModelOrder ();
			
			$order = $model->getItem ( $order_id );
			$view = $this->getView ( 'orderdetail', 'html', 'BookProView' );
			$view->assign ( 'order', $order );
			$view->display ();
			return;
		}
	}
}