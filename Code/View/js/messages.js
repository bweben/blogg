/**
 * Created by natha on 12.12.2015.
 */
/**
 * Makes a beautiful transition on to the message
 */
$(document).ready(function() {
    var message = $("#message-alert");
    if (message.length) {
        message.delay(1000*4).fadeOut(500);
    }
});