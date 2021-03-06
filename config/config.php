<?php

define('ROOT',dirname(dirname(__FILE__)));
define('CONTROLLER', ROOT."/controller");
define('CONFIG', ROOT."/config");
define('UTIL', ROOT."/util");
define('DATA', ROOT."/data");
define('VIEW', ROOT."/view");
define('MODEL', ROOT."/model");
define('WEIBO', ROOT."/weibo");

define('MODEL_POST', MODEL."/post");
define('MODEL_COMMENT', MODEL."/comment");
define('MODEL_PHOTO', MODEL."/photo");
define('MODEL_WEIBO', MODEL."/weibo");
define('MODEL_DUSTBIN', MODEL."/dustbin");
define('MODEL_LOGIN', MODEL."/login");
define('MODEL_ORDER', MODEL."/order");
define('MODEL_MYORDER', MODEL."/myorder");
define('MODEL_SCMORDER', MODEL."/scmOrder");

define('CONTROLLER_POST', CONTROLLER."/post");
define('CONTROLLER_MYORDER', CONTROLLER."/myorder");
define('CONTROLLER_ORDER', CONTROLLER."/order");
define('CONTROLLER_COMMENT', CONTROLLER."/comment");
define('CONTROLLER_PHOTO', CONTROLLER."/photo");
define('CONTROLLER_WEIBO', CONTROLLER."/weibo");
define('CONTROLLER_CALLBACK', CONTROLLER."/callback");
define('CONTROLLER_DUSTBIN', CONTROLLER."/dustbin");
define('CONTROLLER_LOGIN', CONTROLLER."/login");
define('CONTROLLER_ABOUT', CONTROLLER."/about");

define('VIEW_POST', VIEW."/post");
define('VIEW_COMMENT', VIEW."/comment");
define('VIEW_PHOTO', VIEW."/photo");
define('VIEW_WEIBO', VIEW."/weibo");
define('VIEW_DUSTBIN', VIEW."/dustbin");

//首页每页博文数
if($GLOBALS['UA_TYPE'] == 'phone')
{
	define('POST_PAGE_NUM', 50);
}
else
{
define('POST_PAGE_NUM', 100);
}



define('UPLOAD_TMP_DIR', "/tmp/img/");
define('REDIRECT_URL', "http://sleepwalker.pro/");

define('IMG_PATH',ROOT.'/../images/myblog/');
define('IMG_URL','http://img.sleepwalker.pro/');

define( "WB_AKEY" , '628803579' );
define( "WB_SKEY" , '53cc7c93724ae3fa4a39391f0d76d78c' );
define( "WB_CALLBACK_URL" , 'http://lxsnow.me/callback/weibo' );
define( "RR_CALLBACK_URL" , 'http://lxsnow.me/callback/renren' );
define( "IG_CALLBACK_URL" , 'http://lxsnow.me/callback/instagram' );

define( "RR_AKEY" , '4e510ea83299443a8d4f520d46914b16' );
define( "RR_SKEY" , '97fb6db5037d4ff7bad680f895eee712' );
define( "IG_AKEY" , 'd191c0133cfc44c39642bb29b59dfac2' );
define( "IG_SKEY" , '2ccc9565adef48608dc7eaebc33a4fd1' );
define( "LOGIN_TOKEN" , md5(date('Y-m').'wj0017'));
define( "LOG_PATH" , '/tmp/log/');
?>
