<?php

namespace App\Repositories;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected $model;
    public function __construct()
    {
        $this->model = $this->model();
    }

    public function find($id, $columns = ['*'])
    {
        return $this->model::find($id, $columns);
    }

    public function delete($id)
    {
        return $this->model::delete();
    }

    public function getBySlug($slug)
    {
        return $this->model::where('slug', $slug)->firstOrFail();
    }
}
