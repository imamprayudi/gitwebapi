<!DOCTYPE HTML>
<html>
<head>
<link href="../assets/css/jein.css" rel="stylesheet" type="text/css" />

<script src="../assets/js/jquery.js"></script>

<script>
$(document).ready(function()
 {
    $('form[name=loginForm]').submit(function()
     {
       $('#error').hide();
       $.post('jvalidasi.php',{userid: $('[name=userid]').val(),
                             password: $('[name=password]').val()},
             function(data)
             {
               if(data.success)
                 {
                  $('#error').html(data.message).fadeIn(1000);
                  //document.getElementById("cek").innerHTML = "Login oke";
                  window.location.href = 'jmenu.php';
                 }                
                 else
                 {
                  $('#error').html(data.message).fadeIn(1000);
                 // alert("access denied");
                 }            
             },'json');
             return false;     
     });
   
 });

</script>

</head>
<body>

<div id="logo">
<img border="0" src="../assets/gambar/jvclogo.png" alt="JVCKENWOOD" width="419" height="120" />
<!-- <img border="0" src="/gambar/logo.gif" alt="JVCKENWOOD" width="214" height="77" />  -->
</div>

<div class="badan">
  <div class="login">
    LOGIN
    <form id="frmlogin" method='post' action='index.php' name='loginForm'>
      <input type='text' name='userid' placeholder="UserID"/><br />
      <input type='password' name='password' placeholder="Password"/><br />
      <input type='submit' value='Login' />
    </form>
  </div>
</div>

<div id="error">

</div>

</body>
</html> 