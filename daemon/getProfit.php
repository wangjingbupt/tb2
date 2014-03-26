<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include('../config/config.php');
include(UTIL.'/Curl.class.php');
include(CONFIG.'/db.conf.php');


function connMongo($dbName = 'blog')
{

	$m = new Mongo(DbConf::$mongoConf);
	$m_db = DbConf::$BDprefix."_".$dbName;
	$db = $m->selectDB($m_db);
	//$db->authenticate(DbConf::$mongoAuth[0],DbConf::$mongoAuth[1] );
	return $db;

}
function getOrders($db)
{
	$c = $db->selectCollection('order');
	$items = $c->find(array());
	return mongoObj2Array($items);

}


function getItems($db)
{
	$c = $db->selectCollection('items');
	$items = $c->find(array('status'=>1));
	return mongoObj2Array($items);

}

function mongoObj2Array($cursor)
{
	$res = array();
	foreach($cursor as $doc)
	{   
		$doc['_id'] = $doc['_id']->__toString();
		$res[] = $doc;
	}   
	return $res;
}

function getItem($db,$id)
{
	$c = $db->selectCollection('items');
	$item = $c->findOne(array('id'=>$id));
	if(is_array($item) && !empty($item))
		return $item;

	return false;

}

$db = connMongo('tb');
$orders = getOrders($db);
foreach($orders as $order)
{
	$time = strtotime($order['date']);
	$dt = date('Y-m',$time);

	foreach($order['items'] as $item)
	{
		$item = json_decode($item,true);
		$itemId = $item['id'];
		if($item['status'] <> '已发货')
			continue;
		$itemInfo = getItem($db,$itemId);
		if(!$itemInfo)
		{
			$profit[$dt]['n-'] +=intval($item['num']);
			continue;
		}
		if(intval($item['price']) == 0 )
			continue;
		$profit[$dt]['n'] +=intval($item['num']);
		$profit[$dt]['c'] += intval($item['price']) * intval($item['num']);
		$profit[$dt]['y'] += intval($itemInfo['myPrice']) * intval($item['num']);
	}
}

$bag = array(

'2014-03-17'=>array(40,10.4,488.85),
'2014-03-12'=>array(49,20.1,940.28),
'2014-03-07'=>array(78,31.1,1454.86),
'2014-03-03'=>array(49,22,1020.89),
'2014-02-22'=>array(58,31,1435.75),
'2014-02-18'=>array(46,19.8,913.24),
'2014-02-13'=>array(43,22,1011.56),
'2014-01-21'=>array(31,24.4,1124.21),
'2014-01-15'=>array(67,59.9,2754.20),
'2014-01-07'=>array(50,31.9,1475.06),
'2013-12-30'=>array(53,34.8,1611.46),
'2013-12-24'=>array(47,34,1569.85),
'2013-12-19'=>array(86,56.8,2624.12),
'2013-12-14'=>array(75,58.3,2695.79),
'2013-12-09'=>array(60,26.8,1239.23),
'2013-12-04'=>array(37,21.8,1005.72),
'2013-11-29'=>array(43,36,1666.95),
'2013-11-25'=>array(44,36.4,1680.82),
'2013-11-19'=>array(42,29.6,1361.01),
'2013-11-16'=>array(54,30.8,1418.48),
'2013-11-13'=>array(62,38.6,1772.53),
'2013-11-08'=>array(40,21.3,984.91),
'2013-11-02'=>array(49,33.5,1540.33),
'2013-10-31'=>array(43,21,967.88),
'2013-10-26'=>array(24,8,367.61),
'2013-10-21'=>array(12,5.8,266.68),
'2013-10-15'=>array(15,4.7,228.55),
);
foreach($bag as $k => $v)
{
	$time = strtotime($k);
	$dt = date('Y-m',$time);
	$profit[$dt]['bn'] +=$v[0];
	$profit[$dt]['w'] +=$v[1];
	$profit[$dt]['bp'] +=$v[2];
	
}

foreach($profit as $k=>$v)
{
	$arg_bp = $v['bp']/$v['bn'];
	$bp = $arg_bp * $v['n'];
	//echo $v['y'].",".$v['c'].",".$bp.",".$v['n']."\n";
	$pf = (($v['y']-$v['c']-$bp)/$v['y'])*100;
	$af = ($v['y']-$v['c']-$bp)/$v['n'];
	$abw = $v['w']/$v['bn'];
	echo $k." ".sprintf('%.2f',$pf)."% {$af} {$abw} {$arg_bp}\n";
}
exit;
$items = getItems($db);
if(is_array($items) && !empty($items))
{
	$finder = array();
	foreach($items as $item)
	{
		$id = $item['id'];
		$newItem = fetchItem($id);
		$item['onsale'] = $newItem['onsale'];
		if(isset($newItem['band']))
		{
			$item['band'] = $newItem['band'];
		}

		if(isset($newItem['price']))
		{
			$item['price'] = $newItem['price'];
		}

		unset($item['_id']);
		$ret = updateItem($db,$item['id'],$item);
	}

}

?>
