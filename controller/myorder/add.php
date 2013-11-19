<?php

class PostAdd extends control{


	public function checkPara(){
		//http://tb.sleepwalker.pro/add.php?title=Frap-L%20%E5%8D%8A%E8%A2%96%E5%9C%86%E9%A2%86%E5%A5%B3%E5%A3%ABT%E6%81%A4%E5%9D%87%E7%A0%81%E4%B8%8D%E5%90%AB%E5%85%B6%E5%AE%83%E2%82%A914000&img=http%3A%2F%2Fdimage.yissimg.com%2Fitem%2F2013%2F1107%2F20%2FIMG-0927.jpg!tall.jpg&price=80.9&brand=%3Ca%20href=%22http://dongdamen.yiss.com/places/2061-Frap-L%22%20target=%22_blank%22%3EFrap-L%3C/a%3E&url=http%3A%2F%2Fdongdamen.yiss.com%2Fstyles%2F1936862.html&myPrice=299

		$this->title = $_GET['title'];
		$this->img = $_GET['img']; 
		$this->price = $_GET['price'];
		$this->brand = $_GET['brand'];
		$this->url = $_GET['url'];
		$this->myPrice = $_GET['myPrice'];
		
		if($this->url == '' || $this->title == '' || $this->img =='' || $this->price=='' || $this->brand == '' || $this->myPrice == '' )
			return false;
		$this->onsale = '有货';

		return true;

	}

	public function action(){
		
		
		$postModel = new PostModel();
		preg_match('/styles\/(\d+)\./',$this->url,$m);
		$this->id = $m[1];
		$item = array(
			'title'=>$this->title,
			'img'=>$this->img,
			'price'=>$this->price,
			'brand'=>$this->brand,
			'url'=>$this->url,
			'id'=>$this->id,
			'myPrice'=>$this->myPrice,
			'onsale'=>$this->onsale,

		);

		$data = $postModel->newPost($item);
		
		if($data['createtime'])
		{
			$postModel->incFinderNum($data['createtime']);
		}

	}


	public function includeFiles()
	{


	}

}

?>
