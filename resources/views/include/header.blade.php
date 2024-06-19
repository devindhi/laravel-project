<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="mx-auto">
            <h1>Blog Website</h1>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/register">Register</a>
                </li>
                <li>
                    <a class="nav-link" id="logoutLink"   href="{{ route('logout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    // Get the logout link
    const logoutLink = document.getElementById('logoutLink');

    // Add a click event listener to the logout link
    logoutLink.addEventListener('click', (event) => {
        event.preventDefault(); // Prevent the default link behavior

        // Clear the localStorage data
        localStorage.clear();

        // Optionally, you can redirect the user to another page after clearing the localStorage
        window.location.href = '/logout'; // Replace with the desired URL
    });
</script>
