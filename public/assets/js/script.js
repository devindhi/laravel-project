function setupFormSubmit(formId, buttonId, route) {
    document.addEventListener('DOMContentLoaded', function () {
        var commentForm = document.getElementById(formId);
        var saveButton = document.getElementById(buttonId);

        // Function to get JWT token from localStorage
        function getJwtToken() {
            return localStorage.getItem('jwt_token');
        }

        // Add token to the headers when the form is submitted
        commentForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            var token = getJwtToken();
            if (!token) {
                console.error('JWT token not found in localStorage');
                // Handle case where JWT token is not found (optional)
                return;
            }

            // Create a FormData object from the form
            var formData = new FormData(commentForm);

            // Append the JWT token to the headers
            formData.append('Authorization', 'Bearer ' + token);

            // Perform the form submission with fetch API
            fetch(route, {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                saveButton.disabled = true;
                saveButton.innerHTML = 'Saved';
            })
            .catch(error => {
                console.error('Error:', error);
                // Optionally handle error response
            });
        });
    });
}
