<?php
session_start();

  unset($_SESSION['usr']);
  unset($_SESSION['usrsecure']);
  unset($_SESSION['usrgroup']);
  unset($_SESSION['usrname']);
  unset($_SESSION['usrmail']);

?>
<script>
  localStorage.removeItem('poc_auth');
 window.location.href = '../index.html';
</script>