<?php
class ViewDetail {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');

		$html = '<div class="row-fluid">';
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
				<label><span class='muted'>发货状态 :</span> <span class='text-error'>$status ; </span> <span class='muted'>姓名 : </span> <span class='text-info'>{$name} ; </span> <span class='muted'>日期 : </span> <span class='text-error'>{$date}</span></label>
				<label><span class='muted'>电话 : </span> <span class='text-error'>{$phone}</span></label>
				<label><span class='muted'>地址 : </span> <span class='text-error'>{$address}</span></label>
			";

			if(!empty($datas['order']['itemsDetail']))
			{
				$html .="<label><span class='muted'>未发货商品 : <a class='btn btn-mini btn-primary' href='/myorder/sendOrder?id={$datas['order']['_id']}'>全部发货</a></span><table class='table table-bordered'><tr>";
				$c = 1;
				foreach($datas['order']['itemsDetail'] as $item)
				{
					$item['img'] = str_replace('!small','!140.jpg',$item['img']);
					$html .="<td style='width:16%;word-break:break-all; word-wrap:break-word;'><img src='{$item['img']}'></br>{$item['id']}</br> {$item['status']} {$item['num']} <br/><a class='btn btn-mini btn-primary' href='/myorder/sendItem?itemId={$item['id']}&id={$datas['order']['_id']}'>单品发货</a></td>";
					if($c++%6 ==0)
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
			";

		}

		echo $html;
		//include(VIEW.'/container.php');
			
		include(VIEW.'/footer.php');
	}


}
?>
