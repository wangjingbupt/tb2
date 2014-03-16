<?php
class OrderModel{

	private $_postLimit = POST_PAGE_NUM;
	private $_postDelLimit = 50;

	public function __construct() {
		$this->PostD = new MyMongo('tb');

	}

	public function getPostList($page=0,$where = array())
	{
		$this->PostD->setCollection('order');
		$offset = $page * $this->_postLimit;

		$cursor = $this->PostD->find($where);
		
		$cursor->sort(array('id'=>-1))->skip($offset)->limit($this->_postLimit);
		
		return self::mongoObj2Array($cursor);
	}	
	
	public function getPostCount()
	{
		$this->PostD->setCollection('order');
		$cursor = $this->PostD->find(array());
		$count = intval($cursor->count());

		return $count;
	}

	public function getDetail($id)
	{
		$this->PostD->setCollection('order');
		$doc = $this->PostD->findOne(array('id'=>$id));

		return self::mongoDoc2Array($doc);

	}

	public function mongoObj2Array($cursor)
	{
		$res = array();
		foreach($cursor as $doc)
		{
			if($doc['_id'])
				$doc['_id'] = $doc['_id']->__toString();
			$res[] = $doc;
		}
		return $res;
	}

	public function mongoDoc2Array($doc)
	{
		if($doc['_id'])
			$doc['_id'] = $doc['_id']->__toString();
		return $doc;	
	}
	
	
	
	
}




?>
