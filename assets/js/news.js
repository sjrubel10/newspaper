
    $(document).ready(function() {

    $("#comment-form").submit(function(event) {
        event.preventDefault();
        var comment = $("#comment").val();
        // alert( comment );

        $.ajax({
            type: "POST",
            url: "submit_comment.php",
            data: { comment: comment },
            success: function(response) {
                // Handle the server response (e.g., display a success message)
                console.log(response);
                // Optionally, you can reload the comments after submission
                // LoadComments();
            },
            error: function(xhr, status, error) {
                // Handle AJAX errors (if any)
                console.error(error);
            }
        });
    });

});
