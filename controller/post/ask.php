<?php

class PostAsk extends control{


	public function checkPara(){
		
		$this->itemId = intval($_GET['itemId']);

		return true;

	}

	public function action(){

		if($this->itemId > 0)
		{

			$postModel = new PostModel();

			$datas['post'] = $postModel->getItem($this->itemId);

			if($datas['post']['img'])
			{
				$fileDir = ROOT.'/../images/myblog/sys/';
				$file = $fileDir.$datas['post']['id'].'.jpg';
				if(!file_exists($file))
				{
					$img = file_get_contents($datas['post']['img']);
					file_put_contents($file,$img);
					
				}
				$datas['post']['img'] = 'http://img.sleepwalker.pro/sys/'.$datas['post']['id'].'.jpg';
			}

		}
		else
			$this->itemId ='';

		$this->format($datas);

	}


	public function includeFiles()
	{

		include(VIEW.'/item.php');

	}
	
	public function format($datas)
	{
		$data['activeHome'] = 'class="active"';
		$data['activePhoto'] = '';
		$data['activeWeibo'] = '';
		$GLOBALS['DATA'] = $data;
		if($GLOBALS['UA_TYPE'] == 'phone')
		{
		//	ViewItem::renderPhone($datas);
			ViewItem::render($datas);
		}
		else
		{
			ViewItem::render($datas);
		}
		
		
		
		//print_r($datas);
	}
}

?>
