document.addEventListener('DOMContentLoaded', function() {
    // Get the button element
    var openModalButton = document.getElementById('openModalButton');
    // Add a click event listener to the button
    openModalButton.addEventListener('click', function() {
        // Use jQuery to trigger the modal display
        $('#tags_modal').modal('show');
    });
    // Get the close buttons within the modal
    var modalCloseButtons = document.querySelectorAll('#tags_modal .btn-close, #tags_modal [data-bs-dismiss="modal"]');
    // Add click event listeners to each close button
    modalCloseButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Use jQuery to close the modal
            $('#tags_modal').modal('hide');
        });
    });
});