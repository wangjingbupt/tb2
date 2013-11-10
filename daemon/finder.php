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

function insertFinder($db,$item)
{
	$c = $db->selectCollection('finder');
	$sign = $c->insert($item);  
	return $sign;
}

$db = connMongo('tb');
$items = getItems($db);
if(is_array($items) && !empty($items))
{
	$finder = array();
	foreach($items as $item)
	{
		$date = date('Y-m-d',$item['createtime']);
		$finder[$date] +=1;
	}

	if(!empty($finder))
	{	
		foreach($finder as $d => $v)
		{
			$doc = array(
				'date'=>$d,
				'num'=>$v,
			);
			$ret = insertFinder($db,$doc);
		}
	}
}

?>
