<?php
include(CONTROLLER."/control.php");
include(MODEL_ORDER."/OrderModel.php");


function postDispatch()
{
	$ac = isset($GLOBALS['URL_PATH'][1]) ? $GLOBALS['URL_PATH'][1]:'';

	switch ($ac){
		case 'booking':
			$className = 'PostBooking';
			include(CONTROLLER_ORDER."/booking.php");
			break;
		case 'address':
			$className = 'PostAddress';
			include(CONTROLLER_ORDER."/address.php");
			break;
		default:
			$className = 'PostList';
			include(CONTROLLER_ORDER."/list.php");
			break;

	}
new $className();
}

postDispatch();

?>
