jQuery(document).ready(function($) {


    jQuery('body').append('<div id="wpswocuf_lite_myModal" class="wpswocuf_lite_modal"> <!-- Modal content --> <div class="wpswocuf_lite_modal-content"> <span class="wpswocuf_lite_close">&times;</span> <p> '+ wpswocuf_upsell_public_exit.skip_message +'</p> </div> </div>');
    // Get the modal
    var modal = document.getElementById("wpswocuf_lite_myModal");


    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("wpswocuf_lite_close")[0];

    

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    
    if ( 'on' == wpswocuf_upsell_public_exit.skip_enabled) {
        $("html").bind("mouseleave", function () {
            modal.style.display = "block";

            

            $("html").unbind("mouseleave");
        });
    }

});

