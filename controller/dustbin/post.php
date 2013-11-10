<?php
include(MODEL_POST."/PostModel.php");

class DustbinPost extends control{


	public function checkPara(){
		
		$this->page = intval($GLOBALS['URL_PATH'][2]);
		$this->rec = $_GET['rec'];

		return true;

	}

	public function action(){
		$postModel = new PostModel();
		$datas['posts'] = $postModel->getDelPosts($this->page);
		$datas['rec'] = $this->rec;


		$this->format($datas);

	}


	public function includeFiles()
	{

		include(VIEW_DUSTBIN.'/posts.php');

	}
	
	public function format($datas)
	{
		$data['activeHome'] = 'class="active"';
		$data['activePhoto'] = '';
		$data['activeWeibo'] = '';
		$GLOBALS['DATA'] = $data;
		ViewDustbinPost::render($datas);
		
		
		
		//print_r($datas);
	}

}
?>
