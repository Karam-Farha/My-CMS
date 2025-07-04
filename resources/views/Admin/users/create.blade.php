@extends('Admin.layout.app')
@section('content')
<div class="bg-white p-4">

    <form method="POST" action="{{route('users.store')}}" enctype="multipart/form-data">
        @csrf
        @include('Admin.users.form')
    </form>
</div>
@endsection