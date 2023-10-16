<!-- Include jQuery library -->
// <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- JavaScript for AJAX request -->
    $(document).ready(function() {
    $("#comment-form").submit(function(event) {
        event.preventDefault();
        var comment = $("#comment").val();

        $.ajax({
            type: "POST",
            url: "submit_comment.php",
            data: { comment: comment },
            success: function(response) {
                // Handle the server response (e.g., display a success message)
                alert(response);
                // Optionally, you can reload the comments after submission
                // LoadComments();
            },
            error: function(xhr, status, error) {
                // Handle AJAX errors (if any)
                console.error(error);
            }
        });
    });

    // Function to load comments (optional, if you want to load comments dynamically)
    function LoadComments() {
    // Make another AJAX request to fetch and display comments
    // Example: $.get("get_comments.php", function(data) { /* Display comments */ });
}
});
