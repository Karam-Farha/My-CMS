@extends('Admin.layout.app')
@section('content')
<div class="bg-white p-4">
    <form method="POST" action="{{route('users.update' , $user)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('Admin.users.form')
    </form>
</div>
@endsection