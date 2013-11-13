<?php

class PostAddComment extends control{


	public function checkPara(){

		$this->id = trim($_POST['item_id']);
		$this->cms = trim($_POST['cms']);
		$this->class = trim($_POST['class']);
		
		if($this->id == '' || $this->cms == '')
			return false;

		return true;

	}

	public function action(){
		
		
		$postModel = new PostModel();

		$class = explode(',',$this->class);
		$class = array_filter($class);

		$data = $postModel->editPostComment($this->id,$this->cms,$class);
		$this->display(array('code'=>'ok','data'=>$data));

	}


	public function includeFiles()
	{


	}

}

?>
