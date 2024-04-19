$(document).ready(function() {
    // Click event handler for clickable badges
    $('.badge-clickable').click(function() {
        $(this).toggleClass('chosen');

        // If the element is chosen, set border properties
        if ($(this).hasClass('chosen')) {
            $(this).css({
                'border-style' : 'solid',
                'border-width': 'medium',
            });
            $(this).css('border-color', 'blue');
        } else {
            // If the element is not chosen, reset border properties
            $(this).css({
                'border-style' : '',
                'border-width': '',
            });
            $(this).css('color', 'white'); // Reset color
        }
        // Get the associated checkbox
        var checkbox = $(this).prev('input[type="checkbox"]');
        // Toggle the checkbox's checked state
        checkbox.prop('checked', !checkbox.prop('checked'));
    });

});