<?php

class MyOrderUpdatePurchase extends control{


	public function checkPara(){


		$this->ddmOrderId = $_POST['ddmOrderId']; 
		$this->purchaseIds = $_POST['purchaseIds']; 
		if($this->ddmOrderId =='' || !is_numeric($this->ddmOrderId) || $this->purchaseIds =='')
			return false;

		
		return true;

	}

	public function action(){

		$scmModel = new ScmOrderModel();
		$myOrderModel = new myOrderModel();

		$purchaseIds = explode(',',$this->purchaseIds);
		foreach($purchaseIds as $id)
		{
			$purchase = $scmModel->updatePurchase($id,$this->ddmOrderId);
			if($purchase)
			{
				$myOrderId = $purchase['myOrderId'];
				$myOrderModel->updateDdmOrder($myOrderId,$this->ddmOrderId);
			}

		}

		$uri ="/myorder";
		header("Location: $uri");
	}


	public function includeFiles()
	{

		include(MODEL_SCMORDER."/ScmOrderModel.php");
		include(MODEL_MYORDERORDER."/MyOrderModel.php");

	}
	
	public function format($datas)
	{
	}

}

?>
