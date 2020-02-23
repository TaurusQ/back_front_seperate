<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens, HasRoles;

    protected $guarded = [];

    const STATUS_NORMAL = 1;
    const STATUS_FORBIDEN = -1;

    public static $statusMap = [
        self::STATUS_NORMAL => '正常',
        self::STATUS_FORBIDEN => '禁止'
    ];

    protected $appends = ['status_text'];

    public function findForPassport($login)
    {
        //return User::orWhere('email', $login)->orWhere('username', $login)->first();
        return $this->where('username', $login)->first();
    }

    public function getStatusTextAttribute(){
        return isset_and_not_empty(self::$statusMap,$this->attributes['status'],'');
    }
}
