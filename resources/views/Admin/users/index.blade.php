@extends('Admin.layout.app')
@section('content')
{{-- {{dd('heelo')}} --}}
    <section class="section">
        <div class="row">
            <div class="col">
            <div class="card">
            <div class="card-body">
                <div class="my-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title d-inline">{{__('All Users')}}</h5>
                    </div>
                    <div>
                        @can('user_store')
                            <a href="{{route('users.create')}}" class="btn btn-outline-success"><i class="bi bi-plus"></i> {{__('Add User')}}</a>
                        @endcan
                    </div>
                </div>
                
                <!-- Bordered Table -->
                <table class="table table-bordered">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col" class=""><span>{{__('Name')}}</span></th>
                    <th scope="col" class=""><span>{{__('Email')}}</span></th>
                    <th scope="col" class=""><span>{{__('Role')}}</span></th>
                    <th scope="col" class=""><span>{{__('Photo')}}</span></th>
                    <th scope="col" class=""><span>{{__('Actions')}}</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $item)
                    <tr>
                        <th scope="row"><span>{{$item->id}}</span></th>
                        <td><span>{{$item->name ?? '-'}}</span></td>
                        <td><span>{{$item->email}}</span></td>
                        <td>
                            @foreach ($item->roles as $role)
                                <div class="badge bg-primary">
                                    {{$role->name}}
                                </div>                                
                            @endforeach
                        </td>
                        <td>
                        @if ($item->originalImage)
                            <a href="{{$item->originalImage}}" target="blank">
                                <img src="{{$item->originalImage ?? ''}}" alt="Not found" class="border rounded dashboard-table-image">                                        
                            </a>
                            @isset($item->featured)
                            <span class="badge bg-primary ms-4"><i class="bi bi-star me-1"></i> {{$item->featured ? 'Featured' : ''}}</span>
                            @endisset
                            
                        @else
                        <span>{{__('No Photo')}}</span>
                        @endif
                        </td>
                        <td>
                            <a class="btn btn-min btn-outline-primary mb-1" href="#">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a class="btn btn-min btn-outline-primary me-4 mb-1" href="{{ route('users.edit', $item->id) }}">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            @can('user_delete')
                                <form class="me-4" action="{{ route('users.destroy', $item->id) }}" method="POST" onsubmit="return confirm('{{ __('Delete This Item?') }}');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-mini btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <th scope="row"><span>{{__('No Data')}}</span></th>
                    </tr>
                    @endforelse
                </tbody>
                </table>
                {{$users->links()}}
                <!-- End Bordered Table -->
            </div>
            </div>
        </div>
        </div>
    </section>
@endsection