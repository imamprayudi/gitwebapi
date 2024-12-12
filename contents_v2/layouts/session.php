<?php
session_start();

if($_POST)
{
    $_SESSION['usr'] = $_POST['usr'];
    $_SESSION['usrsecure'] = $_POST['usrsecure'];
    $_SESSION['usrgroup'] = $_POST['usrgroup'];
    $_SESSION['usrname'] = $_POST['usrname'];
    $_SESSION['usrmail'] = $_POST['usrmail'];
    $data['success'] = true;
    $data['message'] = "LOGIN SUCCESSFULL";
}
  else
  {
    $data['success'] = false;
    $data['message'] = "ACCESS DENIED";
  }

echo json_encode($data);

?>