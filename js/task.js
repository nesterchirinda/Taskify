document.addEventListener('DOMContentLoaded', function() {
    // Add click event listener to the document
    document.addEventListener('click', function(event) {
        // Check if the clicked element is a progress button
        if (event.target.classList.contains('progress-button')) {
            // Show the progress popup
            const progressPopup = document.getElementById('progressPopup');
            progressPopup.style.display = 'block';
        }

        // Check if the clicked element is a progress option
        if (event.target.classList.contains('progress-option')) {
            // Get the selected progress option
            const progressOption = event.target.textContent;
            
        
            console.log('Selected progress:', progressOption);

          
            const progressPopup = document.getElementById('progressPopup');
            progressPopup.style.display = 'none';
        }

        // Check if the clicked element is the close button of the popup
        if (event.target.classList.contains('close-popup')) {
            // Hide the progress popup
            const progressPopup = document.getElementById('progressPopup');
            progressPopup.style.display = 'none';
        }
    });
});




document.addEventListener('DOMContentLoaded', function() {
    // Add click event listener to the document
    document.addEventListener('click', function(event) {
        // Check if the clicked element is a task or a label for a task
        if (event.target.classList.contains('task') || 
            (event.target.getAttribute('for') && 
             event.target.getAttribute('for') === 'task')) {
            // Show the progress popup
            const editTaskPopUp = document.getElementById('task-popup');
            editTaskPopUp.style.display = 'block';
        }
    }); 
});


document.addEventListener('DOMContentLoaded', function() {
    // Add click event listener to the document
    document.addEventListener('click', function(event) {
        // Check if the clicked element is a task or a label for a task
        if (event.target.classList.contains('task-team') || 
            (event.target.getAttribute('for') && 
             event.target.getAttribute('for') === 'task-team')) {
            // Show the progress popup
            const editTaskPopUp = document.getElementById('task-popup');
            editTaskPopUp.style.display = 'block';
        }
        
        else {
            // Check if the click is outside of the popup
            const editTaskPopUp = document.getElementById('task-popup');
            if (event.target !== editTaskPopUp && !editTaskPopUp.contains(event.target)) {
                editTaskPopUp.style.display = 'none';
            }
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {
    // Add click event listener to the document
    document.addEventListener('click', function(event) {
        // Check if the clicked element is a task or a label for a task
        if (event.target.classList.contains('task-team') || 
            (event.target.getAttribute('for') && 
             event.target.getAttribute('for') === 'task-team')) {
            // Show the progress popup
            const editTaskPopUp = document.getElementById('task-popup');
            editTaskPopUp.style.display = 'block';
        }
        
        else {
            // Check if the click is outside of the popup
            const editTaskPopUp = document.getElementById('task-popup');
            if (event.target !== editTaskPopUp && !editTaskPopUp.contains(event.target)) {
                editTaskPopUp.style.display = 'none';
            }
        }
    });
});


 document.addEventListener('DOMContentLoaded', function() {
        console.log()
    document.addEventListener('click', function(event) {
        // Check if the clicked element is a progress button
        if (event.target.classList.contains('add-new-task')) {
            // Show the progress popup
            const editTaskPopUp = document.getElementById('task-popup');
            editTaskPopUp.style.display = 'block';
        }

    });
});





//show task create pop up on individual user page after clicking task
document.addEventListener('DOMContentLoaded', function() {
    console.log()
document.addEventListener('click', function(event) {
    // Check if the clicked element is a progress button
    if (event.target.classList.contains('btn-add-task')) {
        // Show the progress popup
        const editTaskPopUp = document.getElementById('task-popup');
        editTaskPopUp.style.display = 'block';
    }

});
});


//show task edit pop up on individual user page after clicking task
document.addEventListener('DOMContentLoaded', function() {
    console.log()
document.addEventListener('click', function(event) {
    // Check if the clicked element is a progress button
    if (event.target.classList.contains('task')) {
        const editTaskPopUp = document.getElementById('task-popup');
        editTaskPopUp.style.display = 'block';
    }

});
});


//show task edit pop up on individual user page after clicking task
document.addEventListener('DOMContentLoaded', function() {
    console.log()
document.addEventListener('click', function(event) {
    // Check if the clicked element is a progress button
    if (event.target.classList.contains('add-new-task-individual')) {
        const editTaskPopUp = document.getElementById('task-popup');
        editTaskPopUp.style.display = 'block';
    }

});
});