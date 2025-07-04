@extends('Admin.layout.app')
@section('content')

<section class="section dashboard">
  <div class="row bg-white text-center p-4 mx-5">
    <h3>{{__('Hello')}}: {{auth()->check() ? auth()->user()->name : ''}}</h3>
  </div>
</section>


@endsection