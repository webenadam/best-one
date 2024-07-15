jQuery(document).ready(function($) {
// copy content from "copythis" / (this).text
  
$(document).on('click', '.copythis', function() {
    // Create a temporary input element
    var $temp = $("<input>");
    $("body").append($temp);

    // Determine the content to copy: use the 'copythis' attribute if it exists, else use the element's text
    var contentToCopy = $(this).attr('copythis') ? $(this).attr('copythis') : $(this).text();

    // Set the value of the temporary input to the determined content
    $temp.val(contentToCopy).select();

    // Copy the text inside the input
    document.execCommand("copy");

    // Remove the temporary input
    $temp.remove();

    // Determine the notice text: use the 'notice' attribute if it exists, else default to "הועתק"
    var noticeText = $(this).attr('copy-notice') ? $(this).attr('copy-notice') : "הועתק";

    // Show a temporary message that the text has been copied
    var $msg = $("<div class='box copy-notice flex align-center justify-center' style='position:absolute; top:0;bottom:0;right:0;left:0;margin:auto;z-index:99999999; width:300px;height:150px;display:none;'>" + noticeText + "</div>");
    $("body").append($msg);

    // Fade in the message
    $msg.fadeIn(300);

        $msg.fadeOut(2500, function() {
            $(this).remove(); // remove the message after fading out
        });
});
});
