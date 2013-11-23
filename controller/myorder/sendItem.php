<?php

class MyOrderSendItem extends control{


	public function checkPara(){

		$this->orderId = $_GET['id'];
		$this->itemId = $_GET['itemId'];
		if($this->orderId =='' || $this->itemId =='')
			return false;

		return true;

	}

	public function action(){
		
		$postModel = new MyOrderModel();


		$data = $postModel->getMyOrder($this->orderId);
		if($data)
		{
			$data['status'] =3;
			foreach($data['items'] as $item)
			{
				if($this->itemId == $item)
				{
					$data['itemsOk'][] = $item;
				}
			}
			$data = $postModel->editPost($data);
		}
		
		$uri ="/myorder/detail/{$data['_id']}";
		header("Location: $uri");


	}


	public function includeFiles()
	{


	}

}

?>
