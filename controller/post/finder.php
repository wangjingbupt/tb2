<?php

class PostFinder extends control{


	public function checkPara(){
		
		$this->date = $GLOBALS['URL_PATH'][1];
		$this->page = intval($GLOBALS['URL_PATH'][2]);

		return true;

	}

	public function action(){
		$postModel = new PostModel();
	
		$datas['post'] = $postModel->getFinderList($this->date,$this->page);

		$datas['finder'] = $postModel->getFinder();
		$postNum = 0;
		foreach($datas['finder'] as $f)
		{
			if($f['date'] == $this->date)
			{
				$postNum = $f['num'];
			}
		}

		if($postNum > POST_PAGE_NUM * ($this->page+1))
			$datas['hasNext'] = $this->page+1;

		if($this->page > 0)
			$datas['hasPrev'] = $this->page-1;
		$datas['date'] = $this->date;
		$this->format($datas);

	}


	public function includeFiles()
	{

		include(VIEW.'/finder.php');

	}
	
	public function format($datas)
	{
		$data['activeHome'] = 'class="active"';
		$data['activePhoto'] = '';
		$data['activeWeibo'] = '';
		$data['script'] = $this->getScript();
		$GLOBALS['DATA'] = $data;
		ViewFinder::render($datas);
		
		
		
		//print_r($datas);
	}
	public function getScript()
	{
		$html =<<<HTML
			<script type="text/javascript">
function postdata(num){                              //提交数据函数   
	var cms = $("#comment_"+num).val();
	var itemId = $("#item_"+num).val();
	if(cms && itemId)
	{
		$.ajax({ 
		type: "POST", 
		url: "/addComment",  
		data: "cms="+$("#comment_"+num).val()+"&item_id="+$("#item_"+num).val(), 
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
