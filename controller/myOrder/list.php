<?php

class MyOrderList extends control{


	public function checkPara(){
		
		$this->page = intval($GLOBALS['URL_PATH'][2]);

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
		ViewIndex::render($datas);
		
		
		
		//print_r($datas);
	}

}

?>
