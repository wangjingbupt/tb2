<?php

class MyOrderList extends control{


	public function checkPara(){
		
		$this->page = intval($GLOBALS['URL_PATH'][2]);
		$this->cat = trim($_GET['cat']);
		$this->skey = trim($_GET['skey']);

		return true;

	}

	public function action(){
		$postModel = new MyOrderModel();
		$orderModel = new orderModel();

		$where = array();

		if($this->cat != '')
		{
			$where = array(
				'status'=>array('$in'=>array(intval($this->cat))),	
		
			);
		}

		$datas['order'] = $postModel->getPostList($this->page,$where);
		$postNum = $postModel->getPostCount($where);

		foreach($datas['order'] as &$order )
		{
			$items = array();
			foreach($order['ddmOrder'] as $oid)
			{
				$ddmOrder = $orderModel->getDetail($oid);
				foreach($ddmOrder['items'] as $i_v)
				{
					$t = json_decode($i_v,true);
					$items[$t['id']] =$t ; 
				}
			}
			foreach($order['items'] as $id)
			{
				if(!in_array($id,$order['itemsOk']))
				$order['itemsDetail'][] = $items[$id];
			}
			switch($order['status'])
			{	
				case 1 :
					$order['status'] = '未发货';
					break;
				case 2 :
					$order['status'] = '已发货';
					break;
				case 3 :
					$order['status'] = '部分已发货';
					break;
			}

		}

		if($postNum > POST_PAGE_NUM * ($this->page+1))
			$datas['hasNext'] = $this->page+1;

		if($this->page > 0)
			$datas['hasPrev'] = $this->page-1;

		$this->format($datas);

	}


	public function includeFiles()
	{

		include(MODEL_ORDER."/OrderModel.php");
		include(VIEW.'/myOrderList.php');

	}
	
	public function format($datas)
	{
		$data['activeMyOrder'] = 'class="active"';
		$GLOBALS['DATA'] = $data;
		ViewIndex::render($datas);
		
		
		
		//print_r($datas);
	}

}

?>
