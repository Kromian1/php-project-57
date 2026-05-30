<?php

namespace App\Filters;

class TaskFilter extends QueryFilter
{
    public function statusId(int $id = null)
    {
        return $this->builder->when($id, function ($query) use ($id) {
            $query->where('status_id', $id);
        });
    }

    public function createdById(int $id = null)
    {
        return $this->builder->when($id, function ($query) use ($id) {
            $query->where('created_by_id', $id);
        });
    }

    public function assignedToId(int $id = null)
    {
        return $this->builder->when($id, function ($query) use ($id) {
            $query->where('assigned_to_id', $id);
        });
    }
}
