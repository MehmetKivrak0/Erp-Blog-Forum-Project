<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Auth\Services\AuthService;
use App\Auth\DTOs\LoginDTO;
use App\Auth\DTOs\RegisterDTO;
use Illuminate\Http\Request;
use Exception;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    /**
     * Giriş formunu gösterir.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Giriş işlemini gerçekleştirir.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'nullable',
        ]);

        $dto = new LoginDTO(
            email: $request->email,
            password: $request->password,
            remember: $request->has('remember')
        );

        try {
            if ($this->authService->login($dto)) {
                return redirect()->intended(route('home'))->with('success', 'Giriş başarılı.');
            }

            return back()->withErrors([
                'email' => 'Girdiğiniz şifre veya e-posta adresi hatalı.',
            ])->withInput($request->only('email'));

        } catch (Exception $e) {
            return back()->withErrors([
                'email' => $e->getMessage(),
            ])->withInput($request->only('email'));
        }
    }

    /**
     * Kayıt formunu gösterir.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Kayıt işlemini gerçekleştirir.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'terms' => 'required|accepted',
        ]);

        $dto = new RegisterDTO(
            name: $request->name,
            email: $request->email,
            password: $request->password
        );

        try {
            $this->authService->register($dto);
            return redirect()->route('home')->with('success', 'Hesabınız başarıyla oluşturuldu ve giriş yapıldı.');
        } catch (Exception $e) {
            return back()->withErrors([
                'email' => $e->getMessage(),
            ])->withInput($request->only('name', 'email'));
        }
    }

    /**
     * Çıkış işlemini gerçekleştirir.
     */
    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('home')->with('success', 'Başarıyla çıkış yapıldı.');
    }
}
