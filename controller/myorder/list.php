<?php

class MyOrderList extends control{


	public function checkPara(){
		
		$this->page = isset($GLOBALS['URL_PATH'][2]) ? intval($GLOBALS['URL_PATH'][2]) :0;
		$this->cat = isset($_GET['cat']) ? trim($_GET['cat']):0;
		$this->skey = isset($_GET['skey'])?trim($_GET['skey']) :0;

		return true;

	}

	public function action(){
		$postModel = new MyOrderModel();
		$orderModel = new orderModel();
		$itemModel = new PostModel();

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
			if(!isset($order['items']))
				continue;
			$items = $itemModel->getItemsByIds($order['items']);
			if(is_array($items) || !empty($items))
			{
				$temp = array();
				foreach($items as $item)
				{
					$item['img'] = str_replace('!tall.jpg','!small',$item['img']);
					$temp[$item['id']] = $item;	
				}
				$items = $temp;
			}
			else
			{
				$items = array();
			}
				
			foreach($order['ddmOrder'] as $oid)
			{
				$ddmOrder = $orderModel->getDetail($oid);
				if(is_array($ddmOrder['items']) && !empty($ddmOrder['items']))
				{
					foreach($ddmOrder['items'] as $i_v)
					{
						$t = json_decode($i_v,true);
						if(!isset($items[$t['id']]))
						{
							$items[$t['id']] =$t ; 
						}
						else
						{
							$items[$t['id']]['num'] = $t['num'] ;
							$items[$t['id']]['orderStatus'] = $t['status'] ;
							$items[$t['id']]['price'] = $t['price'] ;

						}

					}
				}
			}
			if(!isset($order['itemsOk']))
				$order['itemsOk'] = array();
			foreach($order['items'] as $id)
			{
				if(!in_array($id,$order['itemsOk']))
				{
					if(isset($items[$id]))
					{
						$order['itemsDetail'][] = $items[$id];
					}
				}
			
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
		include(MODEL_POST."/PostModel.php");

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
