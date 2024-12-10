const $ = require('jquery');
const axios = require('axios');


// function toggleLoadingLogin() {
//     $('div.loading').toggleClass('d-none');
// }

function renderMessage(obj = {html : null, classes : '', icons: null}){
    let htmo = '<div class="alert '+obj.classes+' alert-dismissible fade show" role="alert">'
    +'<i class="'+obj.icons+'"></i> '
    +obj.html
    +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
    +'</div>';

    $('div.message').html(htmo);
    console.log('Message Rendering',obj.html)
    return;
}

$(function() { 
    $('div.message').html(null);
    if($('div.loading').hasClass('d-none') == false)
    $('div.loading').addClass('d-none');
    $('#btn_login').attr("disabled",false);
    $('#userid').focus();

    // warning ==> <i class="fa-solid fa-triangle-exclamation"></i>
    // danger ==> <i class="fa-solid fa-ban"></i>
    // success ==> <i class="fa-solid fa-check"></i>


    // login verification
    $('form[name=loginForm]').submit(e => 
    {
        e.preventDefault();
        $('#btn_login').attr("disabled",true);
         $('div.loading').toggleClass('d-none');
         $('div.message').html(null);
        // toggleLoadingLogin();

        axios
          .post("../api/login.php", {
            userid: $("[name=userid]").val(),
            password: $("[name=password]").val()
          })
          .then(({data}) => {
            console.log("LOGIN",data)
            if(data.success)
            {
               window.location.href = "../contents_v2/";
            }
            else{
              renderMessage({
                html: data.message,
                classes: "alert-danger",
                icons: "fa-solid fa-ban"
              });
            }
             
            // const hostname = window.location.hostname;
            // console.log("hostname", window.location.hostname)
            // console.log("path", window.location.pathname)
          })
          .catch((error) => {
            console.log("login catch ",error);
            let res = error.response;
            let data = res.data;
            let msg = data.message;

            msg = msg || "Something went wrong";

            renderMessage({
              html: msg,
              classes: "alert-danger",
              icons: "fa-solid fa-ban"
            });

            $("#password").val("");
            $("#userid").val("");
            $("#userid").focus();
            $("div.loading").addClass("d-none");
            $("#btn_login").attr("disabled", false);
            // toggleLoadingLogin();
          })
          .finally(() => {
            // hide loading
            $("div.loading").addClass("d-none");
            // activate button
            $("#btn_login").attr("disabled", false);

            // toggleLoadingLogin()
          });
        
        return;
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

// $("#btn_login").click(function(){
//     var parameters;
//     $("form#login_form :input").each(function(){
//         this.parameters = $(this);
//     })

//     console.log("form input", parameters)
// });