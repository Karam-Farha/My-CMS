<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Decide if the current user allowed to apply crud operations on the passed model
     * @param model
     * @return the buttons that the user have the permissions to execute
     */
    public function prepareBtns(Model $model){
        $user = auth()->user();
        $editRoute = route(Str::lower(class_basename($model) . 's.' . 'edit') , $model->id);
        $deleteRoute = route(Str::lower(class_basename($model) . 's.' . 'destroy') , $model->id);

        $show = '<a class="btn btn-min btn-outline-primary mx-1 mb-1" href="#"><i class="bi bi-eye"></i></a>';
        $edit = '<a class="btn btn-min btn-outline-primary mx-1 mb-1" href="'.$editRoute.'"><i class="bi bi-pencil-square"></i></a>';
        $delete = '<button data-route='.$deleteRoute.' type="submit" class="mx-1 mb-1 btn btn-mini btn-outline-danger delete-user"><i class="bi bi-trash"></i></button>';
        $result = '';

        if($user->can(Str::lower(class_basename($model) . '_show')));
            $result = $result . $show;

        if($user->can(Str::lower(class_basename($model) . '_update')));
            $result = $result . $edit;

        if($user->can(Str::lower(class_basename($model) . '_delete')));
            $result = $result . $delete;

        return $result; 
    }

    public function prepareImg(Model $model){
        return $model->originalImage
        ? '<a href="'.$model->originalImage.'" target="blank"><img src="'.$model->originalImage.'" alt="" class="border rounded dashboard-table-image"></a>' 
        : '<span>"'.__('No Photo').'"</span>';
    }
}
