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
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
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
                        {{-- <tbody>
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
                                        
                                    @else
                                        <span>{{__('No Photo')}}</span>
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                            @empty
                            <tr>
                                <th scope="row"><span>{{__('No Data')}}</span></th>
                            </tr>
                            @endforelse
                        </tbody> --}}
                    </table>
                </div>
                <!-- End Bordered Table -->
            </div>
            </div>
        </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $(document).ready(function(){

                // initializing Data Table Object
                const table = $('.datatable').DataTable({
                    serverSide:true,
                    processing:true,
                    ajax: {
                        url:'{{route('users.index')}}'
                    },
                    columns:[
                        {data:'DT_RowIndex' , name: 'DT_RowIndex' , orderable:false , searchable:false},
                        {data:'name' , name: 'name'},
                        {data:'email' , name: 'email'},
                        {data:'roles' , name: 'roles', searchable:false},
                        {data:'photo' , name: 'photo' , orderable:false , searchable:false},
                        {data:'actions' , name: 'actions' , orderable:false , searchable:false}
                    ]
                });

                // Implementing Delete Functionality
                $('.table').on('click' , '.delete-user' , function(){
                    const url = $(this).data('route');

                    if(url){
                        if(confirm('{{__("Are you sure, you want to delete This Item?")}}'))
                            $.ajax({
                                url: url,
                                method: 'DELETE',
                                data:{
                                    _token: '{{csrf_token()}}'
                                },
                                success: function(response){
                                    if(response.status === 200)
                                        table.ajax.reload(null , false)
                                    else{
                                        alert('{{__("Somthing Went Wrong")}}');
                                        console.log(response);
                                    }
                                },
                                error: function(err){
                                    alert('{{__("Somthing Went Wrong")}}');
                                    console.log(err);
                                }
                            })
                    }
                })
            });

        </script>
    @endpush
@endsection

                        {{-- // {data:'DT_RawIndex' , name: 'DT_RawIndex' , searchable:false},
                        // {data:'role' , name: 'role'},
                        // {data:'photo' , name: 'photo'}, --}}