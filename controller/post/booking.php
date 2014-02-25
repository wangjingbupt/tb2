<?php

class PostBooking extends control{


	public function checkPara(){

		$this->itemId = $GLOBALS['URL_PATH'][1];

		
		if($this->itemId  <=0 || !is_numeric($this->itemId) )
			return false;

		return true;

	}

	public function action(){
		
		
		$postModel = new PostModel();
		$item  = $postModel->getItem($this->itemId);
		if($item)
		{
			if(isset($_COOKIE['booking']))
				$booking = explode(',',$_COOKIE['booking']);
			
			$booking[] = $this->itemId; 
			$booking  = array_unique($booking);
			setCookie('booking',implode(',',$booking),time()+3600*24,'/');

		}
		header('Location: '.$_SERVER['HTTP_REFERER']);

	}

	public function includeFiles()
	{


	}

}

?>
