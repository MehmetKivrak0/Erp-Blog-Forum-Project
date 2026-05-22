<?php

namespace App\Auth\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Auth\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * E-posta adresine göre kullanıcı bulur.
     */
    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }
}
