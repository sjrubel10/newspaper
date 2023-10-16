$(document).ready(function() {
    $("#news-form").submit(function(event) {
        event.preventDefault();

        var formData = new FormData($(this)[0]);

        // Frontend validation
        if ($('#title').val() === '' || $('#description').val() === '' || $('#category').val() === '') {
            $("#error-message").text("All fields are required!");
        } else {
            $("#error-message").text("");
            // Backend validation using AJAX and PHP
            $.ajax({
                type: "POST",
                url: 'main/jsvalidation/jscreatenews.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    var result= JSON.parse(response);
                    // console.log( result ); // Show response from PHP (success or error message)
                    if(result['success']){
                        window.location.href = "index.php";
                    }
                    // You can redirect to another page or clear the form if needed
                }
            });
        }
    });
});
