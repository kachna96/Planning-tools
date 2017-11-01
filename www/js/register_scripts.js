/**
 * Created by kachna96 on 4.12.2014.
 */
$(document).ready(function()
{

    // REGISTER IN Dynamic company name

    $( "input#frm-registerForm-username" ).change(function() {
        var company = '#frm-registerForm-make_company';
        if( !$(company).val() ){
            var username = '#frm-registerForm-username';
            $(company).val( $(this).val()+' společnost' );
        }
    });

    $( $("input#frm-registerForm-username") ).focusout(function() {
        var string = "input#frm-registerForm-username";
        setTimeout(function () {
            if($("span"+string+"_message.error-message").length != 0) {
                $( string ).addClass( "sign_error" );
            }else{
                $( string ).removeClass( "sign_error" );
            }
        }, 10);
    });

    $( $("input#frm-registerForm-password") ).focusout(function() {
        var string = "input#frm-registerForm-password";
        setTimeout(function () {
            if($("span"+string+"_message.error-message").length != 0) {
                $( string ).addClass( "sign_error" );
            }else{
                $( string ).removeClass( "sign_error" );
            }
        }, 10);
    });

    $( $("input#frm-registerForm-passwordVerify") ).focusout(function() {
        setTimeout(function () {
            var string = "input#frm-registerForm-passwordVerify";
            if($("span"+string+"_message.error-message").length != 0) {
                $( string ).addClass( "sign_error" );
            }else{
                $( string ).removeClass( "sign_error" );
            }
        }, 10);
    });

    $( $("input#frm-registerForm-make_company") ).focusout(function() {
        setTimeout(function () {
            var string = "input#frm-registerForm-make_company";
            if($("span"+string+"_message.error-message").length != 0) {
                $( string ).addClass( "sign_error" );
            }else{
                $( string ).removeClass( "sign_error" );
            }
        }, 10);
    });

});