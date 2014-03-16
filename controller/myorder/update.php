<?php

class MyOrderUpdate extends control{


	public function checkPara(){

		$this->orderId = $_POST['id'];
		$this->orderName = $_POST['name'];
		$this->orderPhone = $_POST['phone']; 
		$this->orderDate = $_POST['date']; 
		$this->orderAddress = $_POST['address']; 
		$this->orderItems = $_POST['items']; 
		$this->orderComments = $_POST['comments']; 
		$this->orderDdmOrder = $_POST['ddmOrder']; 
		$this->orderTbOrder = $_POST['tbOrder']; 
		$this->orderTbname = $_POST['tbname']; 
		
		if($this->orderName =='' || $this->orderPhone == '' || $this->orderAddress == '' || $this->orderItems == '' || $this->orderDdmOrder == '' )
			return false;

		return true;

	}

	public function action(){
		
		$postModel = new MyOrderModel();

		$items = explode(',',$this->orderItems);
		$items =array_filter($items);

		$DdmOrder = explode(',',$this->orderDdmOrder);
		$DdmOrder =array_filter($DdmOrder);

		if( $this->orderTbOrder != '')
		{
			$tbOrder = explode(',',$this->orderTbOrder);
			$tbOrder = array_filter($tbOrder);
		}
		else
		{
			$tbOrder = array();
		}


		$doc = array(
			'name'=>$this->orderName,
			'phone'=>$this->orderPhone,
			'createtime'=> strtotime($this->orderDate),
			'address'=>$this->orderAddress,
			'items' =>$items,
			'comments'=>$this->orderComments,
			'ddmOrder' =>$DdmOrder,
			'tbOrder'=>$tbOrder,
			'tbname'=>$this->orderTbname,

		);

		if($this->orderId)
		{
			$doc['_id'] = $this->orderId;
		}


		$data = $postModel->editPost($doc);
		
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


	}

}

?>
