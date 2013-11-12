<?php

class PostAddComment extends control{


	public function checkPara(){

		$this->id = trim($_POST['item_id']);
		$this->cms = trim($_POST['cms']);
		
		if($this->id == '' || $this->cms == '')
			return false;

		return true;

	}

	public function action(){
		
		
		$postModel = new PostModel();

		$data = $postModel->editPostComment($this->id,$this->cms);
		$this->display(array('code'=>'ok','data'=>$data));

	}


	public function includeFiles()
	{


	}

}

?>
