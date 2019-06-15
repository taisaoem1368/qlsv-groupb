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

    public function updateRememberToken($teacher_code)
    {
        $token = md5(rand(10,15000).date('d/m/YH:m:s'));
        $user = $this->where('user_teacher_code', $teacher_code)->first();
        $user->remember_token = $token;
        $user->save();
        return $token;
    }

    public function checkExistRememberToken($token)
    {
        $user = $this->where('remember_token', $token)->first();
        if(count($user) <= 0)
            return false;
        if((strtotime($user->updated_at) + 300) < strtotime(date('d-m-Y H:i:s')))
            return false;
        return true;
    }

    public function resetPassword($token, $newpassword)
    {
        $user = $this->where('remember_token', $token)->first();
        if(count($user) <= 0)
            return false;
        if((strtotime($user->updated_at) + 300) < strtotime(date('d-m-Y H:i:s')))
            return false;
        $token_after = md5(rand(10,15000).date('d/m/YH:m:s'));
        $user->remember_token = $token_after;
        $user->password = Hash::make($newpassword);
        $user->save();
        return true;
    }


}
