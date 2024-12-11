<?php
	/**
	**	Created by Mohamad Yunus
	**	25 April 2016
	**	------------------------
	**	Redirect dari web DI New
	**	http://112.78.139.52/dinew/menu.php
	**/

	session_start();
	$_SESSION['s_userid'] = $_REQUEST['userid'];
	header('location:std_pack.php');
?>