<?php
class ViewAddress {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');

		$html = '<div class="container"><div class="row-fluid"><div class="span12"><div class = "span12"><form action="/myorder/confirmAddress" method="POST" >';
		$radioCheck = 'checked';
		if(is_array($datas['customer']) && !empty($datas['customer']))
		{
			$c=0;
			foreach($datas['customer'] as $address)
			{
				$c++;
				$html .='<div class="well"><label class="radio"><input type="radio" name="newAddress" value="'.$c.'" '.$radioCheck.' >地址'.$c.'</label><span class="help-inline">顾客姓名: </span> &nbsp&nbsp'.$address['name'].' &nbsp电话:&nbsp&nbsp&nbsp'.$this->phone_no.'<input type="hidden" name="phone" value="'.$this->phone_no.'" ></br><span class="help-inline">地址：</span>&nbsp&nbsp'.$address['address'].'</div>';
				$radioCheck = '';
			}
		}

		$html .='<div class="well"><label class="radio"><input type="radio" name="newAddress" value="0" '.$radioCheck.' >新地址</label><span class="help-inline">顾客姓名: </span> &nbsp&nbsp<input class="input-small" name="name" type="text">&nbsp&nbsp&nbsp&nbsp&nbsp电话:&nbsp&nbsp&nbsp'.$this->phone_no.'<input type="hidden" name="phone" value="'.$this->phone_no.'" ></br><span class="help-inline">地址：</span>&nbsp&nbsp<input class="input-xxlarge" type="text" name="address" ></div>';
		$html .='<div class="well"><span class="help-inline">备注：</span>&nbsp&nbsp<input class="input-xxlarge" type="text"  name="comments" ></br><span class="help-inline">淘宝订单链接：</span>&nbsp&nbsp<input class="input-xxlarge" name="tbOrder" type="text" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="hidden" name="items" value="'.$this->items.'" ><button class="btn btn-large btn-primary" type="submit">确定</button></form></div>';

		if(is_array($datas['post']) && !empty($datas['post']))
		{
			foreach($datas['post'] as $post)
			{
				$id = trim($post['id']);
				$img = str_replace('!tall.jpg','!140.jpg',$post['img']);
				$title = $post['title'];
				$url = $post['url'];
				$price = $post['price'];
				$myPrice = $post['myPrice'] ;
				$num = $post['num'];
				$comment =isset($post['comment']) ? $post['comment'] : '';

				$_id = $post['_id'];
				$html .= <<<HTML
					<div class="well">
					<table class="table table-bordered">
					<tr>
					<td style='width:10%;'><img src="$img"></td>
					<td style='width:7%;'>$id </br> $status</br><a href="$url" target='_blank'>链接地址</a></br>$price</br>$band</td>
					<td style='width:15%;'>$title</td>
					<td style='width:5%;'>$myPrice</td>
					<td style='width:12%;'>数量: $num</td>
					<td style='width:10%;'>备注: $comment</td>
					</tr>
					</table>
					</div><!--/.well -->

HTML;

			}
		}
		$html .='</div></div></div>';
		echo $html;
		//include(VIEW.'/container.php');

		include(VIEW.'/footer.php');
	}

	public function renderPhone($datas)
	{

		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/bannerPhone.php');

		$classConf = classConf::i2c();

		$html = '<div class="container"><div class="row-fluid"><div class="span12"><div class = "span12">';
		$html .="<form class='form-search' action='/' method='GET'><input type='text' name = 'skey' class='input-medium search-query' value='{$this->skey}'><input type='hidden' name = 'cat' value = '{$this->cat}'> <button type='submit' class='btn'>Search</button></form>";
		$html .='<div><ul class="pager">';
		if(isset($datas['hasPrev']))
		{
			$html .='<li class="previous"><a href="/page/'.intval($datas['hasPrev'])."?".$_SERVER['QUERY_STRING'].'">Prev</a></li>';
		}
		if(isset($datas['hasNext']))
		{
			$html .='<li class="next"><a href="/page/'.intval($datas['hasNext'])."?".$_SERVER['QUERY_STRING'].'">Next</a></li>';
		}
		$html .='</ul></div>';

		if(is_array($datas['post']) && !empty($datas['post']))
		{
			$nn = 0;
			foreach($datas['post'] as $post)
			{
				$classCheck = '';
				foreach($classConf as $k =>$class)
				{
					$classCheck .="<span style='margin-left:5px;line-height:25px;'><input type='checkbox' value='$k' name='class_check_$nn'/> {$class} </span>";
				}
				if(date('Y',$post['createtime']) == date('Y'))
					$post['pubtime'] = date("m-d H:i",$post['createtime']);
				else
					$post['pubtime'] = date("Y-m-d H:i",$post['createtime']);

				$id = trim($post['id']);
				$img = str_replace('!tall.jpg','!140.jpg',$post['img']);
				$title = $post['title'];
				$status = $post['onsale'] ? '有货':'无货';
				if(!$post['onsale'])
					$bg = 'background-color:#c0392b;';
				else
					$bg='';
				$url = $post['url'];
				$price = $post['price'];
				$band = isset($post['band']) ? $post['band'] : '';
				$myPrice = $post['myPrice'];
				$pubtime = $post['pubtime'];
				$cat = isset($post['cat']) ? $post['cat'] : array();
				$class = '';
				foreach($cat as $c)
				{
					$class .=isset($class) ? $classConf[$c] : "," .$classConf[$c];
				}

				$_id = $post['_id'];
				$comments = isset($post['comments']) ? $post['comments']."</td><td style='width:8%;'>". $class : "<input type='text' id='comment_$nn' /><input type='hidden' id='item_$nn' value='$id' />{$classCheck}<button type='submit' name='cms_button' id='cms_button' onclick='postdata($nn);return false;' class='btn btn-inverse btn-small'>提交</button>";
				$html .= <<<HTML
					<div class="well">
					<table class="table table-bordered">
					<tr style='$bg'>
					<td style='width:60%;'><img src="$img"></td>
					<td style='width:25%;'><a href="$url" target='_blank'>链接地址</a></td>
					<td style='width:15%;'>$myPrice</td>
					</tr>
					</table>
					</div><!--/.well -->

HTML;
				$nn++;


			}
		}
		$html .='<div><ul class="pager">';
		if(isset($datas['hasPrev']))
		{
			$html .='<li class="previous"><a href="/page/'.intval($datas['hasPrev'])."?".$_SERVER['QUERY_STRING'].'">Prev</a></li>';
		}
		if(isset($datas['hasNext']))
		{
			$html .='<li class="next"><a href="/page/'.intval($datas['hasNext'])."?".$_SERVER['QUERY_STRING'].'">Next</a></li>';
		}
		$html .='</ul></div>';

		$html .='</div></div></div>';
		echo $html;
		//include(VIEW.'/container.php');

		include(VIEW.'/footer.php');


	}

}
?>
