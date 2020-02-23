<?php

namespace App\Models;

use SMartins\PassportMultiauth\HasMultiAuthApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable,HasMultiAuthApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    const STATUS_NORMAL = 1;
    const STATUS_FORBIDEN = -1;

    public static $statusMap = [
        self::STATUS_NORMAL => '正常',
        self::STATUS_FORBIDEN => '禁止'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['status_text'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function findForPassport($login) {
        //return User::orWhere('email', $login)->orWhere('username', $login)->first();
        return $this->where('username', $login)->first();
    }

    public function getStatusTextAttribute(){
        return isset_and_not_empty(self::$statusMap,$this->attributes['status'],'');
    }
}
