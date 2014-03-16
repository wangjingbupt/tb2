<?php

class PostList extends control{


	public function checkPara(){
		
		$this->page = isset($GLOBALS['URL_PATH'][2]) ?intval($GLOBALS['URL_PATH'][2]):0;

		return true;

	}

	public function action(){
		$postModel = new OrderModel();
		$datas['post'] = $postModel->getPostList($this->page);
		$postNum = $postModel->getPostCount();
		if($postNum > POST_PAGE_NUM * ($this->page+1))
			$datas['hasNext'] = $this->page+1;

		if($this->page > 0)
			$datas['hasPrev'] = $this->page-1;


		$this->format($datas);

	}


	public function includeFiles()
	{

		include(VIEW.'/order.php');

	}
	
	public function format($datas)
	{
		$data['activeOrder'] = 'class="active"';
		$GLOBALS['DATA'] = $data;
		if($GLOBALS['UA_TYPE'] == 'phone')
		{
			ViewIndex::renderPhone($datas);
		}
		else
		{
			ViewIndex::render($datas);

		}
		
		
		
		//print_r($datas);
	}

}

?>
