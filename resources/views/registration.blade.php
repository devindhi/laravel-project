@extends('layout')
@section('title','Register')
@section('content')
   <div class="container">
    <div class="mt-5">
      @if ($errors->any())
        <div class="col-12">
          @foreach ( $errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
          @endforeach
        </div>
        
      @endif

      @if(session()->has('error'))
      <div class="alert alert-danger">{{session('error')}}</div>
      @endif

    </div>
    <form action="{{route('register.post')}}" method="POST" class="ms-auto me-auto mt-auto" style="width: 500px" >
        @csrf
        <div class="mb-3">
            <label for="exampleInputName" class="form-label">Username</label>
            <input type="text" class="form-control" name="name" aria-describedby="emailHelp">
            
          </div>
        <div class="mb-3">
            <label for="exampleInputContact" class="form-label">Contact</label>
            <input type="tel" class="form-control" name="contact" aria-describedby="emailHelp">
            
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input type="email" class="form-control" name="email" aria-describedby="emailHelp">
          
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" placeholder="minimum 6 characters">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
          <input type="password" class="form-control" name="password_confirmation"  placeholder="minimum 6 characters">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
   </div>

@endsection
