@extends('Admin.layout.app')
@section('content')
    <section class="section">
        <div class="row">
            <div class="col">
            <div class="card">
            <div class="card-body">
                <form action="{{route('audit-logs.index')}}" method="GET">
                    @csrf
                    <div class="d-flex">
                        <select class="form-select my-3 w-25" name="description" id="">
                            <option value="">{{__('Choose')}}</option>
                            <option {{old('description' , request()->description == 'create' ? 'selected' : '')}} class="badge bg-success" value="create">{{__('Create')}}</option>
                            <option {{old('description' , request()->description == 'update' ? 'selected' : '')}} class="badge bg-info" value="update">{{__('Update')}}</option>
                            <option {{old('description' , request()->description == 'delete' ? 'selected' : '')}} class="badge bg-danger" value="delete">{{__('Delete')}}</option>
                        </select>
                        <div class="mx-2 my-3">
    
                            <input type="text" class="form-control " name="user_id" value="{{old('user_id' , request()->user_id ?? '')}}" placeholder="{{__('User ID')}}">
                        </div>
                        <div class="mx-2 my-3">
    
                            <input type="text" class="form-control" name="subject_id" value="{{old('subject_id' , request()->subject_id ?? '')}}" placeholder="{{__('Subject ID')}}">
                        </div>
                        <div class="mx-2 my-3">
    
                            <input type="text" class="form-control" name="subject_type" value="{{old('subject_type' , request()->subject_type ?? '')}}" placeholder="{{__('Subject Type')}} user, lesson etc">
                        </div>
                        <div class="mx-2 my-3"><button class="btn btn-outline-success" type="submit">{{__('Apply')}}</button> </div>
                    </div>

                </form>
                <!-- Bordered Table -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col" class=""><span>{{__('User')}}</span></th>
                        <th scope="col" class=""><span>{{__('Description')}}</span></th>
                        <th scope="col" class=""><span>{{__('Subject')}}</span></th>
                        <th scope="col" class=""><span>{{__('Execution Date')}}</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                        <tr>
                            <th><span>{{$item->id}}</span></th>
                            <th scope="row"><span>{{$item->user_id . '_' .$item->user->name}}</span></th>
                            <td><span class="badge bg-{{$item->description == 'delete' 
                            ? 'danger'
                            :($item->description == 'update' ? 'info' : 'success')}}">
                                {{ucfirst($item->description)}}</span></td>
                            <td><span>{{$item->subject_id . '_' . class_basename($item->subject_type)}}</span></td>
                            <td><span>{{$item->created_at}}</span></td>
                            
                        </tr>
                        @empty
                        <tr>
                            <th scope="row"><span>{{__('No Data')}}</span></th>
                        </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>
                <!-- End Bordered Table -->
            </div>
            </div>
        </div>
        </div>
    </section>
@endsection