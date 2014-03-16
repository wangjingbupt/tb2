<?php

class MyOrderConfirmAddress extends control{


	public function checkPara(){


		$this->orderPhone = $_POST['phone']; 
		$this->orderItems = $_POST['items']; 
		$this->orderComments = $_POST['comments']; 
		$this->orderTbOrder = $_POST['tbOrder']; 

		if($this->orderPhone == '' || $this->orderItems == '' )
			return false;

		if($_POST['newAddress'] == 0)
		{
			$this->orderName = $_POST['name'];
			//$this->orderDate = $_POST['date']; 
			$this->orderAddress = $_POST['address']; 
			//$this->orderDdmOrder = $_POST['ddmOrder']; 
			//$this->orderTbname = $_POST['tbname']; 

			if($this->orderName =='' || $this->orderAddress == '' )
				return false;
		}

		return true;

	}

	public function action(){
		
		$postModel = new MyOrderModel();

		if($_POST['newAddress'] == 0)
		{
			$address = array(
					'name'=>$this->orderName,
					'phone'=>$this->orderPhone,
					'createtime'=> time(),
					'address'=>$this->orderAddress,
					);
			$address = $postModel->addAddress($address);

		}
		else
		{
			$address = $postModel->getCustomerByPhone($this->orderPhone);
			if(!$address)
				return false;
			$address = $address[$_POST['newAddress']-1];
			$this->orderName = $address['name'];
			$this->orderAddress = $address['address'];

		}


		if( $this->orderTbOrder != '')
		{
			preg_match('/bizOrderId=([0-9]+)/',$this->orderTbOrder,$m);
			if($m)
			{
				$tbOrder[] = $m[1];
			}
		}
		else
		{
			$tbOrder = array();
		}

		$items = explode(',',$this->orderItems);
		$items =array_filter($items);

		$doc = array(
				'name'=>$this->orderName,
				'phone'=>$this->orderPhone,
				'createtime'=> time(),
				'address'=>$this->orderAddress,
				'tbOrder'=>$tbOrder,
				'tbname'=>$this->orderTbname,

				);

		$data = $postModel->editPost($doc);


		$postModel = new ScmOrderModel();
		foreach($items  as $itemId)
		{   
			if(!isset($_POST["n_{$itemId}"]))
				continue;
			$item = array('id'=>$itemId);
			$item['num'] =$_POST["n_{$itemId}"];
			$item['comment'] = $_POST["c_{$itemId}"];
			$item['addtime'] = time();
			$item['myOrderId'] = $data['_id'];
			$r = $postModel->addOrder($item);
		}
		setCookie('booking','',time()+3600*24,'/');


		if($data)
		{
			$uri ="/myorder";
			header("Location: $uri");

		}
		else
		{

			include(VIEW.'/myOrderEdit.php');
			$datas['order'] = $doc;
			$data['activeMyOrder'] = 'class="active"';
			$GLOBALS['DATA'] = $data;
			ViewMyOrderEdit::render($datas);

		}

	}


	public function includeFiles()
	{

		include(MODEL_SCMORDER."/ScmOrderModel.php");

	}

}

?>
