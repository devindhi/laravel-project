{{-- create blog option --}}
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    {{ $buttonName }}
  </button>

 
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Blog</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="blogForm" action="{{ route('blog.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputContent" class="form-label">Content</label>
                        <input type="text" class="form-control" name="content">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputImage" class="form-label">Choose Image</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveChangesButton">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript to add JWT token to form submission -->


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var blogForm = document.getElementById('blogForm');
        var saveButton = document.getElementById('saveChangesButton');

        // Function to get JWT token from localStorage
        function getJwtToken() {
            return localStorage.getItem('jwt_token');
        }

        // Add token to the headers when the form is submitted
        blogForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            var token = getJwtToken();
            if (!token) {
                console.error('JWT token not found in localStorage');
                // Handle case where JWT token is not found (optional)
                window.location.href = '/login';
                return;
            }

            saveButton.disabled = true;
            saveButton.innerHTML = 'Saved';
            // Create a FormData object from the form
            var formData = new FormData(blogForm);

            // Append the JWT token to the headers
            formData.append('Authorization', 'Bearer ' + token);

            // Perform the form submission with AJAX or fetch API
            fetch('{{ route('blog.post') }}', {
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
</script>