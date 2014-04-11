@extends("layout")
@section("content")
    <h2>Hello, {{ Auth::user()->username }}</h2>
    <p>Welcome to your profile page.</p>
    
    @if (Auth::user()->userGroup===1)
    <p> You Have Admin Rights! </p>
    @endif
@stop