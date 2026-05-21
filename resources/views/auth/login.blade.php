@extends('layouts.app')

@section('title', 'DevConnect | Sign In')
@section('body-class', 'bg-surface text-on-surface min-h-screen flex flex-col md:flex-row')

@section('content')
<!-- Left Panel: Visual/Branding -->
<section class="hidden md:flex md:w-3/5 relative overflow-hidden bg-background-dark">
    <img alt="Abstract futuristic technology illustration with circuitry patterns and glowing data nodes" class="absolute inset-0 w-full h-full object-cover opacity-60" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCh6ngp0yzJcbGeuHY4s08NZ5L6-eKDGvKu-Y7CZdr2uk73ZBQ7OjkmZDGGsMnpnOrUmizT4wjFQTZklIokkZnTi5S-ZHIm-62Y6T-S5BwHwzLS-S_eOMC9SjbkoevqpvnceDfnXW2-pNcoYjLpkdjOht4zoGX1cwF_DZLgudbjzCW39jbYFXGF2XBIFVA-v6l0ehkcLw5AnvAHVv5i4hRYf-pHIjmlR5QEEjqT-SGAwI8gkk_pcFu0k2BMgzqgKl5WtN8NMskipUU"/>
    <div class="absolute inset-0 bg-gradient-to-tr from-background-dark/80 via-transparent to-transparent"></div>
    <div class="relative z-10 flex flex-col justify-end p-24 w-full h-full max-w-3xl">
        <h1 class="font-headline-xl text-headline-xl text-white mb-stack-md leading-tight">
            Join the community of builders.
        </h1>
        <p class="font-body-lg text-body-lg text-on-primary-container/80 max-w-lg">
            Connect with developers worldwide, share snippets, and architect the future of open-source software on DevConnect.
        </p>
    </div>
</section>
<!-- Right Panel: Form -->
<main class="w-full md:w-2/5 min-h-screen bg-background-light flex items-center justify-center p-margin-mobile md:p-margin-desktop">
    <div class="w-full max-w-md space-y-stack-lg">
        <!-- Header/Logo Area -->
        <div class="flex flex-col items-center md:items-start space-y-stack-md">
            <a href="{{ route('home') }}" class="flex items-center gap-2 mb-stack-sm hover:opacity-90">
                <span class="material-symbols-outlined text-primary text-4xl" data-icon="terminal">terminal</span>
                <span class="font-headline-lg text-headline-lg font-bold text-primary">DevConnect</span>
            </a>
            <div class="space-y-1">
                <h2 class="font-headline-md text-headline-md text-on-surface">Sign in to your account</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Welcome back! Please enter your details.</p>
            </div>
        </div>
        <!-- Social Auth -->
        <div class="grid grid-cols-1 gap-gutter">
            <button type="button" class="w-full flex items-center justify-center gap-3 px-6 py-3 border border-outline-variant rounded-lg font-label-md text-label-md text-on-surface-variant bg-surface-container-lowest hover:bg-surface-hover transition-colors duration-150">
                <svg class="w-5 h-5" fill="currentColor" viewbox="0 0 24 24">
                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.042-1.416-4.042-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"></path>
                </svg>
                Continue with GitHub
            </button>
        </div>
        <div class="relative py-2">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-outline-variant"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="bg-background-light px-4 text-on-surface-variant font-label-sm text-label-sm uppercase">Or continue with</span>
            </div>
        </div>
        <!-- Login Form -->
        <form action="{{ route('login') }}" class="space-y-gutter" method="POST">
            @csrf
            <div class="space-y-stack-sm">
                <label class="block font-label-md text-label-md text-on-surface" for="email">Email Address</label>
                <input class="w-full px-4 py-3 bg-surface-container-lowest border border-outline rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-150 outline-none text-on-surface @error('email') border-error @enderror" id="email" name="email" placeholder="developer@example.com" type="email" value="{{ old('email') }}" required/>
                @error('email')
                <p class="text-error font-label-sm text-label-sm flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]" data-icon="error">error</span>
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="space-y-stack-sm">
                <div class="flex justify-between items-center">
                    <label class="block font-label-md text-label-md text-on-surface" for="password">Password</label>
                    <a class="font-label-sm text-label-sm text-primary hover:underline transition-all" href="#">Forgot password?</a>
                </div>
                <div class="relative">
                    <input class="w-full px-4 py-3 bg-surface-container-lowest border border-outline rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-150 outline-none text-on-surface" id="password" name="password" placeholder="••••••••" type="password" required/>
                    <button class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors" id="toggle-password" type="button" aria-label="Show/hide password">
                        <span class="material-symbols-outlined" id="toggle-password-icon" data-icon="visibility">visibility</span>
                    </button>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <input class="w-4 h-4 rounded border-outline text-primary focus:ring-primary" id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}/>
                <label class="font-label-md text-label-md text-on-surface-variant" for="remember">Remember me for 30 days</label>
            </div>
            <button class="w-full bg-primary text-on-primary font-label-md text-label-md py-4 rounded-lg hover:opacity-90 active:opacity-80 transition-all duration-150 shadow-sm" type="submit">
                Sign In
            </button>
        </form>
        <div class="text-center pt-stack-sm">
            <p class="font-body-md text-body-md text-on-surface-variant">
                Don't have an account? 
                <a class="text-primary font-semibold hover:underline" href="{{ route('register') }}">Create an account</a>
            </p>
        </div>
        <!-- Minimal Footer Links -->
        <footer class="pt-stack-lg border-t border-outline-variant flex flex-wrap justify-center md:justify-start gap-gutter">
            <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Privacy Policy</a>
            <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Terms of Service</a>
            <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="{{ route('support') }}">Support</a>
        </footer>
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.getElementById('toggle-password').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('toggle-password-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            passwordInput.type = 'password';
            icon.textContent = 'visibility';
        }
    });
</script>
@endpush
