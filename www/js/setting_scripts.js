/**
 * Created by kachna96 on 4.12.2014.
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

    $('#frm-vacationForm-date_from').datepicker(
        {
            minDate: 0,
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd.mm.yy',
            yearRange: '2010:2020',
            firstDay: 1,
            onSelect: function(selected) {
                $("#frm-vacationForm-date_to").datepicker("option","minDate", selected)
            }
        });

    // SETTINGS:SET DatePicker to

    $('#frm-vacationForm-date_to').datepicker(
        {
            minDate: 0,
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd.mm.yy',
            yearRange: '2010:2020',
            firstDay: 1,
            onSelect: function(selected) {
                $("#frm-vacationForm-date_from").datepicker("option","maxDate", selected)
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

    // SETTINGS:SET CUSTOM radio option

    $( ".select_holidays" ).on( "selectmenuchange", function( event, ui ) {
        var count = $( "select").length;
        var frm = "#frm-addPublicHolidayForm-";
        var count_zeros = 0;
        var count_ones = 0;
        for( count; count > 0; count-- )
        {
            if ($(frm+count).val() == 0)
                count_zeros++;
            else
                count_ones++;
        }
        if(count_zeros != 0 && count_ones != 0)
            $('#frm-addPublicHolidayForm-set-c').prop('checked', true);
    } );

    // SETTINGS:SET PUBLIC HOLIDAYS: Change all selects by onclick on radio button

    $( ".set_change").change(function(){
        var value = ($('input[name=set]:checked', '#frm-addPublicHolidayForm').val());
        var count = $( "select").length;
        var frm = "#frm-addPublicHolidayForm-";
        if(value == "t") {
            for( count; count > 0; count-- )
            {
                $( frm+count ).val("0" );
                $( frm+count ).selectmenu( "refresh" );
            }
        }
        if(value == "f") {
            for( count; count > 0; count-- )
            {
                $( frm+count ).val("1" );
                $( frm+count ).selectmenu( "refresh" );
            }
        }
    });

    // SETTINGS:SET Change tasks warning
    $( ".days").change(function(){
        var warning = ".weekend_warning";
        if(this.checked) {
            $( warning ).slideDown( "slow" );
        }else {
            $( warning ).slideUp( "slow" );
        }
    });

    // VALIDATION PASSW CHANGE

    $( $("input#frm-changePasswordForm-old_passw") ).focusout(function() {
        var string = "input#frm-changePasswordForm-old_passw";
        setTimeout(function () {
            if($("span"+string+"_message.error-message").length != 0) {
                $( string ).addClass( "sign_error" );
            }else{
                $( string ).removeClass( "sign_error" );
            }
        }, 10);
    });

    $( $("input#frm-changePasswordForm-new_passw") ).focusout(function() {
        var string = "input#frm-changePasswordForm-new_passw";
        setTimeout(function () {
            if($("span"+string+"_message.error-message").length != 0) {
                $( string ).addClass( "sign_error" );
            }else{
                $( string ).removeClass( "sign_error" );
            }
        }, 10);
    });

    $( $("input#frm-changePasswordForm-passwordVerify") ).focusout(function() {
        setTimeout(function () {
            var string = "input#frm-changePasswordForm-passwordVerify";
            if($("span"+string+"_message.error-message").length != 0) {
                $( string ).addClass( "sign_error" );
            }else{
                $( string ).removeClass( "sign_error" );
            }
        }, 10);
    });

    var menu = $('#flmenu'),
        pos = menu.offset();
/* NEFUNGUJE
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
    $( "#frm-changeWorkHoursForm-start" ).selectmenu().selectmenu( "menuWidget" ).addClass( "overflow" );
    $( "#frm-changeWorkHoursForm-end" ).selectmenu().selectmenu( "menuWidget" ).addClass( "overflow" );
    var pH = "#frm-addPublicHolidayForm-";
    for(var i = 1; i <= 12; i++){
        $( pH+i ).selectmenu();
    }

});