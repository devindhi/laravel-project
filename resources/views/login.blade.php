@extends('layout')
@section('title', 'Login')
@section('content')
<div class="container">
    <div class="container">
        <div class="mt-5">
            @if ($errors->any())
            <div class="col-12">
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>
                @endforeach
            </div>
            @endif

            @if(session()->has('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
            @endif

        </div>
        <form id="loginForm" action="{{route('login.post')}}" method="POST" class="ms-auto me-auto mt-auto" style="width: 500px">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var loginForm = document.getElementById('loginForm');

        loginForm.addEventListener('submit', async function (event) {
            event.preventDefault();

            var formData = new FormData(this);

            try {
                var response = await fetch('{{ route("login.post") }}', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    var errorMessage = await response.json();
                    console.error('Login failed:', errorMessage);
                    alert('Error during login. Please try again.');
                    return;
                }

                var data = await response.json();

                // Store the token in localStorage
                localStorage.setItem('jwt_token', data.token);

                console.log('Login successful. Token:', data.token);

                // Redirect or navigate to another page after successful login
                window.location.href = '{{ route("home") }}'; // Example redirection

            } catch (error) {
                console.error('Error during login:', error);
                alert('Error during login. Please try again.');
            }
        });
    });
</script>
@endsection
