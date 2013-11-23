<?php
class ViewDetail {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');

		$html = '<div class="container"><div class="row-fluid"><div class="span9"><div class = "span12">';
		if(is_array($datas['order']) && !empty($datas['order']))
		{
			if(date('Y',$post['createtime']) == date('Y'))
				$post['pubtime'] = date("m-d H:i",$post['createtime']);
			else
				$post['pubtime'] = date("Y-m-d H:i",$post['createtime']);
			
			$id = $datas['order']['_id'];
			$name =$datas['order']['name'];
			if($datas['order']['createtime'])
				$date =date("Y-m-d H:i:s",$datas['order']['createtime']);
			else
				$date =date("Y-m-d H:i:s");
			$phone = $datas['order']['phone'];
			$address = $datas['order']['address'];
			$items = implode(',',$datas['order']['items']);
			$comments = $datas['order']['comments'];
			foreach($datas['order']['ddmOrder'] as $id)
			{
				$dongdamenOrder .= " <br/><a href='http://dongdamen.yiss.com/customer/myOrderView.html?key={$id}' target='_blank' >{$id}</a>";
			}

			foreach($datas['order']['tbOrder'] as $id)
			{
				$taobaoOrder .= " <br/><a href='http://trade.taobao.com/trade/detail/trade_item_detail.htm?bizOrderId={$id}' target='_blank' >{$id}</a>";
			}

			$tbname = $datas['order']['tbname'];
			$status = $datas['order']['status'];

			$html .="
			<div class='well' >
				<legend>订单详情</legend>
				<label><span class='muted'>发货状态 :</span> <span class='text-error'>$status</span></label>
				<label><span class='muted'>姓名 : </span> <span class='text-info'>{$name}</span></label>
				<label><span class='muted'>电话 : </span> <span class='text-error'>{$phone}</span></label>
				<label><span class='muted'>日期 : </span> <span class='text-info'>{$date}</span></label>
				<label><span class='muted'>地址 : </span> <span class='text-error'>{$address}</span></label>
			";
			if(!empty($datas['order']['itemsDetail']))
			{
				$html .="<label><span class='muted'>未发货商品 : </span><table class='table table-bordered'><tr>";
				$c = 1;
				foreach($datas['order']['itemsDetail'] as $item)
				{
					$html .="<td><img src='{$item['img']}'></td><td>{$item['id']} {$item['status']} {$item['num']}</td>";
					if($c++%4 ==0)
						$html .="</tr><tr>";
				}
				$html .="</tr></table></label>";
			}
			if(!empty($datas['order']['itemsDetailOk']))
			{
				$html .="<label><span class='muted'>已发货商品 : </span><table class='table table-bordered'><tr>";
				$c = 1;
				foreach($datas['order']['itemsDetailOk'] as $item)
				{
					$html .="<td><img src='{$item['img']}'></td><td>{$item['id']} {$item['status']} {$item['num']}</td>";
					if($c++%4 ==0)
						$html .="</tr><tr>";
				}
				$html .="</tr></table></label>";
			}
			$html .="
				<label><span class='muted'>备注:</span> <span class='text-error'>{$comments}</span></label>
				<label><span class='muted'>东大门订单 : </span> <span class='text-info'>{$dongdamenOrder}</span></label>
				<label><span class='muted'>淘宝订单 : </span> <span class='text-error'>{$taobaoOrder}</span></label>
				<label><span class='muted'>淘宝id :</span> <span class='text-info'>$tbname</span></label>
			</div>
			";

		}

		$html .='</div></div></div>';
		echo $html;
		//include(VIEW.'/container.php');
			
		include(VIEW.'/footer.php');
	}


}
?>
