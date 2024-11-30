$(document).ready(function() {
    $('#assign-task-btn').click(function() {
        var userEmail = $('#user-email').val(); // Get the user's email from the input field

        // use AJAX to check if the user is signed up
        $.ajax({
            type: 'POST',
            url: 'check_user.php', // PHP script to check if the user is signed up
            data: { userEmail: userEmail },
            success: function(response) {
                if (response === 'exists') {
                    // If the user exists, submit the form
                    $('form').submit();
                } else {
                    // If the user does not exist, display an error message
                    alert('User is not signed up. Please assign the task to a valid user.');
                }
            }
        });
    });
});
