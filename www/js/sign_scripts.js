/**
 * Created by kachna96 on 5.12.2014.
 */

$(document).ready(function()
{

    $( $("input#frm-signInForm-username") ).focusout(function() {
        setTimeout(function () {
            if($("span#frm-signInForm-username_message.error-message").length != 0) {
                $( "input#frm-signInForm-username" ).addClass( "sign_error" );
            }else{
                $( "input#frm-signInForm-username" ).removeClass( "sign_error" );
            }
        }, 10);
    });

    $( $("input#frm-signInForm-password") ).focusout(function() {
        setTimeout(function () {
            if($("span#frm-signInForm-password_message.error-message").length != 0) {
                $( "input#frm-signInForm-password" ).addClass( "sign_error" );
            }else{
                $( "input#frm-signInForm-password" ).removeClass( "sign_error" );
            }
        }, 10);
    });

});
