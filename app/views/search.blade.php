@extends("layout")
@section("content")

    <h3>Users Found:</h3>
    @if (isset($users))
    @foreach($users as $user)
        
        <div>{{{$user->username }}}</div>
        
    @endforeach

    <b>Your search has returned {{count($users)}} results.</b>
    @endif
    
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop