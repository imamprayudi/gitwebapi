<?php
	/**
	**	Created by Mohamad Yunus
	**	25 April 2016
	**	------------------------
	**	Redirect dari web JEIN WEB
	**	http://112.78.139.51/edi/menuutama.asp
	**/

	session_start();
	$_SESSION['dinew_smyid'] = $_REQUEST['userid']; 
	header('location:jverify.php');
?>