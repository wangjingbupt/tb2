<?php
class ViewItem {


	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');


		$html = '<div class="container" style="margin-top:30px;"><div class="row-fluid"><div class="span12"><div class = "span12">';
		$html .="<form class='form-search' action='/ask' method='GET'><input type='text' name = 'itemId' class='input-medium search-query' value='{$this->itemId}'> <button type='submit' class='btn'>Search</button></form>";
		$html .="<div class='well' style='margin:5px;'>输入图片右上角产品编码查询价格</div>";

		if(is_array($datas['post']) && !empty($datas['post']))
		{
				$post = $datas['post'];

				$id = trim($post['id']);
				$img = $post['img'];
				$status = $post['onsale'] ? '有货':'无货';
				$myPrice = $post['myPrice'] ;
				$html .= <<<HTML
					<div class="well">
					<table class="table table-bordered">
					<tr>
					<td style='width:40%;'>货号：$id</br>
					状态：$status</br>
					价格：$myPrice</br>
					</td>
					<td style='width:60%;'><img src="$img"></td>
					</tr>
					</table>
					</div><!--/.well -->

HTML;

		}
		$html .='</div></div>';



		$html .='</div></div></div>';
		echo $html;
		//include(VIEW.'/container.php');

	}

	public function renderPhone($datas)
	{

		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');


		$html = '<div class="container" ><div class="row-fluid"><div class="span12"><div class = "span12">';
		$html .="<form class='form-search' action='/ask' method='GET'><input type='text' name = 'itemId' class='input-medium search-query' value='{$this->itemId}'> <button type='submit' class='btn'>Search</button></form>";
		$html .="<div class='well'>输入图片右上角产品编码查询价格</div>";

		if(is_array($datas['post']) && !empty($datas['post']))
		{
				$post = $datas['post'];

				$id = trim($post['id']);
				$img = $post['img'];
				$status = $post['onsale'] ? '有货':'无货';
				$myPrice = $post['myPrice'] ;
				$html .= <<<HTML
					<div class="well">
					<table class="table table-bordered">
					<tr>
					<td style='width:40%;'>货号：$id</br>
					状态：$status</br>
					价格：$myPrice</br>
					下载图片
					</td>
					<td style='width:60%;'><img src="$img"></td>
					</tr>
					</table>
					</div><!--/.well -->

HTML;

		}
		$html .='</div></div>';



		$html .='</div></div></div>';
		echo $html;

	}

}
?>
