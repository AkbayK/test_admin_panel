<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PostSaveAction
{
    protected $model;
    protected $data;

    public function __construct(Model $model = null, array $data = null)
    {
        $this->model = $model;
        $this->data = $data;
    }

    public function run()
    {
        $data = $this->data;

        if (isset($data['image'])) {
            $data['image'] = $data['image']->storeAs('posts', time().rand(0,99).'_'.$data['image']->getClientOriginalName());
        }

        $this->model->fill($data);
        $this->model->save();

        return $this->model;
    }
}