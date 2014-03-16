<?php
include(VIEW.'/post.php');
class ViewIndex {


	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');


		$html = '<div class="container"><div class="row-fluid"><div class="span10"><div class = "span12">';
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
				if(date('Y',$post['createtime']) == date('Y'))
					$post['pubtime'] = date("m-d H:i",$post['createtime']);
				else
					$post['pubtime'] = date("Y-m-d H:i",$post['createtime']);

				$id = trim($post['id']);
				$img = $post['img'];
				$title = $post['title'];
				$status = $post['onsale'] ? '有货':'无货';
				if(!$post['onsale'])
					$bg = 'background-color:#c0392b;';
				else
					$bg='';
				$url = $post['url'];
				$price = $post['price'];
				$band = isset($post['band']) ? $post['band'] : '';
				$myPrice = $post['myPrice'] ;
				$pubtime = $post['pubtime'];
				$cat = isset($post['cat']) ? $post['cat'] : array();
				$class = '';
				foreach($cat as $c)
				{
					$class .=isset($class) ? $classConf[$c] : "," .$classConf[$c];
				}

				$_id = $post['_id'];
				$html .= <<<HTML
					<div class="well">
					<table class="table table-bordered">
					<tr style='$bg'>
					<td style='width:10%;'>$id </br> $status</br><a href="$url" target='_blank'>链接地址</a></br>$price</br>$band</td>
					<td style='width:15%;'>$title</td>
					<td style='width:20%;'><img src="$img"></td>
					<td style='width:5%;'>$myPrice</td>
					<td style='width:6%;'>$pubtime</td>
					<td style='width:7%;'><a href="/deletepost/$_id"><small>删除</small></a></br></br>
																<a href="/booking/$id"><small>订货</small></a>
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

		$html .='</div></div>';

		$html .='<div class="span2">'; 

		if(is_array($datas['finder']) && !empty($datas['finder']))
		{
			$html .= '<div class="well"><ul class="nav nav-tabs nav-stacked"><li><h5>归档</h5></li>';	
			foreach($datas['finder'] as $line)
			{
				$name = $line['date'];
				$url ='/finder/'.$line['date'];
				$html .='<li><a href="'.$url.'">'.$name.' ('.$line['num'].')</a></li>';
			}
			$html .= '</ul></div>';
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
