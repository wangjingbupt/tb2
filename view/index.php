<?php
include(VIEW.'/post.php');
class ViewIndex {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');

		$html = '<div class="container"><div class="row-fluid"><div class="span10"><div class = "span12">';
		$html .='<div><ul class="pager">';
		if(isset($datas['hasPrev']))
		{
			$html .='<li class="previous"><a href="/page/'.intval($datas['hasPrev']).'">Prev</a></li>';
		}
		if(isset($datas['hasNext']))
		{
			$html .='<li class="next"><a href="/page/'.intval($datas['hasNext']).'">Next</a></li>';
		}
		$html .='</ul></div>';

		if(is_array($datas['post']) && !empty($datas['post']))
		{
			foreach($datas['post'] as $post)
			{
				if(date('Y',$post['createtime']) == date('Y'))
					$post['pubtime'] = date("m-d H:i",$post['createtime']);
				else
					$post['pubtime'] = date("Y-m-d H:i",$post['createtime']);


				$html .= ViewPost::post($post);
			}
		}
		$html .='<div><ul class="pager">';
		if(isset($datas['hasPrev']))
		{
			$html .='<li class="previous"><a href="/page/'.intval($datas['hasPrev']).'">Prev</a></li>';
		}
		if(isset($datas['hasNext']))
		{
			$html .='<li class="next"><a href="/page/'.intval($datas['hasNext']).'">Next</a></li>';
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


}
?>
