<?php
class PostModel{

	private $_postLimit = POST_PAGE_NUM;
	private $_postDelLimit = 50;

	public function __construct() {
		$this->PostD = new MyMongo('tb');

	}

	public function getPostList($page=0,$where = array())
	{
		$this->PostD->setCollection('items');
		$offset = $page * $this->_postLimit;

		$where['status']=1;

		$cursor = $this->PostD->find($where);
		
		$cursor->sort(array('createtime'=>-1))->skip($offset)->limit($this->_postLimit);
		
		return self::mongoObj2Array($cursor);
	}	
	
	public function getPostCount($where = array())
	{
		$where['status']=1;
		$this->PostD->setCollection('items');
		$cursor = $this->PostD->find($where);
		$count = intval($cursor->count());

		return $count;
	}

	public function getDelPosts($page=0)
	{
		$this->PostD->setCollection('items');
		$offset = $page * $this->_postDelLimit;

		$cursor = $this->PostD->find(array('status'=>0));
		
		$cursor->sort(array('createtime'=>-1))->skip($offset)->limit($this->_postDelLimit);
		
		return self::mongoObj2Array($cursor);
	}	

	public function recoverPost($pid)
	{
		$this->PostD->setCollection('items');
		$id =new MOngoId($pid); 

		$doc = $this->PostD->findOne(array('_id'=>$id));
		$doc['status'] =1;
		$this->PostD->update(array('_id' => $doc['_id']), $doc);
		
		return self::mongoDoc2Array($doc);
	}	

	public function delPost($pid)
	{
		$this->PostD->setCollection('items');
		$id =new MOngoId($pid); 

		$doc = $this->PostD->findOne(array('_id'=>$id));
		$doc['status'] =0;
		$this->PostD->update(array('_id' => $doc['_id']), $doc);
		
		return self::mongoDoc2Array($doc);
	}	

	public function getFinderList($date,$page=0)
	{
		if($date == '')
		{
			$date = date('Y-m-d');
		}
		$s_time = strtotime($date);
		$e_time = $s_time+86400;

		$this->PostD->setCollection('items');
		$offset = $page * $this->_postLimit;

		$cursor = $this->PostD->find(array('status'=>1,'createtime'=>array('$gte'=>$s_time,'$lt'=>$e_time)));
		
		$cursor->sort(array('createtime'=>-1))->skip($offset)->limit($this->_postLimit);
		
		return self::mongoObj2Array($cursor);
	}	


	public function getFinder()
	{
		$this->PostD->setCollection('finder');
		$cursor = $this->PostD->find(array('num'=>array('$gt'=>0)));
		$cursor->sort(array('date'=>-1));

		return self::mongoObj2Array($cursor);

	}

	public function getTags()
	{
		$this->PostD->setCollection('tags');
		$cursor = $this->PostD->find(array());

		return self::mongoObj2Array($cursor);

	}

	public function getTagPostCount($tag)
	{
		$this->PostD->setCollection('tags');
		$doc = $this->PostD->findOne(array('name'=>$tag));
		$num = $doc['num'];

		return intval($num);  
	}

	public function getDetail($blog_id,$flag = 1)
	{
		$this->PostD->setCollection('post');
		$id = new MOngoId($blog_id);
		if($flag == 1)
			$doc = $this->PostD->findOne(array('_id'=>$id,'status'=>1));
		else
			$doc = $this->PostD->findOne(array('_id'=>$id));

		return self::mongoDoc2Array($doc);

	}

	public function incFinderNum($pubtime)
	{
		$this->PostD->setCollection('finder');
		$date = date("Y-m-d",$pubtime);
	
		$sign = $this->PostD->update(array('date'=>$date), array('$inc' => array("num" => 1)),array('upsert'=>true));

		return $sign;

	}

	public function decFinderNum($pubtime)
	{
		$this->PostD->setCollection('finder');
		$date = date("Y-m-d",$pubtime);

	
		$sign = $this->PostD->update(array('date'=>$date), array('$inc' => array("num" =>-1)));

		return $sign;

	}

	public function incCmsNum($blog_id)
	{
		$this->PostD->setCollection('post');
		$id = new MOngoId($blog_id);

		$sign = $this->PostD->update(array('_id'=>$id,'status'=>1), array('$inc' => array("comment_num" => 1)));

		return $sign;

	}

	public function decCmsNum($blog_id)
	{
		$this->PostD->setCollection('post');
		$id = new MOngoId($blog_id);

		$sign = $this->PostD->update(array('_id'=>$id,'status'=>1), array('$inc' => array("comment_num" => -1)));

		return $sign;

	}

	public function editPostComment($id,$cms,$class=array())
	{
		$this->PostD->setCollection('items');
		
		$doc = $this->PostD->findOne(array('id'=>$id));
		if(!$doc)
		{
			return false;
		}
		$doc['comments'] = $cms;
		$doc['cat'] = $class;


		$sign = $this->PostD->update(array('id'=>$id), $doc);
		if($sign)
			return self::mongoDoc2Array($doc);

		return false;



	}

	public function newPost($item=array())
	{
		$this->PostD->setCollection('items');
		if(empty($item))
			return false;
		$oItem = $this->PostD->findOne(array('id'=>$item['id']));
		if(is_array($oItem) && !empty($oItem))
		{
			$item['status'] = 1;
			$item['comments'] = $oItem['comments'];
			$item['cat'] = $oItem['cat'];
			$item['createtime'] = $oItem['createtime'];
			$id = $item['id'];
			
			$sign = $this->PostD->update(array('id'=>$id), $item);
			if($sign)
			{
				$item['_id'] = $oItem['_id'];
				unset($item['createtime']);
			}
		}
		else
		{
			$item['status'] = 1;
			$item['createtime'] = time();
			$sign = $this->PostD->insert($item);
		}
		if(isset($item['_id']))
			return self::mongoDoc2Array($item);

		return false;
	}	

	public function mongoObj2Array($cursor)
	{
		$res = array();
		foreach($cursor as $doc)
		{
			$doc['_id'] = $doc['_id']->__toString();
			$res[] = $doc;
		}
		return $res;
	}

	public function mongoDoc2Array($doc)
	{
		$doc['_id'] = $doc['_id']->__toString();
		return $doc;	
	}
	
	
	
	
}




?>
