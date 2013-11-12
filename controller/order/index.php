<?php
include(CONTROLLER."/control.php");
include(MODEL_ORDER."/OrderModel.php");


function postDispatch()
{
	$ac = $GLOBALS['URL_PATH'][1];

	switch ($ac){
		case 'new' :
			$className = 'PostNew';
			include(CONTROLLER_ORDER."/new.php");
			break;
		case 'add' :
			$className = 'PostAdd';
			include(CONTROLLER_ORDER."/add.php");
			break;
		case 'edit' :
			$className = 'PostEdit';
			include(CONTROLLER_ORDER."/edit.php");
			break;
		case 'update' :
			$className = 'PostUpdate';
			include(CONTROLLER_ORDER."/update.php");
			break;
		case 'detail' :
			$className = 'PostDetail';
			include(CONTROLLER_ORDER."/detail.php");
			break;
		case 'finder' :
			$className = 'PostFinder';
			include(CONTROLLER_ORDER."/finder.php");
			break;
		case 'photoNew' :
			$className = 'PostPhotoNew';
			include(CONTROLLER_ORDER."/photoNew.php");
			break;
		case 'deletepost' :
			$className = 'PostDelPost';
			include(CONTROLLER_ORDER."/delPost.php");
			break;
		case 'tag' :
			$className = 'PostTag';
			include(CONTROLLER_ORDER."/tag.php");
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
