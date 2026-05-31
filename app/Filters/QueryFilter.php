<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QueryFilter
{
    public $request;

    protected $builder;

    protected $delimiter = ',';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function filters()
    {
        return $this->request->query();
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            $method = Str::camel($name);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        return $this->builder;
    }

    protected function paramToArray($param)
    {
        return explode($this->delimiter, $param);
    }
}
