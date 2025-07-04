@extends('layouts.app')
@section('pageTitle', sprintf('%s | %s', __('Holding Page'), config('panel.site_title')))
@section('content')
    <div class="row">
        <div class="col-xl-5 col-lg-6 mx-auto">
            <div class="bg-white xs-p-20 p-30 border rounded">
                <div class="form-icon-left rounded form-boder text-center">
                    <h4>{{ __('Check Your Email!') }}</h4>
                </div>
            </div>
        </div>
    </div>
@endsection