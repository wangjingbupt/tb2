<?php

class PostList extends control{


	public function checkPara(){
		
		$this->page = intval($GLOBALS['URL_PATH'][1]);
		$this->cat = trim($_GET['cat']);
		$this->skey = trim($_GET['skey']);

		return true;

	}

	public function action(){
		$postModel = new PostModel();
		if($this->cat != '')
		{
			$where = array(
				'cat'=>array('$in'=>array($this->cat)),	
		
			);
		}
		if($this->skey !='')
		{
			$arr = explode(' ',$this->skey,2);
			if(count($arr) == 1)
			{
				$where['$or'] = array(
						array('comments' => new MongoRegex("/{$arr[0]}/is")),
						array('title' => new MongoRegex("/{$arr[0]}/is")),
				);
				
			}

			if(count($arr) == 2)
			{
				$where['$or'] = array(
					array('comments' => new MongoRegex("/({$arr[0]}.*?{$arr[1]}|{$arr[1]}.*?{$arr[0]})/")),
						array('title' => new MongoRegex("/({$arr[0]}.*?{$arr[1]}|{$arr[1]}.*?{$arr[0]})/")),
				);
			}

		}

		$datas['post'] = $postModel->getPostList($this->page,$where);
		$postNum = $postModel->getPostCount($where);
		if($postNum > POST_PAGE_NUM * ($this->page+1))
			$datas['hasNext'] = $this->page+1;

		if($this->page > 0)
			$datas['hasPrev'] = $this->page-1;

		$datas['finder'] = $postModel->getFinder();

		$this->format($datas);

	}


	public function includeFiles()
	{

		include(VIEW.'/index.php');

	}
	
	public function format($datas)
	{
		$data['activeHome'] = 'class="active"';
		$data['activePhoto'] = '';
		$data['activeWeibo'] = '';
		$data['script'] = $this->getScript();
		$GLOBALS['DATA'] = $data;
		if($GLOBALS['UA_TYPE'] == 'phone')
		{
			ViewIndex::renderPhone($datas);
		}
		else
		{
			ViewIndex::render($datas);
		}
		
		
		
		//print_r($datas);
	}

	public function getScript()
	{
		$html =<<<HTML
			<script type="text/javascript">
function postdata(num){                              //提交数据函数   
	var cms = $("#comment_"+num).val();
	var itemId = $("#item_"+num).val();
	var x=document.getElementsByName("class_check_"+num);
	var classchcek = ''
	for (var i=0;i<x.length;i++)
	{
		if(x[i].checked)
			classchcek +=x[i].value + ',';
	}
	if(cms && itemId && classchcek)
	{
		$.ajax({ 
		type: "POST", 
		url: "/addComment",  
		data: "cms="+$("#comment_"+num).val()+"&item_id="+$("#item_"+num).val()+"&class="+classchcek, 
		success: function(msg){         
			var dataObj=eval("("+msg+")");
			if(dataObj.code == 'ok')
			{
				document.getElementById("cms_"+num).innerHTML = cms;
			}
			else
			{

			}
		}   
	});
	}
return false;
}   
</script>  
HTML;
		return $html;
		
	}

}

?>
