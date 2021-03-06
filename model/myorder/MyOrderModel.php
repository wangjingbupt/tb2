<?php
class MyOrderModel{

	private $_postLimit = POST_PAGE_NUM;
	private $_postDelLimit = 50;

	public function __construct() {
		$this->PostD = new MyMongo('tb');

	}

	public function getPostList($page=0,$w=array())
	{
		$this->PostD->setCollection('myorder');
		$offset = $page * $this->_postLimit;

		$cursor = $this->PostD->find($w);
		//$cursor = $this->PostD->find(array("status" => new MongoRegex("/(已支付|已发货)/")));
		
		$cursor->sort(array('createtime'=>-1))->skip($offset)->limit($this->_postLimit);
		
		return self::mongoObj2Array($cursor);
	}	
	
	public function getPostCount($w=array())
	{
		$this->PostD->setCollection('myorder');
		$cursor = $this->PostD->find($w);
		$count = intval($cursor->count());

		return $count;
	}

	public function delPost($pid)
	{
		$this->PostD->setCollection('myorder');
		$id =new MOngoId($pid); 

		$doc = $this->PostD->findOne(array('_id'=>$id));
		$doc['status'] =0;
		$this->PostD->update(array('_id' => $doc['_id']), $doc);
		
		return self::mongoDoc2Array($doc);
	}	

	public function getMyOrder($id)
	{
		$this->PostD->setCollection('myorder');
		$id = new MongoId($id);
		$doc = $this->PostD->findOne(array('_id'=>$id));

		return self::mongoDoc2Array($doc);

	}

	public function getCustomerByPhone($phone_no)
	{
		$this->PostD->setCollection('customer');
		$id = new MongoId($id);
		$cursor = $this->PostD->find(array('phone'=>$phone_no));

		return self::mongoObj2Array($cursor);

	}

	public function addAddress($doc)
	{
		$this->PostD->setCollection('customer');
	
		
		$doc['status'] = 1;
		$sign = $this->PostD->insert($doc);

		if($sign)
			return self::mongoDoc2Array($doc);

		return false;
	}

	public function updateDdmOrder($id,$ddmOrderId)
	{
		
		$this->PostD->setCollection('myorder');
		$_id =new MOngoId($id); 
		$doc = $this->PostD->findOne(array('_id'=>$_id));
		if(!$doc)
		{
			return false;
		}
		$doc['ddmOrder'] =array($ddmOrderId);

		$sign = $this->PostD->update(array('_id'=>$_id), $doc);
		if($sign)
			return self::mongoDoc2Array($doc);

		return false;

	}

	public function editPost($doc)
	{
		$this->PostD->setCollection('myorder');
	
		if(!isset($doc['status']))
			$doc['status'] = 1;
		
		if($doc['_id'])
		{
			$id = new MongoId($doc['_id']);
			$doc['_id'] = $id;
			$sign = $this->PostD->update(array('_id'=>$id), $doc);
		}
		else
		{
			$doc['status'] = 1;
			$sign = $this->PostD->insert($doc);
		}

		if($sign)
			return self::mongoDoc2Array($doc);

		return false;
	}

	public function mongoObj2Array($cursor)
	{
		$res = array();
		foreach($cursor as $doc)
		{
			if(isset($doc['_id']))
				$doc['_id'] = $doc['_id']->__toString();
			$res[] = $doc;
		}
		return $res;
	}

	public function mongoDoc2Array($doc)
	{
		if(isset($doc['_id']))
		{
			$doc['_id'] = $doc['_id']->__toString();
		}
		return $doc;	
	}
	
	
	
	
}




?>
