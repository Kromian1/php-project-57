<?php

namespace App\Filters;

class TaskFilter extends QueryFilter
{
    public function status_id(int $id = null)
    {
        return $this->builder->when($id, function ($query) use ($id) {
            $query->where('status_id', $id);
        });
    }

    public function created_by_id(int $id = null)
    {
        return $this->builder->when($id, function ($query) use ($id) {
            $query->where('created_by_id', $id);
        });
    }

    public function assigned_to_id(int $id = null)
    {
        return $this->builder->when($id, function ($query) use ($id) {
            $query->where('assigned_to_id', $id);
        });
    }
}
