<?php

class MyOrderPurchase extends control{


	public function checkPara(){
		
		return true;

	}

	public function action(){
		$scmModel = new ScmOrderModel();
		$postModel = new PostModel();

		$datas['post'] = $scmModel->getPostList();

		foreach($datas['post'] as &$item )
		{
			$itemInfo = $postModel->getItem($item['id']);
			$item['img'] = $itemInfo['img'];

		}

		$this->format($datas);

	}


	public function includeFiles()
	{

		include(MODEL_SCMORDER."/ScmOrderModel.php");
		include(MODEL_POST."/PostModel.php");
		include(VIEW.'/purchase.php');

	}
	
	public function format($datas)
	{
		$data['activePurchase'] = 'class="active"';
		$GLOBALS['DATA'] = $data;
		ViewPurchase::render($datas);
		
		
		
		//print_r($datas);
	}

}

?>
