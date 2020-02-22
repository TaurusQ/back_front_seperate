<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable,HasMultiAuthApiTokens;

    protected $fillable = [
        'username', 'password',
    ];

    public function findForPassport($login) {
        //return User::orWhere('email', $login)->orWhere('username', $login)->first();
        return $this->where('username', $login)->first();
    }
}
