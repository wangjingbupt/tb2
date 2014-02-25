<?php

class PostBookingDel extends control{


	public function checkPara(){

		$this->itemId = $GLOBALS['URL_PATH'][1];

		
		if($this->itemId  <=0 || !is_numeric($this->itemId) )
			return false;

		return true;

	}

	public function action(){
		
		
		if(isset($_COOKIE['booking']))
		{
				$tmpBooking = array();
				$booking = explode(',',$_COOKIE['booking']);
				foreach($booking as $id)
				{
					if($id <> $this->itemId)
						$tmpBooking[] = $id;
				}
				setCookie('booking',implode(',',$tmpBooking),time()+3600*24,'/');
		}
			
		header('Location: '.$_SERVER['HTTP_REFERER']);

	}

	public function includeFiles()
	{


	}

}

?>
