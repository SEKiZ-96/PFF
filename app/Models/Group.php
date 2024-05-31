<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TimeSchedule;
class Group extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $fillable = ['group_name'];
    public function timeSchedules()
    {
        return $this->hasMany(TimeSchedule::class, 'group', 'grroup');
    }
}

