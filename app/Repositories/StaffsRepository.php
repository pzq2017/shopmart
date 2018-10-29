<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class StaffsRepository
{
    public function login($loginName, $loginPwd)
    {
        $staff = DB::table('staffs')->where('loginName', $loginName)
            ->where('loginPwd', $loginPwd)->first();
        return $staff;
    }
}