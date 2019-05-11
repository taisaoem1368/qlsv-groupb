<?php

namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Hash;
class user extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    public $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_teacher_code', 'password', 'user_role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function createValue($username, $password, $role_id)
    {
        $user = new user;
        $user->user_teacher_code = $username;
        $user->password = Hash::make($username);
        $user->user_role_id = $role_id;
        $user->save();
    }

    public function setValue($user_old, $username_new, $password, $role_id)
    {
        $user = user::where('user_teacher_code', $user_old)->first();
        if($username_new != null){$user->user_teacher_code = $username_new;}
        if($password != null){$user->password = Hash::make($password);}
        if($role_id != null){$user->user_role_id = $role_id;}
        $user->save();
    }

    public function deleteUser($teacher_code)
    {
        $kq = $this->where('user_teacher_code', $teacher_code)->first();
        $kq->delete();
    }


}
