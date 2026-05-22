<?php

namespace App\Auth\Services;

use App\Core\Services\BaseService;
use App\Auth\Interfaces\UserRepositoryInterface;
use App\Auth\DTOs\LoginDTO;
use App\Auth\DTOs\RegisterDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {}

    /**
     * Kullanıcı girişi yapar.
     */
    public function login(LoginDTO $dto): bool
    {
        return $this->executeSafe(function () use ($dto) {
            $credentials = [
                'email' => $dto->email,
                'password' => $dto->password,
            ];

            if (Auth::attempt($credentials, $dto->remember)) {
                request()->session()->regenerate();
                return true;
            }

            return false;
        }, 'Giriş işlemi sırasında bir hata oluştu.');
    }

    /**
     * Yeni kullanıcı kaydı oluşturur ve giriş yaptırır.
     */
    public function register(RegisterDTO $dto): User
    {
        return $this->executeSafe(function () use ($dto) {
            $userData = [
                'name' => $dto->name,
                'email' => $dto->email,
                'password' => Hash::make($dto->password),
            ];

            /** @var User $user */
            $user = $this->repository->create($userData);

            if ($user) {
                Auth::login($user);
                request()->session()->regenerate();
            }

            return $user;
        }, 'Kayıt işlemi sırasında bir hata oluştu.');
    }

    /**
     * Kullanıcı oturumunu kapatır.
     */
    public function logout(): void
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
