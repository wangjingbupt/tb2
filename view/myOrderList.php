<?php
class ViewIndex {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');

		$classConf = array(
			1=>'未发货',
			2=>'已发货',
			3=>'部分已发货',
		);

		$html = '<div class="container"><div class="row-fluid"><div class="span12"><div class = "span12">';
		$html .='<div class="navbar"><div class="navbar-inner"><a class="brand" href="#">分类</a><ul class="nav">';
		if($this->cat =="")
			$html .='<li class="active"><a href="/myorder">全部</a></li>';
		else
			$html .='<li><a href="/myorder">全部</a></li>';
		foreach($classConf as $k => $v)
		{
			if($this->cat == $k )
				$html .="<li class='active'><a href='/myorder?cat={$k}'>{$v}</a></li>";
			else
				$html .="<li><a href='/myorder?cat={$k}'>{$v}</a></li>";
		}
		$html .="</ul></div></div>";
		$html .="<button class='btn'><a href='/myorder/edit'>New</a></button>";
		$html .=<<<HTML
	 
	 <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	   <div class="modal-header">
		     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				     <h3 id="myModalLabel">订单详情</h3>
						   </div>
							   <div class="modal-body">

										   </div>
																	 </div>
HTML;
		$html .='<div><ul class="pager">';
		if(isset($datas['hasPrev']))
		{
			$html .='<li class="previous"><a href="/myorder/page/'.intval($datas['hasPrev'])."?".$_SERVER['QUERY_STRING'].'">Prev</a></li>';
		}
		if(isset($datas['hasNext']))
		{
			$html .='<li class="next"><a href="/myorder/page/'.intval($datas['hasNext'])."?".$_SERVER['QUERY_STRING'].'">Next</a></li>';
		}
		$html .='</ul></div>';

		if(is_array($datas['order']) && !empty($datas['order']))
		{
			foreach($datas['order'] as $post)
			{
				$classCheck = '';
				foreach($classConf as $k =>$class)
				{
					$img ='';
					$ddm ='';
					$tb ='';
					$classCheck .="<span style='margin-left:5px;line-height:25px;'><input type='checkbox' value='$k' name='class_check'/> {$class} </span>";
				}


				$address ="<span class='text-info'>".$post['address']."</span>";
				$address .="<span class='text-error'><br><br>电话：".$post['phone']."</span>";
				if($post['comments'] !='')
				$address .="<span class='text-info'><br><br>备注：".$post['comments']."</span>";
				if( $post['status'] == '已发货')
				{
					$sendOrder = " ";
				}
				else
				{
					$sendOrder = "<a href='#myModal' class='btn btn-small btn-primary' role='button' data-toggle='modal' data-remote='/myorder/detail/$id' >发货</a>";
				}	


				if(!isset($post['itemsDetail']) || !is_array($post['itemsDetail']) || empty($post['itemsDetail']))
					continue;
				$img ="<table border='0'><tr>";
				$c = 1;
				foreach($post['itemsDetail'] as $item)
				{
					$itemStatus = isset($item['orderStatus']) ? $item['orderStatus'] : '未订货';
					$item['img'] = str_replace('!small','!140.jpg',$item['img']);
					$img .="<td style='width:10%;word-break:break-all; word-wrap:break-word;'><a href='{$item['url']}' target='_blank'><img src='{$item['img']}'></a></br>{$itemStatus}</td>";
					if($c++%5 ==0)
						$img .="</tr><tr>";
				}
				$img .="</tr></table>";
				$id = trim($post['_id']);
				$name = $post['name'];
				$status = $post['status'];
				if(date('Y',$post['createtime']) == date('Y'))
					$status .='<br>'.date("m-d H:i",$post['createtime']);
				else
					$status .= '<br>'.date("Y-m-d H:i",$post['createtime']);
				if($post['status'] == '已发货')
					$bg = 'background-color:#16a085;';
				else
					$bg='';
				if($post['ddmOrder'])
				{
					$ddm ='<span class="text-error">东大门订单: ';
					foreach($post['ddmOrder'] as $ddmOrder)
					{
						$ddm .=" <a href='http://dongdamen.yiss.com/customer/myOrderView.html?key={$ddmOrder}' target='_blank' >{$ddmOrder}</a> ";
					}
					$ddm .='</span>';
				}
				if($post['tbOrder'])
				{
					$ddm .= '<span class="text-info"><br><br>淘宝订单: ';
					foreach($post['tbOrder'] as $tbOrder )
					{
						$ddm .=" <a href='http://trade.taobao.com/trade/detail/trade_item_detail.htm?bizOrderId={$tbOrder}' target='_blank'>{$tbOrder}</a> ";
					}
					$ddm .='</span>';
				}
				$html .= <<<HTML
					<div class="well">
					<table class="table table-bordered">
					<tr style='$bg'>
					<td style='width:12%;'>$status </td>
					<td style='width:46%;'>$img</td>
					<td style='width:5%;'>$name</td>
					<td style='width:5%;'>$ddm</td>
					<td style='width:20%;'>$address</td>

					<td style='width:6%;'><a href="/myorder/edit/$id"><small>编辑</small></a><br><br/> 
					$sendOrder
					</td>
					</tr>
					</table>
					</div><!--/.well href='/myorder/sendOrder?id=$id' -->

HTML;


			}
		}
		$html .='<div><ul class="pager">';
		if(isset($datas['hasPrev']))
		{
			$html .='<li class="previous"><a href="/myorder/page/'.intval($datas['hasPrev'])."?".$_SERVER['QUERY_STRING'].'">Prev</a></li>';
		}
		if(isset($datas['hasNext']))
		{
			$html .='<li class="next"><a href="/myorder/page/'.intval($datas['hasNext'])."?".$_SERVER['QUERY_STRING'].'">Next</a></li>';
		}
		$html .='</ul></div>';

		$html .='</div></div></div>';
		echo $html;
		//include(VIEW.'/container.php');

		include(VIEW.'/footer.php');
	}


}
?>
