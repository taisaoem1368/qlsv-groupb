<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    protected $table = 'role';
	public $primaryKey = 'role_id';
	public $timestamps = false;
}
