@extends('layouts.app')
@section('pageTitle', sprintf('%s | %s', __('Account Verification'), config('panel.site_title')))
@section('content')

    <div class="full-row pt-30">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="bg-white xs-p-20 p-30 border rounded">
                        <div class="form-icon-left rounded form-boder">
                            <h4 class="m-4 text-center">{{ __('Verification Code') }}</h4>
                            <form action="{{route('opt-verifiy')}}" method="Post">
                                @csrf
                                <input type="hidden" name="email" value="{{$email ?? ''}}">
                                <div class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <input type="text" name="code" class="form-control" style="width: 75%" required>
                                    </div>
                                    <br>
                                    <button class="btn btn-primary mb-4">{{__('Verifiy')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection