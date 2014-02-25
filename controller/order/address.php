<?php

class PostAddress extends control{


	public function checkPara(){
		
		$this->phone_no = $_POST['phone_no'];

		if($this->phone_no <= 10000 || !is_numeric($this->phone_no))
			return false;

		return true;

	}

	public function action(){

		if(isset($_COOKIE['booking']))
		{
			$postModel = new PostModel();
			$booking = explode(',',$_COOKIE['booking']);
			foreach($booking  as $itemId)
			{
				if(!is_numeric($itemId))
				{
					continue;
				}
				if(!isset($_POST["n_{$itemId}"]))
					continue;
				$item  = $postModel->getItem($itemId);  
				if($item)
				{
					$item['num'] =$_POST["n_{$itemId}"];
					$item['comment'] = $_POST["c_{$itemId}"];
					$orderItem[] = "{$itemId}||{$item['num']}||{$item['comment']}";
					$items[] = $itemId; 
					$datas['post'][] = $item;
				}
			}
			$this->items = implode(',',$items);
			
			$myOrderModel =new myOrderModel();
			$customer = $myOrderModel->getCustomerByPhone($this->phone_no);
			if(!$customer)
				$datas['customer'] = array();
			else
				$datas['customer'] = $customer;

		}


		$this->format($datas);

	}


	public function includeFiles()
	{

		include(MODEL_POST."/PostModel.php");
		include(MODEL_MYORDER."/MyOrderModel.php");
		include(VIEW.'/address.php');

	}
	
	public function format($datas)
	{
		$data['activeHome'] = 'class="active"';
		$data['activePhoto'] = '';
		$data['activeWeibo'] = '';
		$GLOBALS['DATA'] = $data;
		if($GLOBALS['UA_TYPE'] == 'phone')
		{
			ViewAddress::renderPhone($datas);
		}
		else
		{
			ViewAddress::render($datas);
		}
		
		
		
		//print_r($datas);
	}


}

?>
