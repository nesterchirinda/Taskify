// Select all radio buttons
const radioButtons = document.querySelectorAll('input[type="radio"]');

let selectedRadioButton = null;

// Iterate over each radio button
radioButtons.forEach(radioButton => {
    // Add click event listener to each radio button
    radioButton.addEventListener('click', function() {
        // Select the label of the current radio button
        const label = this.parentElement;

        const circleIcon = label.querySelector('.fa-regular');
        

        if (selectedRadioButton !== null && selectedRadioButton !== radioButton) {
            const previousLabel = selectedRadioButton.parentElement;
            const previousCircleIcon = previousLabel.querySelector('.fa-regular');
            previousCircleIcon.className = 'fa-regular fa-circle';

       
            const previousOptionContainer = previousLabel.closest('.option');
            previousOptionContainer.style.borderColor = '#B4B4B4';
        }


        selectedRadioButton = radioButton;

 
        circleIcon.className = 'fa-regular fa-circle-check';
 
        const optionContainer = label.closest('.option');
        optionContainer.style.borderColor = '#A0B8E6';
    });
});




window.onload = function() {
    var checkboxes = document.querySelectorAll('.input-toggle');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            console.log("Checkbox changed");
            if (this.checked) {
                console.log("Checkbox is checked");
                this.parentNode.querySelector('i').classList.remove('fa-toggle-off');
                this.parentNode.querySelector('i').classList.add('fa-toggle-on');
            } else {
                console.log("Checkbox is unchecked");
                this.parentNode.querySelector('i').classList.remove('fa-toggle-on');
                this.parentNode.querySelector('i').classList.add('fa-toggle-off');
            }
        });
    });
};



