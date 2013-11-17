<?php

class MyOrderEdit extends control{


	public function checkPara(){

		$this->id = $GLOBALS['URL_PATH'][2];
		
		return true;

	}

	public function action(){
		
		$postModel = new MyOrderModel();

		if($this->id)
		{
			$datas['order'] = $postModel->getMyOrder($this->id);
		}
		
		$this->format($datas);

	}


	public function includeFiles()
	{

		include(VIEW.'/myOrderEdit.php');

	}
	public function format($datas)
	{
		$data['activeMyOrder'] = 'class="active"';
		$GLOBALS['DATA'] = $data;
		ViewMyOrderEdit::render($datas);
	}

}

?>
