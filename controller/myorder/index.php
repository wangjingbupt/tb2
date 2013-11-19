<?php
include(CONTROLLER."/control.php");
include(MODEL_MYORDER."/MyOrderModel.php");


function postDispatch()
{
	$ac = $GLOBALS['URL_PATH'][1];

	switch ($ac){
		case 'edit' :
			$className = 'MyOrderEdit';
			include(CONTROLLER_MYORDER."/edit.php");
			break;
		case 'update' :
			$className = 'MyOrderUpdate';
			include(CONTROLLER_MYORDER."/update.php");
			break;
		case 'detail' :
			$className = 'MyOrderDetail';
			include(CONTROLLER_MYORDER."/detail.php");
			break;
		default: 
			$className = 'MyOrderList';
			include(CONTROLLER_MYORDER."/list.php");
			break;

	}
new $className();
}

postDispatch();

?>