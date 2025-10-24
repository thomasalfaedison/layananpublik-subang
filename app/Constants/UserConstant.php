<?php

namespace App\Constants;

class UserConstant
{
    public const RouteIndex = 'user.index'; 
    public const RouteCreate = 'user.create'; 
    public const RouteCreateProcess = 'user.createProcess'; 
    public const RouteUpdate = 'user.update'; 
    public const RouteUpdateProcess = 'user.updateProcess';
    public const RouteSetPassword  = 'user.setPassword';
    public const RouteSetPasswordProcess  = 'user.setPasswordProcess';
    public const RouteChangePassword  = 'user.changePassword';
    public const RouteChangePasswordProcess  = 'user.changePasswordProcess';
    public const RouteRead = 'user.read'; 
    public const RouteDelete = 'user.delete';
    public const RouteExportExcel  = 'user.exportExcel';
    public const RouteResetPasswordDefaultAll  = 'user.resetPasswordDefaultAll';

    public const ROLE_ADMIN = 1;
    public const ROLE_INSTANSI = 2;
}