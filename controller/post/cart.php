<?php

class PostCart extends control{


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
				$item  = $postModel->getItem($itemId);  
				if($item)
				{
					$datas['post'][] = $item;
				}
			}
		}


		$this->format($datas);

	}


	public function includeFiles()
	{

		include(VIEW.'/cart.php');

	}
	
	public function format($datas)
	{
		$data['activeHome'] = 'class="active"';
		$data['activePhoto'] = '';
		$data['activeWeibo'] = '';
		$GLOBALS['DATA'] = $data;
		if($GLOBALS['UA_TYPE'] == 'phone')
		{
			ViewCart::renderPhone($datas);
		}
		else
		{
			ViewCart::render($datas);
		}
		
		
		
		//print_r($datas);
	}


}

?>
