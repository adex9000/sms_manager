@extends('layouts.master')

@section('content')

<div class="container">
    @include('flash::message')
    <form action="{{ URL::route('signin') }}" class="form-signin" role="form" method="post" >
        <h2 class="form-signin-heading">SMS Manager</h2>
        <label for="username" class="sr-only">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember"> Remember me
            </label>
        </div>
         <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p></p>
        @if($errors->any())
        <div class="alert alert-danger">
            <h3>Oops!</h3>

            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </form>

</div>

@stop