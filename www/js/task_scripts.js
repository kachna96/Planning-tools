/**
 * Created by kachna96 on 4.12.2014.
 */
$(document).ready(function()
{
    var end = $("input#frm-addTaskForm-end").val();
    var end_hours_default = end.substring(11,13);
    var end_minutes_default = end.substring(14,16);
    var start = $("input#frm-addTaskForm-start").val();
    var start_hours_default = start.substring(11,13);
    var start_minutes_default = start.substring(14,16);
    var weekend = '#frm-addTaskForm-checks-weekends';
    var saturday = '#frm-addTaskForm-checks-saturday';
    var sunday = '#frm-addTaskForm-checks-sunday';
    //Public holidays date
    var pH= $(".hidden").map(function() {
        var pHString = $(this).val();
        return pHString.substring(5,10);
    }).get();
    var d_default = $("input#frm-addTaskForm-duration").val();
    var d_default_array = d_default.split(':');
    var d_default_hours = d_default_array[0];
    var d_default_minutes = d_default_array[1];
    if((d_default_hours < 10) && (d_default_hours.length == 1)){
        d_default_hours = "0"+d_default_hours;
    }
    if((d_default_minutes < 10) && (d_default_minutes.length == 1)){
        d_default_minutes = "0"+d_default_minutes;
    }
    $("#frm-addTaskForm-duration").val(d_default_hours+":"+d_default_minutes);

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
        MON: 'Po',
        TUE: 'Út',
        WEN: 'St',
        THU: 'Čt',
        FRI: 'Pá',
        SUT: 'So',
        SUN: 'Ne'
    };

    // TASKS:DEFAULT DateTime picker JavaScript from

    if(d_default == "00:00") {
        $('#frm-addTaskForm-start').datetimepicker(
        {
            minDate: -1,
            minTime: start_hours_default+":00",
            maxTime: end_hours_default+":00",
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd.mm.yy',
            yearRange: '2010:2020',
            timeOnlyTitle: 'Vyberte čas',
            timeText: 'Čas',
            hourText: 'Hodiny',
            minuteText: 'Minuty',
            monthNamesShort: [Months.JAN, Months.FEB, Months.MAR, Months.APR, Months.MAY, Months.JUN, Months.JUL, Months.AUG,
                Months.SEP, Months.OCT, Months.NOV, Months.DEC],
            dayNamesMin: [Days.SUN, Days.MON, Days.TUE, Days.WEN, Days.THU, Days.FRI, Days.SUT],
            currentText: 'Nyní',
            closeText: 'Hotovo',
            ampm: false,
            stepMinute: 5,
            firstDay: 1
        }).datetimepicker("setDate", new Date());
    }else{
        var end_hidden = $("input#frm-addTaskForm-end_hidden").val();
        end_hours_default = end_hidden.substring(11,13);
        end_minutes_default = end_hidden.substring(14,16);
        var start_hidden = $("input#frm-addTaskForm-start_hidden").val();
        start_hours_default = start_hidden.substring(11,13);
        start_minutes_default = start_hidden.substring(14,16);
        $('#frm-addTaskForm-start').datetimepicker(
            {
                minDate: -1,
                minTime: start_hours_default+":00",
                maxTime: end_hours_default+":00",
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd.mm.yy',
                yearRange: '2010:2020',
                timeOnlyTitle: 'Vyberte čas',
                timeText: 'Čas',
                hourText: 'Hodiny',
                minuteText: 'Minuty',
                monthNamesShort: [Months.JAN, Months.FEB, Months.MAR, Months.APR, Months.MAY, Months.JUN, Months.JUL, Months.AUG,
                    Months.SEP, Months.OCT, Months.NOV, Months.DEC],
                dayNamesMin: [Days.SUN, Days.MON, Days.TUE, Days.WEN, Days.THU, Days.FRI, Days.SUT],
                currentText: 'Nyní',
                closeText: 'Hotovo',
                ampm: false,
                stepMinute: 5,
                firstDay: 1
            });
    }

    // TASKS:DEFAULT DateTime picker JavaScript to

    $('#frm-addTaskForm-end').datetimepicker(
        {
            minDate: -1,
            minTime: start_hours_default+":00",
            maxTime: end_hours_default+":00",
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd.mm.yy',
            yearRange: '2010:2020',
            timeOnlyTitle: 'Vyberte čas',
            timeText: 'Čas',
            hourText: 'Hodiny',
            minuteText: 'Minuty',
            monthNamesShort: [Months.JAN, Months.FEB, Months.MAR, Months.APR, Months.MAY, Months.JUN, Months.JUL, Months.AUG,
                Months.SEP, Months.OCT, Months.NOV, Months.DEC],
            dayNamesMin: [Days.SUN,Days.MON, Days.TUE, Days.WEN, Days.THU, Days.FRI, Days.SUT],
            currentText: 'Nyní',
            closeText: 'Hotovo',
            ampm: false,
            stepMinute: 5,
            firstDay: 1
        });

    $('#frm-addTaskForm-duration').datetimepicker(
        {
            duration: '',
            hourMax: 99,
            timeOnly: true,
            timeOnlyTitle: 'Vyberte čas',
            timeText: 'Čas',
            hourText: 'Hodiny',
            minuteText: 'Minuty',
            closeText: 'Hotovo',
            ampm: false,
            stepMinute: 5
        });

    // TASKS:DEFAULT Calculate the end of task

    $.fn.endTask = function(start_hours, start_minutes, duration_hours, duration_minutes, start_date) {
        var time = start_hours;
        var month = start_date.substring(3,5);
        month--;
        var i = 0;
        var date = new Date(start_date.substring(6), month, start_date.substring(0,2));
        while(duration_hours != 0)
        {
            //Public holidays
            for(var pH_for = 0; pH_for < 4; pH_for++) {
                jQuery.each(pH, function (index, value) {
                    var pH_month = value.substring(0, 2);
                    pH_month--;
                    var pH_day = value.substring(3, 5);
                    if ((date.getDate() == pH_day) && (date.getMonth() == pH_month)) {
                        date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                    }
                });
            }
            duration_hours--;
            if(time >= end_hours_default)
            {
                if((duration_hours == 0) && (time == end_hours_default) && (duration_minutes == 0)) {
                    time = end_hours_default;
                } else {
                    time = start_hours_default;
                    if(($(saturday).is(':checked')) && ($(sunday).is(':checked'))) {
                        date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                    } else if ((!$(saturday).is(':checked')) && ($(sunday).is(':checked'))) {
                        if (date.getDay() != 5) {
                            date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                        } else {
                            date.setTime(date.getTime() + (1000 * 60 * 60 * 48));
                        }
                    } else if (($(saturday).is(':checked')) && (!$(sunday).is(':checked'))) {
                        if (date.getDay() != 6) {
                            date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                        } else {
                            date.setTime(date.getTime() + (1000 * 60 * 60 * 48));
                        }
                    } else {
                        if ((date.getDay() != 5) && (date.getDay() != 6)) {
                            date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                        } else {
                            date.setTime(date.getTime() + (1000 * 60 * 60 * 72));
                        }
                    }
                    i++;
                }
            }
            //If starting day is weekend
            if(i == 0){
                if ((!$(saturday).is(':checked')) && ($(sunday).is(':checked'))) {
                    if (date.getDay() == 6) {
                        date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                    }
                } else if (($(saturday).is(':checked')) && (!$(sunday).is(':checked'))) {
                    if (date.getDay() == 0) {
                        date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                    }
                } else if ((!$(saturday).is(':checked')) && (!$(sunday).is(':checked'))) {
                    if ((date.getDay() == 6)) {
                        date.setTime(date.getTime() + (1000 * 60 * 60 * 48));
                    }
                    if (date.getDay() == 0) {
                        date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                    }
                }
                i++;
            }
            time++;
            if(time < 10)
                time = "0" + time;
            if(time.length == 3)
                time = time.substring(1);
            //Don't ask me why...
            if(time >= end_hours_default)
            {
                if((duration_hours == 0) && (time == end_hours_default) && (duration_minutes == 0)) {
                    time = end_hours_default;
                } else {
                    time = start_hours_default;
                    if(($(saturday).is(':checked')) && ($(sunday).is(':checked'))) {
                        date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                    } else if ((!$(saturday).is(':checked')) && ($(sunday).is(':checked'))) {
                        if (date.getDay() != 5) {
                            date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                        } else {
                            date.setTime(date.getTime() + (1000 * 60 * 60 * 48));
                        }
                    } else if (($(saturday).is(':checked')) && (!$(sunday).is(':checked'))) {
                        if (date.getDay() != 6) {
                            date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                        } else {
                            date.setTime(date.getTime() + (1000 * 60 * 60 * 48));
                        }
                    } else {
                        if ((date.getDay() != 5) && (date.getDay() != 6)) {
                            date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                        } else {
                            date.setTime(date.getTime() + (1000 * 60 * 60 * 72));
                        }
                    }
                }
            }
        }

        while(duration_minutes != 0)
        {
            //Public holidays
            for(var pH_for = 0; pH_for < 4; pH_for++) {
                jQuery.each(pH, function (index, value) {
                    var pH_month = value.substring(0, 2);
                    pH_month--;
                    var pH_day = value.substring(3, 5);
                    if ((date.getDate() == pH_day) && (date.getMonth() == pH_month)) {
                        date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                    }
                });
            }
            if(time >= end_hours_default){
                time = start_hours_default;
                if(($(saturday).is(':checked')) && ($(sunday).is(':checked'))) {
                    date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                } else if ((!$(saturday).is(':checked')) && ($(sunday).is(':checked'))) {
                    if (date.getDay() != 5) {
                        date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                    } else {
                        date.setTime(date.getTime() + (1000 * 60 * 60 * 48));
                    }
                } else if (($(saturday).is(':checked')) && (!$(sunday).is(':checked'))) {
                    if (date.getDay() != 6) {
                        date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                    } else {
                        date.setTime(date.getTime() + (1000 * 60 * 60 * 48));
                    }
                } else {
                    if ((date.getDay() != 5) && (date.getDay() != 6)) {
                        date.setTime(date.getTime() + (1000 * 60 * 60 * 24));
                    } else {
                        date.setTime(date.getTime() + (1000 * 60 * 60 * 72));
                    }
                }
            }
            start_minutes++;
            if(start_minutes >= 60){
                time++;
                if((time.length == 1))
                    time = "0" + time;
                start_minutes = 0;
            }
            if(start_minutes < 10)
                start_minutes = "0" + start_minutes;
            duration_minutes--;
        }
        if( (time >= end_hours_default) && (start_minutes != "00") ){
            time = start_hours_default;
        }
        time += ":";
        time += start_minutes;
        var dd = ("0" + date.getDate()).slice(-2);
        var mm = ("0" + (date.getMonth() + 1)).slice(-2);
        var yy = date.getFullYear();

        date = dd + "." + mm + "." + yy;
        date += " ";
        date += time;
        return date;
    };

    // TASKS:DEFAULT Calculate the duration of task

    $.fn.durationTask = function(start_hours, start_minutes, end_hours, end_minutes, start_date, end_date) {

        function addZ(n) {
            return (n<10 ? '0':'') + n;
        }

        var start_month = start_date.substring(3,5);
        var end_month = end_date.substring(3,5);
        var date1 = start_month + "/" + start_date.substring(0,2) + "/" + start_date.substring(6) + " " + start_hours + ":" + start_minutes;
        var date2 = end_month + "/" + end_date.substring(0,2) + "/" + end_date.substring(6) + " " + end_hours + ":" + end_minutes;
        var start = new Date(date1);
        var end = new Date(date2);
        var time = 0;

        while (start < end) {
            //Public holidays
            for(var pH_for = 0; pH_for < 4; pH_for++) {
                jQuery.each(pH, function (index, value) {
                    var pH_month = value.substring(0, 2);
                    pH_month--;
                    var pH_day = value.substring(3, 5);
                    if ((start.getDate() == pH_day) && (start.getMonth() == pH_month)) {
                        //console.log(date.getDate() + ':' + pH_day+ '-' +date.getMonth() + ':' + pH_month);
                        start.setTime(start.getTime() + (1000 * 60 * 60 * 24));
                    }
                });
            }
            if(start.getHours() > end.getHours()){
                while(start.getHours() > end.getHours()){
                    start.setTime(start.getTime() - 1000 * 60 * 60);
                    time -= 1000 * 60 * 60;
                }
            }
            if(start.getMinutes() > end.getMinutes()){
                while(start.getMinutes() > end.getMinutes()){
                    start.setTime(start.getTime() - 1000 * 60 * 5);
                    time -= 1000 * 60 * 5;
                }
            }
            if ((start.getDate() == end.getDate()) && (start.getMonth() == end.getMonth()) && (start.getFullYear() == end.getFullYear())) {
                while (start < end) {
                    if((($(saturday).is(':checked')) && ($(sunday).is(':checked'))) || ((!$(saturday).is(':checked')) && ($(sunday).is(':checked')) && start.getDay() != 6) || (($(saturday).is(':checked')) && (!$(sunday).is(':checked')) && (start.getDay() != 0)) || (((start.getDay() != 6) && (start.getDay() != 0)) && ((start.getDay() != 6) && (start.getDay() != 0)))){
                        if (start.getHours() == end.getHours()) {
                            if (start.getMinutes() != end.getMinutes()) {
                                while (start < end) {
                                    start.setTime(start.getTime() + 1000 * 60 * 5);
                                    time += 1000 * 60 * 5;
                                }
                            }
                        } else {
                            start.setTime(start.getTime() + (1000 * 60 * 60));
                            time += 1000 * 60 * 60;
                        }
                    }else{
                        var ms = time % 1000;
                        time = (time - ms) / 1000;
                        var secs = time % 60;
                        time = (time - secs) / 60;
                        var mins = time % 60;
                        var hrs = (time - mins) / 60;

                        return (addZ(hrs) + ':' + addZ(mins));
                    }
                }
            } else {
                if(($(saturday).is(':checked')) && ($(sunday).is(':checked'))) {
                    time += 1000 * 60 * 60 * (end_hours_default - start_hours_default);
                } else if ((!$(saturday).is(':checked')) && ($(sunday).is(':checked'))) {
                    if (start.getDay() != 6) {
                        time += 1000 * 60 * 60 * (end_hours_default - start_hours_default);
                    }
                } else if (($(saturday).is(':checked')) && (!$(sunday).is(':checked'))) {
                    if (start.getDay() != 0) {
                        time += 1000 * 60 * 60 * (end_hours_default - start_hours_default);
                    }
                } else {
                    if ((start.getDay() != 6) && (start.getDay() != 0)) {
                        time += 1000 * 60 * 60 * (end_hours_default - start_hours_default);
                    }
                }
                start.setTime(start.getTime() + (1000 * 60 * 60 * 24));
            }
        }

        var ms = time % 1000;
        time = (time - ms) / 1000;
        var secs = time % 60;
        time = (time - secs) / 60;
        var mins = time % 60;
        var hrs = (time - mins) / 60;
        //$('#a').html( start );

        return (addZ(hrs) + ':' + addZ(mins));
    };

    $( "input#frm-addTaskForm-duration" ).change(function() {
        var duration = $("input#frm-addTaskForm-duration").val();
        var start = $("input#frm-addTaskForm-start").val();
        var start_hours = start.substring(11,13);
        var start_minutes = start.substring(14,16);
        var start_date = start.substring(0, 10);
        var d_array = duration.split(':');
        var duration_hours = d_array[0];
        var duration_minutes = d_array[1];

        $("#frm-addTaskForm-end").val(( $(this).endTask(start_hours, start_minutes, duration_hours, duration_minutes, start_date) ));
    });

    $( $("input#frm-addTaskForm-start") ).change(function() {
        var duration = $("input#frm-addTaskForm-duration").val();
        var start = $("input#frm-addTaskForm-start").val();
        var start_hours = start.substring(11,13);
        var start_minutes = start.substring(14,16);
        var start_date = start.substring(0, 10);
        var d_array = duration.split(':');
        var duration_hours = d_array[0];
        var duration_minutes = d_array[1];

        $("#frm-addTaskForm-end").val(( $(this).endTask(start_hours, start_minutes, duration_hours, duration_minutes, start_date) ));
    });

    $( $("input#frm-addTaskForm-end") ).change(function() {
        var end = $("input#frm-addTaskForm-end").val();
        var start = $("input#frm-addTaskForm-start").val();
        var end_hours = end.substring(11,13);
        var end_minutes = end.substring(14,16);
        var end_date = end.substring(0, 10);
        var start_hours = start.substring(11,13);
        var start_minutes = start.substring(14,16);
        var start_date = start.substring(0, 10);

        $("#frm-addTaskForm-duration").val(( $(this).durationTask(start_hours, start_minutes, end_hours, end_minutes, start_date, end_date) ));
    });

    // TASKS:DEFAULT Setting default values for checkboxes

    var saturday_val = $("#frm-addTaskForm-sat").val();
    var sunday_val = $("#frm-addTaskForm-sun").val();

    if(saturday_val == 1){
        $(saturday).prop('checked', true);
    }else{
        $(saturday).prop('checked', false);
    }

    if(sunday_val == 1){
        $(sunday).prop('checked', true);
    }else{
        $(sunday).prop('checked', false);
    }

    if((saturday_val == 1) && (sunday_val == 1)){
        $(weekend).attr('checked', 'checked');
    }

    if(((saturday_val == 1) && (sunday_val != 1)) || ((saturday_val != 1) && (sunday_val == 1))){
        $(weekend).prop('indeterminate', true);
    }

    $( "input#frm-addTaskForm-checks-weekends" ).change(function() {
        var duration = $("input#frm-addTaskForm-duration").val();
        var start = $("input#frm-addTaskForm-start").val();
        var start_hours = start.substring(11,13);
        var start_minutes = start.substring(14,16);
        var start_date = start.substring(0, 10);
        var d_array = duration.split(':');
        var duration_hours = d_array[0];
        var duration_minutes = d_array[1];
        if(this.checked){
            $(saturday).prop('checked', true);
            $(sunday).prop('checked', true);
        }else{
            $(saturday).prop('checked', false);
            $(sunday).prop('checked', false);
        }

        $("#frm-addTaskForm-end").val(( $(this).endTask(start_hours, start_minutes, duration_hours, duration_minutes, start_date) ));
    });

    $( "input#frm-addTaskForm-checks-saturday" ).change(function() {
        var duration = $("input#frm-addTaskForm-duration").val();
        var start = $("input#frm-addTaskForm-start").val();
        var start_hours = start.substring(11,13);
        var start_minutes = start.substring(14,16);
        var start_date = start.substring(0, 10);
        var d_array = duration.split(':');
        var duration_hours = d_array[0];
        var duration_minutes = d_array[1];
        if(((this.checked) && (!$(sunday).is(':checked'))) || ((!this.checked) && ($(sunday).is(':checked')))){
            $(weekend).prop('indeterminate', true);
        }else if((this.checked) && ($(sunday).is(':checked'))){
            $(weekend).prop('indeterminate', false);
        }else{
            $(weekend).prop('indeterminate', false);
        }

        if((this.checked) && ($(sunday).is(':checked'))){
            $(weekend).prop('checked', true);
        }

        if((!this.checked) && (!$(saturday).is(':checked'))){
            $(weekend).prop('checked', false);
        }

        $("#frm-addTaskForm-end").val(( $(this).endTask(start_hours, start_minutes, duration_hours, duration_minutes, start_date) ));
    });

    $( "input#frm-addTaskForm-checks-sunday" ).change(function() {
        var duration = $("input#frm-addTaskForm-duration").val();
        var start = $("input#frm-addTaskForm-start").val();
        var start_hours = start.substring(11,13);
        var start_minutes = start.substring(14,16);
        var start_date = start.substring(0, 10);
        var d_array = duration.split(':');
        var duration_hours = d_array[0];
        var duration_minutes = d_array[1];

        if(((this.checked) && (!$(saturday).is(':checked'))) || ((!this.checked) && ($(saturday).is(':checked')))){
            $(weekend).prop('indeterminate', true);
        }else if((this.checked) && ($('#frm-addTaskForm-checks-saturday').is(':checked'))){
            $(weekend).prop('indeterminate', false);
        }else{
            $(weekend).prop('indeterminate', false);
        }

        if((this.checked) && ($(saturday).is(':checked'))){
            $(weekend).prop('checked', true);
        }

        if((!this.checked) && (!$(sunday).is(':checked'))){
            $(weekend).prop('checked', false);
        }

        $("#frm-addTaskForm-end").val(( $(this).endTask(start_hours, start_minutes, duration_hours, duration_minutes, start_date) ));
    });

});