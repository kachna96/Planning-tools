/**
 * Created by kachna96 on 5.12.2014.
 */

$(document).ready(function()
{
    var Months = {
        JAN: 'Leden',
        FEB: 'Únor',
        MAR: 'Březen',
        APR: 'Duben',
        MAY: 'Květen',
        JUN: 'Červen',
        JUL: 'Červenec',
        AUG: 'Srpen',
        SEP: 'Září',
        OCT: 'Říjen',
        NOV: 'Listopad',
        DEC: 'Prosinec'
    };

    var Days = {
        MON: 'Ne',
        TUE: 'Po',
        WEN: 'Út',
        THU: 'St',
        FRI: 'Čt',
        SUT: 'Pá',
        SUN: 'So'
    };

    // DateTime picker translation

    (function($)
    {
        $.timepicker.regional['cs'] = {
            timeOnlyTitle: 'Vyberte čas',
            timeText: 'Čas',
            hourText: 'Hodiny',
            minuteText: 'Minuty',
            monthNamesShort: [Months.JAN, Months.FEB, Months.MAR, Months.APR, Months.MAY, Months.JUN, Months.JUL, Months.AUG,
                Months.SEP, Months.OCT, Months.NOV, Months.DEC],
            dayNamesMin: [Days.MON, Days.TUE, Days.WEN, Days.THU, Days.FRI, Days.SUT, Days.SUN],
            currentText: 'Nyní',
            closeText: 'Zavřít',
            ampm: false
        };
        $.timepicker.setDefaults($.timepicker.regional['cs']);
    })(jQuery);

    // SETTINGS:SET DatePicker from

    $('#frm-addCompanyVacationForm-date_from').datepicker(
        {
            minDate: 0,
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd.mm.yy',
            yearRange: '2010:2020',
            firstDay: 1,
            onSelect: function(selected) {
                $("#frm-addCompanyVacationForm-date_to").datepicker("option","minDate", selected)
            }
        });

    // SETTINGS:SET DatePicker to

    $('#frm-addCompanyVacationForm-date_to').datepicker(
        {
            minDate: 0,
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd.mm.yy',
            yearRange: '2010:2020',
            firstDay: 1,
            onSelect: function(selected) {
                $("#frm-addCompanyVacationForm-date_from").datepicker("option","maxDate", selected)
            }
        });

    // SETTINGS:SET DatePicker translation

    (function($)
    {
        $.datepicker.regional['cs'] = {
            monthNamesShort: [Months.JAN, Months.FEB, Months.MAR, Months.APR, Months.MAY, Months.JUN, Months.JUL, Months.AUG,
                Months.SEP, Months.OCT, Months.NOV, Months.DEC],
            dayNamesMin: [Days.MON, Days.TUE, Days.WEN, Days.THU, Days.FRI, Days.SUT, Days.SUN]
        };
        $.datepicker.setDefaults($.datepicker.regional['cs']);
    })(jQuery);

    $( $("input#frm-addUserForm-username") ).focusout(function() {
        var string = "input#frm-addUserForm-username";
        setTimeout(function () {
            if($("span"+string+"_message.error-message").length == 0) {
                $( string ).addClass( "sign_pass" );
            }
        }, 10);
    });

    $( $("input#frm-addUserForm-password") ).focusout(function() {
        var string = "input#frm-addUserForm-password";
        setTimeout(function () {
            if($("span"+string+"_message.error-message").length == 0) {
                $( string ).addClass( "sign_pass" );
            }
        }, 10);
    });

    $( $("input#frm-addUserForm-passwordVerify") ).focusout(function() {
        var string = "input#frm-addUserForm-passwordVerify";
        setTimeout(function () {
            if($("span"+string+"_message.error-message").length == 0) {
                $( string ).addClass( "sign_pass" );
            }
        }, 10);
    });

    $( $("input#frm-renameCompanyForm-com_name") ).focusout(function() {
        var string = "input#frm-renameCompanyForm-com_name";
        setTimeout(function () {
            if($("span"+string+"_message.error-message").length == 0) {
                $( string ).addClass( "sign_pass" );
            }
        }, 10);
    });

    $( $("input#frm-changeUserPasswordForm-new_passw") ).focusout(function() {
        var string = "input#frm-changeUserPasswordForm-new_passw";
        setTimeout(function () {
            if($("span"+string+"_message.error-message").length == 0) {
                $( string ).addClass( "sign_pass" );
            }
        }, 10);
    });

    $( $("input#frm-changeUserPasswordForm-passwordVerify") ).focusout(function() {
        var string = "input#frm-changeUserPasswordForm-passwordVerify";
        setTimeout(function () {
            if($("span"+string+"_message.error-message").length == 0) {
                $( string ).addClass( "sign_pass" );
            }
        }, 10);
    });

    var menu = $('#flmenu'),
        pos = menu.offset();
/* NUFUNGUJE
    $(window).scroll(function(){
        if($(this).scrollTop() > pos.top+menu.height() && menu.hasClass('menudefault')){
            menu.fadeOut('fast', function(){
                $(this).removeClass('menudefault').addClass('menufixed').fadeIn('fast');
            });
        } else if($(this).scrollTop() <= pos.top && menu.hasClass('menufixed')){
            menu.fadeOut('fast', function(){
                $(this).removeClass('menufixed').addClass('menudefault').fadeIn('fast');
            });
        }
    });
*/

    $( "#frm-addAdminForm-users" ).selectmenu().selectmenu( "menuWidget" ).addClass( "overflow" );
    $( "#frm-changeUserPasswordForm-users" ).selectmenu().selectmenu( "menuWidget" ).addClass( "overflow" );
    $( "#frm-changeUsersWorkHoursForm-start" ).selectmenu().selectmenu( "menuWidget" ).addClass( "overflow" );
    $( "#frm-changeUsersWorkHoursForm-end" ).selectmenu().selectmenu( "menuWidget" ).addClass( "overflow" );
    $( "#frm-roleForm-users" ).selectmenu().selectmenu( "menuWidget" ).addClass( "overflow" );
    $( "#frm-deleteUserAccountForm-users" ).selectmenu().selectmenu( "menuWidget" ).addClass( "overflow" );


});