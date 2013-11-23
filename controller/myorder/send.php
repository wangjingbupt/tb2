<?php

class MyOrderSend extends control{


	public function checkPara(){

		$this->orderId = $_GET['id'];
		if($this->orderId =='')
			return false;

		return true;

	}

	public function action(){
		
		$postModel = new MyOrderModel();


		$data = $postModel->getMyOrder($this->orderId);
		if($data)
		{
			$data['status'] =2;
		}
		$data = $postModel->editPost($data);
		
		$uri ="/myorder/detail/{$data['_id']}";
		header("Location: $uri");


	}


	public function includeFiles()
	{


	}

}

?>
