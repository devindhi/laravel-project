<!-- Comments Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-m"> <!-- Adjusted modal width to small -->
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Comments</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="commentForm" action="{{ route('comments.post', ['id' => $blog->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Text Field for Comment -->
                    <div class="mb-3">
                        <label for="commentText" class="form-label">Your Comment</label>
                        <textarea class="form-control" name="comment" rows="3"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveChangesButton">Save</button> <!-- Submit Button -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include JavaScript to handle form submission -->
<script>
    // Define the setupFormSubmit function to handle form submission
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
                    window.location.href = '/login';
                    return;
                }

                // Create a FormData object from the form
                var formData = new FormData(commentForm);
                saveButton.disabled = true;
                saveButton.innerHTML = 'Saved';
               
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
                    
                    
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Optionally handle error response
                });
            });
        });
    }

    // Call setupFormSubmit function to initialize form submission handling
    setupFormSubmit('commentForm', 'saveChangesButton', '{{ route('comments.post', ['id' => $blog->id]) }}');
</script>
