<?php
include(CONTROLLER."/control.php");
include(MODEL_POST."/PostModel.php");


function postDispatch()
{
	$ac = $GLOBALS['URL_PATH'][0];

	switch ($ac){
		case 'new' :
			$className = 'PostNew';
			include(CONTROLLER_POST."/new.php");
			break;
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
		case 'edit' :
			$className = 'PostEdit';
			include(CONTROLLER_POST."/edit.php");
			break;
		case 'update' :
			$className = 'PostUpdate';
			include(CONTROLLER_POST."/update.php");
			break;
		case 'detail' :
			$className = 'PostDetail';
			include(CONTROLLER_POST."/detail.php");
			break;
		case 'finder' :
			$className = 'PostFinder';
			include(CONTROLLER_POST."/finder.php");
			break;
		case 'photoNew' :
			$className = 'PostPhotoNew';
			include(CONTROLLER_POST."/photoNew.php");
			break;
		case 'deletepost' :
			$className = 'PostDelPost';
			include(CONTROLLER_POST."/delPost.php");
			break;
		case 'tag' :
			$className = 'PostTag';
			include(CONTROLLER_POST."/tag.php");
			break;
		case 'addComment':
			$className = 'PostAddComment';
			include(CONTROLLER_POST."/addComment.php");
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
