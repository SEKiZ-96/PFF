<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $fillable = ['room_name'];
    public function timeSchedule()
    {
        return $this->hasMany(TimeSchedule::class);
    }
}

