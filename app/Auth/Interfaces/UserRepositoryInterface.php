<?php

namespace App\Auth\Interfaces;

use App\Core\Interfaces\EloquentRepositoryInterface;
use App\Models\User;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * E-posta adresine göre kullanıcı bulur.
     */
    public function findByEmail(string $email): ?User;
}
