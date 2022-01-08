<?php

namespace App\Observers;


use Illuminate\Database\Eloquent\Model;

class CustomerObserver
{
    public function creating(Model $model)
    {
        $model->user_id =  auth()->user()->id;
    }

    public function updating(Model $model)
    {
        $model->user_id =  auth()->user()->id;
    }
}
