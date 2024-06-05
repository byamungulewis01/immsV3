<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public static function activityGroupby()
    {
        return Permission::select('activity_id')->groupBy('activity_id')->get();
    }
    public static function withPermissions($activity)
    {
        return Permission::select('name','id')->where('activity_id', $activity)->get();
    }
}
