/**
 * Example 2 is similar to Example 1. Two things that are
 * different are counting down instead of up and allowing
 * user input for start time. Also, when the timer counts
 * down to zero, an alert is triggered.
 */
var Timer = new (function(endtime) {

    var $countdown;
    var $form;
    var incrementTime = 70;
    var currentTime = endtime; // 5 minutes (in milliseconds)

    $(function() {

        // Setup the timer
        $countdown = $('#timer');
        Timer.Timer = $.timer(updateTimer, incrementTime, true);

        // Setup form
        /*  $form = $('#example2form');
         $form.bind('submit', function() {
         Timer.resetCountdown();
         return false;
         });*/

    });

    function updateTimer() {

        // Output timer position
        var timeString = formatTime(currentTime);
        $countdown.html(timeString);

        // If timer is complete, trigger alert
        if (currentTime == 0) {
            Timer.Timer.stop();
            alert('Example 2: Countdown timer complete!');
            Timer.resetCountdown();
            return;
        }

        // Increment timer position
        currentTime -= incrementTime;
        if (currentTime < 0)
            currentTime = 0;

    }

    this.resetCountdown = function() {

        // Get time from form
        var newTime = parseInt($form.find('input[type=text]').val()) * 1000;
        if (newTime > 0) {
            currentTime = newTime;
        }

        // Stop and reset timer
        Timer.Timer.stop().once();

    };

});


// Common functions
function pad(number, length) {
    var str = '' + number;
    while (str.length < length) {
        str = '0' + str;
    }
    return str;
}
function formatTime(time) {
    time = time / 10;
    var min = parseInt(time / 6000),
            sec = parseInt(time / 100) - (min * 60),
            hundredths = pad(time - (sec * 100) - (min * 6000), 2);
    return (min > 0 ? pad(min, 2) : "00") + ":" + pad(sec, 2) + ":" + hundredths;
}
