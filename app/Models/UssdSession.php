<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UssdSession extends Model
{
    use HasFactory;
    protected $fillable = ['phone', 'session_id', 'user_input',];
}
