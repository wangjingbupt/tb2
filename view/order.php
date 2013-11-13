<?php
include(VIEW.'/post.php');
class ViewIndex {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');

		$html = '<div class="container"><div class="row-fluid"><div class="span12"><div class = "span12">';
		$html .='<div><ul class="pager">';
		if(isset($datas['hasPrev']))
		{
			$html .='<li class="previous"><a href="/order/page/'.intval($datas['hasPrev']).'">Prev</a></li>';
		}
		if(isset($datas['hasNext']))
		{
			$html .='<li class="next"><a href="/order/page/'.intval($datas['hasNext']).'">Next</a></li>';
		}
		$html .='</ul></div>';

		if(is_array($datas['post']) && !empty($datas['post']))
		{
			foreach($datas['post'] as $post)
			{
				$id = trim($post['id']);
				$url = $post['url'];
				$pubtime = $post['date'];
				$status = $post['status'];
				$_id = $post['_id'];
				$items = $post['items'];
				foreach($items as $item)
				{
					$item = json_decode($item,true);

					if($item['status'] == '已取消')
						$bg = 'background-color:#c0392b;';
					else if($item['status'] == '已发货')
					$bg = 'background-color:#16a085;';
					else
						$bg = '';

					$itemImg = $item['img'];
					$itemUrl = $item['url'];
					$itemStatus = $item['status'];
					$itemNum = $item['num'];

					$html .= <<<HTML
						<div class="well">
						<table class="table table-bordered" >
						<tr style='$bg'>
							<td style='width:5%;'><img src="$itemImg"></td>
							<td style='width:8%;'>$itemStatus</td>
							<td style='width:4%;'><a href="$itemUrl" target='_blank'>宝贝链接</a></td>
							<td rowspan=1 style='width:4%;'><a href="$url" target='_blank'>$id</a></td>
							<td rowspan=1 style='width:4%;'>$pubtime</td>
							<td rowspan=1 style='width:4%;'>$status</td>
							<td rowspan=1 style='width:4%;'>$itemNum 件</td>
						</tr>
						</table>
						</div>
HTML;
				}
			}
		}
		$html .='<div><ul class="pager">';
		if(isset($datas['hasPrev']))
		{
			$html .='<li class="previous"><a href="/order/page/'.intval($datas['hasPrev']).'">Prev</a></li>';
		}
		if(isset($datas['hasNext']))
		{
			$html .='<li class="next"><a href="/order/page/'.intval($datas['hasNext']).'">Next</a></li>';
		}
		$html .='</ul></div>';


		$html .='</div></div></div>';
		echo $html;
		//include(VIEW.'/container.php');
			
		include(VIEW.'/footer.php');
	}


}
?>