<?php

class PostBooking extends control{


	public function checkPara(){
		
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
					$datas['post'][] = $item;
				}
			}
		}


		$this->format($datas);

	}


	public function includeFiles()
	{

		include(MODEL_POST."/PostModel.php");
		include(VIEW.'/confirmCart.php');

	}
	
	public function format($datas)
	{
		$data['activeHome'] = 'class="active"';
		$data['activePhoto'] = '';
		$data['activeWeibo'] = '';
		$GLOBALS['DATA'] = $data;
		if($GLOBALS['UA_TYPE'] == 'phone')
		{
			ViewConfirmCart::renderPhone($datas);
		}
		else
		{
			ViewConfirmCart::render($datas);
		}
		
		
		
		//print_r($datas);
	}


}

?>
