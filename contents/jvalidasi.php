<?php
session_start();
include('koneksi.php');
if($_POST)
{
  $puserid = $_POST['userid'];
  $ppassword = $_POST['password'];
  
  // $rs = $db->Execute("select * from tuser where userid = '" . $puserid . "' and password = '" . $ppassword . "'");
  $rs = $db->Execute("select userid,userpass,usersecure,usergroup,username,
    useremail,useremail1,useremail2 from usertbl where 
    UserId = '" . $puserid . "'" . " and UserPass = '" . $ppassword . "'");
  $sukses = $rs->RecordCount();
  if($sukses > 0)
  {
    // $rs->fields[0]
    $_SESSION['usr'] = $rs->fields[0];
    $_SESSION['usrsecure'] = $rs->fields[2];
    $_SESSION['usrgroup'] = $rs->fields[3];
    $_SESSION['usrname'] = $rs->fields[4];
    $_SESSION['usrmail'] = $rs->fields[5];
    $data['success'] = true;
    $data['message'] = "LOGIN SUCCESSFULL";
    
    /*  input data to log  */
    // $instgl = date("Y-m-d h:i:sa");
    $insuser = $rs->fields[0];
    $namaserver =  $_SERVER['SERVER_NAME'];
    $namaclient =  $_SERVER['REMOTE_ADDR'];
    // $qryins = "insert into log1(userid,waktu) values('" . $insuser . "','" . $instgl . "')";
    $qryins = "insert into log1(userid,waktu,ipserver,ipclient) 
    values('" . $insuser . "',Getdate(),'" . $namaserver . "','" . $namaclient . "')";
    // $qryins = "insert into log1(userid) values('" . $insuser . "')";
    $rsins = $db->Execute($qryins);
    /* end of input data to log */
  
  }
  else
  {
    $data['success'] = false;
    $data['message'] = "ACCESS DENIED";
  }

echo json_encode($data);


}

$rs->Close();
$rsins->Close();
$db->Close();

?>