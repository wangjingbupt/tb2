<?php
class ScmOrderModel{

	public function __construct() {
		$this->PostD = new MyMongo('tb');

	}

	public function getPostList($status = 1)
	{
		$this->PostD->setCollection('scmOrder');
		$cursor = $this->PostD->find(array('status'=>$status));
		//$cursor = $this->PostD->find(array("status" => new MongoRegex("/(已支付|已发货)/")));
		
		$cursor->sort(array('id'=>-1));
		
		return self::mongoObj2Array($cursor);
	}	
	
	public function getPostCount()
	{
		$this->PostD->setCollection('scmOrder');
		$cursor = $this->PostD->find(array());
		$count = intval($cursor->count());

		return $count;
	}

	public function getDetail($id)
	{
		$this->PostD->setCollection('scmOrder');
		$doc = $this->PostD->findOne(array('id'=>$id));

		return self::mongoDoc2Array($doc);

	}

	public function addOrder($order)
	{
		$this->PostD->setCollection('scmOrder');
		
		$order['status'] = 1;
		$sign = $this->PostD->insert($order);

		if($sign)
			return self::mongoDoc2Array($order);

		return false;
	
	}

	public function updatePurchase($id,$ddmOrderId)
	{
		$this->PostD->setCollection('scmOrder');
		$_id =new MOngoId($id); 
		$doc = $this->PostD->findOne(array('_id'=>$_id));
		if(!$doc)
		{
			return false;
		}
		$doc['ddmOrder'] =array($ddmOrderId);
		$doc['status'] = 2;

		$sign = $this->PostD->update(array('_id'=>$_id), $doc);
		if($sign)
			return self::mongoDoc2Array($doc);

		return false;

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
