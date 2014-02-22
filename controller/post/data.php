<?php

class PostData extends control{


	public function checkPara(){
		return true;
		
	}

	public function action(){
		$path ='/home/erik/site/taobao/data/items/';
		$file = $path .date('Ymd').".log";
		$fp = fopen($file,'r');
		while(($line = fgets($fp)))
		{
			echo $line;
		}
		
	}

}

?>
