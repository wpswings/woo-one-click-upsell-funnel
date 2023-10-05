jQuery(document).ready(function($) {


    jQuery('body').append('<div id="myModal" class="modal"> <!-- Modal content --> <div class="modal-content"> <span class="close">&times;</span> <p> '+ wps_upsell_public_exit.skip_message +'</p> </div> </div>');
    // Get the modal
    var modal = document.getElementById("myModal");


    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    

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
    
    if ( 'on' == wps_upsell_public_exit.skip_enabled) {
        $("html").bind("mouseleave", function () {
            modal.style.display = "block";

            

            $("html").unbind("mouseleave");
        });
    }

});