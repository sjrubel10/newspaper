$(document).ready(function() {
    $("#transaction-form").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();
        console.log( formData );

        $.ajax({
            type: "POST",
            url: '../main/jsvalidation/buysellvalidate.php',
            data: formData,
            success: function(response) {
                console.log( response );
                // $("#response").html(response);
            }
        });
    });
});
