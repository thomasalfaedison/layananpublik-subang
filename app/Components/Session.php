<?php

namespace App\Components;

use App\Constants\UserConstant;
use Illuminate\Support\Facades\Auth;

class Session
{
    public static function getRole()
    {
        return optional(Auth::user())->id_role;
    }

    public static function getTahun()
    {
        return session('tahun', date('Y'));
    }

    public static function getIdUser()
    {
        return optional(Auth::user())->id;
    }

    public static function getUsername()
    {
        return optional(Auth::user())->username;
    }

    public static function isAdmin() : bool
    {
        if(optional(Auth::user())->id_role == UserConstant::ROLE_ADMIN)
        {
            return true;
        }

        return false;
    }
    
    public static function isInstansi() : bool
    {
        if(optional(Auth::user())->id_role == UserConstant::ROLE_INSTANSI)
        {
            return true;
        }

        return false;
    }

    public static function getIdInstansi()
    {
        return optional(Auth::user())->id_instansi;
    }
}
