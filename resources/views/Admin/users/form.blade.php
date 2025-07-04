    <div>

    <div class="row mb-3">
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">{{__('Role')}}</label>
            <div class="col-sm-10">
                <select name="roles[]" class="form-select" multiple aria-label="multiple select example">
                @isset($user)
                    @foreach ($roles as $role)
                        <option {{auth()->user()->hasRole($role->name) ? 'selected' : ''}} value="{{$role->id}}">{{$role->name}}</option>            
                    @endforeach 
                @else
                    @foreach ($roles as $role)
                        <option value="{{$role->id}}">{{$role->name}}</option>            
                    @endforeach 
                @endisset

                </select>
            </div>
            </div>

        {{-- <label class="col-sm-2 col-form-label"><span>الدور</span></label>
        <div class="col-sm-10">
        <select name="category_id" class="form-select" aria-label="Default select example">
            @foreach ($roles as $item)
                
                <option @selected($item->id == $user->category->id ) value="{{$item->id}}"><span>{{$item->name}}</span></option>
    
                <option value="{{$item->id}}"><span>{{$item->name}}</span></option>
            @endisset
            @endforeach
        </select> --}}
        </div>
    </div>
    
      <div class="row mb-3">
        <label for="inputText" class="col-sm-2 col-form-label"><span>{{__('Name')}}</span></label>
        <div class="col-sm-10">
          <input type="text" name="name" class="form-control" value="{{isset($user) ? ($user->name ?? '') : ''}}">
        </div>
      </div>
      <div class="row mb-3">
        <label for="inputText"  class="col-sm-2 col-form-label"><span>{{__('Email')}}</span></label>
        <div class="col-sm-10">
          <input type="email" name="email" class="form-control" value="{{isset($user) ? ($user->email ?? '') : ''}}">
        </div>
      </div>
      <div class="row mb-3">
        <label for="inputText" class="col-sm-2 col-form-label"><span>{{__('Password')}}</span></label>
        <div class="col-sm-10">
          <input type="password" name="password" class="form-control" value="">
        </div>
      </div>
      <div class="row mb-3">
        <label for="inputNumber" name="photo" class="col-sm-2 col-form-label"><span>{{__('Photo')}}</span></label>
        <div class="col-sm-10">
          <input class="form-control" name="photo" type="file" id="formFile">
        </div>
      </div>
      {{-- <div class="row mb-3">
        <legend class="col-form-label col-sm-2 pt-0"><span>منتج مميز ؟</span></legend>
        <div class="col-sm-10">
          <div class="form-check">
            <input class="form-check-input" name="featured" {{isset($user) ? ($user->featured ? 'checked' : '') : ''}} type="checkbox" id="gridCheck1" value="1">
          </div>
        </div>
      </div> --}}
      <div class="row mb-3">
        <div class="col-sm-10">
          <button type="submit" class="btn btn-success"><span>{{__('Save')}}</span></button>
        </div>
      </div>
    </div>