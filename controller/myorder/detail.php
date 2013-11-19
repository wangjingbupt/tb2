<?php

class MyOrderDetail extends control{


	public function checkPara(){
		
		$this->id = trim($GLOBALS['URL_PATH'][2]);

		return true;

	}

	public function action(){
		$postModel = new MyOrderModel();
		$orderModel = new orderModel();

		$order = $postModel->getMyOrder($this->id);
		if($order)
		{
			foreach($order['ddmOrder'] as $oid)
			{
				$ddmOrder = $orderModel->getDetail($oid);
				foreach($ddmOrder['items'] as $i_v)
				{
					$t = json_decode($i_v,true);
					$items[$t['id']] =$t ; 
				}
			}
			foreach($order['items'] as $id)
			{
				$order['itemsDetail'][] = $items[$id];
			}
		}

		switch($order['status'])
		{	
			case 1 :
				$order['status'] = '未发货';
				break;
			case 2 :
				$order['status'] = '已发货';
				break;
			case 3 :
				$order['status'] = '部分已发货';
				break;
		}

		$datas['order'] = $order;

		$this->format($datas);

	}


	public function includeFiles()
	{

		include(MODEL_ORDER."/OrderModel.php");
		include(VIEW.'/myOrderDetail.php');

	}
	
	public function format($datas)
	{
		$data['activeMyOrder'] = 'class="active"';
		
		$GLOBALS['DATA'] = $data;
		ViewDetail::render($datas);
		
	}

}

?>
