<?php

namespace App\Core\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case DEVELOPER = 'developer';
    case MODERATOR = 'moderator';
    case USER = 'user';
}