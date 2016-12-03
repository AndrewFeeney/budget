<?php

namespace App\Repositories;

abstract class Repository
{
    protected $model;

    /**
     * Returns the rows which match the given attributes
     * @param $attributes
     * @return Illuminate\Support\Collection
     **/
    public function filter($attributes)
    {
        return collect($attributes)->keys()->reduce(function ($query, $key) use ($attributes) {
            return $query->where($key, $attributes[$key]);
        }, $this->model->newQuery())->get();
    }
}
