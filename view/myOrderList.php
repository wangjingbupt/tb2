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


				foreach($post['itemsDetail'] as $item)
				{
					$item['img'] = str_replace('!small','!140.jpg',$item['img']);
					$img .="<a href='{$item['url']}' target='_blank'><img src='{$item['img']}'></a>";
				}
				$id = trim($post['_id']);
				$name = $post['name'];
				$status = $post['status'];
				if(date('Y',$post['createtime']) == date('Y'))
					$status .='<br>'.date("m-d H:i",$post['createtime']);
				else
					$status .= '<br>'.date("Y-m-d H:i",$post['createtime']);
				if(!$post['status'] == '已发货')
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
					<td style='width:48%;'>$img</td>
					<td style='width:5%;'>$name</td>
					<td style='width:5%;'>$ddm</td>
					<td style='width:20%;'>$address</td>

					<td style='width:4%;'><a href="/myorder/detail/$id"><small>详情</small></a><br><br> <a href="/myorder/edit/$id"><small>编辑</small></a></td>
					</tr>
					</table>
					</div><!--/.well -->

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
