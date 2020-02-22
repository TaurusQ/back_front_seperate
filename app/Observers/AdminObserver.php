<?php

namespace App\Observers;

use App\Models\Admin;

class AdminObserver
{
    /**
     * @param Admin $admin
     */
    public function creating(Admin $admin){
        $this->checkPassword($admin);
    }

    public function updating(Admin $admin){
        $this->checkPassword($admin);
        //$admin->clearPermissionAndMenu();
    }

    /** 
    public function deleting(Admin $admin){
        $admin->clearPermissionAndMenu();
    }
    */

    public function checkPassword(Admin $admin){
        if($admin->password && \Hash::needsRehash($admin->password)){
            $admin->password = bcrypt($admin->password);
        }
    }
}
