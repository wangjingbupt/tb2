<?php

class PostDelPost extends control{


	public function checkPara(){

		$this->pid = $GLOBALS['URL_PATH'][1];
		if($GLOBALS['LOGIN_DATA']['is_admin'] !=1 )
		{
			return false;
		}
		return true;

	}

	public function action(){
		
		
		$postModel = new PostModel();
		
		$post = $postModel->delPost($this->pid);
		if($post)
		{
			//$postModel->decFinderNum($post['createtime']);
		}
		$uri = '/';
		header("Location: $uri");
	}


	public function includeFiles()
	{
	}


	public function format($datas)
	{
	}
}

?>
