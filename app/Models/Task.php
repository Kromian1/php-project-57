<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status_id',
        'created_by_id',
        'assigned_to_id'
    ];

    public function creator(): belongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function status(): belongsTo
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function assignee(): belongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function labels(): belongsToMany
    {
        return $this->belongsToMany(Label::class, 'task_labels', 'task_id', 'label_id');
    }
}
