<?php
include(CONTROLLER."/control.php");
include(MODEL_POST."/PostModel.php");


function postDispatch()
{
	$ac = $GLOBALS['URL_PATH'][0];

	switch ($ac){
		case 'add' :
			$className = 'PostAdd';
			include(CONTROLLER_POST."/add.php");
			break;
		case 'data' :
			$className = 'PostData';
			include(CONTROLLER_POST."/data.php");
			break;
		case 'ask' :
			$className = 'PostAsk';
			include(CONTROLLER_POST."/ask.php");
			break;
		case 'finder' :
			$className = 'PostFinder';
			include(CONTROLLER_POST."/finder.php");
			break;
		case 'deletepost' :
			$className = 'PostDelPost';
			include(CONTROLLER_POST."/delPost.php");
			break;
		case 'addComment':
			$className = 'PostAddComment';
			include(CONTROLLER_POST."/addComment.php");
			break;
		case 'booking':
			$className = 'PostBooking';
			include(CONTROLLER_POST."/booking.php");
			break;
		case 'bookingdel':
			$className = 'PostBookingDel';
			include(CONTROLLER_POST."/bookingdel.php");
			break;
		case 'cart':
			$className = 'PostCart';
			include(CONTROLLER_POST."/cart.php");
			break;
		default: 
			$className = 'PostList';
			include(CONTROLLER_POST."/list.php");
			break;

	}
new $className();
}

postDispatch();

?>
