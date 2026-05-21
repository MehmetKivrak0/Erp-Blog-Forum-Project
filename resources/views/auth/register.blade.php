@extends('layouts.app')

@section('title', 'Register | DevConnect')
@section('body-class', 'bg-background-light text-on-background selection:bg-primary-container selection:text-white')

@push('styles')
    <style>
        .password-step { transition: all 0.3s ease; }
        .bg-indigo-600 { background-color: #4f46e5; }
        .hover\:bg-indigo-700:hover { background-color: #4338ca; }
    </style>
@endpush

@section('content')
<!-- Registration Page Wrapper: Split Screen -->
<main class="min-h-screen flex flex-col md:flex-row">
<!-- Left Section: Abstract Tech Art Overlay -->
<section class="relative hidden md:flex md:w-1/2 bg-background-dark overflow-hidden items-center justify-center">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0 opacity-60">
        <img alt="" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida/ADBb0ugZV6hNPPzluXl_0VhDMJNVtIV43KhEPmt3QFndn4IoEbaerQAOFv759LGza0Wwfx3ctvdUuxvnPOlpvsV9S86doWCp5vfyrVekWwsGkbSbLxCAfa55tnZh1T163YgDy54rWr-DQrP5XCezAhHjipJ9zpmG4ba0KQalYpyi8dET1Oy74Z_Mz8wxqluesX6NBjZ8nPg6JrWTEi0y3ZtXu8d2APECMMDopv6oe7Q7LMEZ5QrYFALUt-88Nto"/>
    </div>
    <!-- Overlay Gradient for Readability -->
    <div class="absolute inset-0 bg-gradient-to-t from-background-dark via-transparent to-background-dark/30 z-10"></div>
    <!-- Content Overlay -->
    <div class="relative z-20 px-margin-desktop max-w-lg text-center md:text-left">
        <h1 class="font-headline-xl text-headline-xl text-white mb-stack-md leading-tight">
            Join the community of builders.
        </h1>
        <p class="font-body-lg text-body-lg text-outline-variant opacity-90">
            Unlock access to collaborative discussions, exclusive technical articles, and a global network of elite software engineers.
        </p>
        <!-- Subtle Grid/Tech Accent -->
        <div class="mt-12 flex space-x-6 opacity-40">
            <div class="h-1 w-12 bg-primary"></div>
            <div class="h-1 w-12 bg-outline"></div>
            <div class="h-1 w-12 bg-outline"></div>
        </div>
    </div>
</section>
<!-- Right Section: Registration Form -->
<section class="w-full md:w-1/2 bg-surface-container-lowest flex flex-col justify-between min-h-screen overflow-y-auto px-6 py-12 md:px-20 lg:px-32">
    <!-- Header / Logo -->
    <header class="mb-stack-lg">
        <div class="flex items-center space-x-2">
            <a href="{{ route('home') }}" class="font-headline-lg text-headline-lg font-bold text-primary hover:opacity-90">DevConnect</a>
        </div>
    </header>
    <!-- Main Form Area -->
    <div class="flex-grow flex flex-col justify-center max-w-md w-full mx-auto">
        <div class="mb-stack-lg">
            <h2 class="font-headline-xl-mobile md:font-headline-xl text-headline-xl-mobile md:text-headline-xl text-on-surface mb-2">Create your account</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Join over 12,000 developers worldwide.</p>
        </div>
        <!-- Social Login -->
        <button class="w-full py-3 px-4 border border-border-light rounded-lg flex items-center justify-center space-x-3 hover:bg-surface-hover transition-all duration-150 mb-6 group">
            <svg class="w-5 h-5 fill-on-surface group-hover:fill-primary transition-colors" viewbox="0 0 24 24">
                <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"></path>
            </svg>
            <span class="font-label-md text-label-md font-semibold">Continue with GitHub</span>
        </button>
        <!-- Divider -->
        <div class="relative mb-6">
            <div aria-hidden="true" class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-border-light"></div>
            </div>
            <div class="relative flex justify-center text-label-sm uppercase">
                <span class="bg-surface-container-lowest px-4 text-on-surface-variant font-label-sm tracking-wider">OR REGISTER WITH EMAIL</span>
            </div>
        </div>
        <!-- Registration Form -->
        <form class="space-y-4" id="registration-form" method="POST" action="{{ route('register') }}">
            @csrf
            <div>
                <label class="block font-label-sm text-on-surface-variant mb-1" for="full-name">Full Name</label>
                <input class="w-full px-4 py-3 bg-surface border border-border-light rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none text-on-surface" id="full-name" name="name" placeholder="John Doe" required="" type="text"/>
            </div>
            <div>
                <label class="block font-label-sm text-on-surface-variant mb-1" for="email">Email Address</label>
                <input class="w-full px-4 py-3 bg-surface border border-border-light rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none text-on-surface" id="email" name="email" placeholder="john@example.com" required="" type="email"/>
            </div>
            <div class="relative">
                <label class="block font-label-sm text-on-surface-variant mb-1" for="password">Password</label>
                <input class="w-full px-4 py-3 bg-surface border border-border-light rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none text-on-surface" id="password" name="password" oninput="updatePasswordStrength(this.value)" placeholder="••••••••" required="" type="password"/>
                <!-- Strength Indicator -->
                <div class="mt-2 flex space-x-1 h-1.5 w-full bg-surface-container-high rounded-full overflow-hidden">
                    <div class="password-step w-1/4 h-full bg-surface-container-highest" id="strength-1"></div>
                    <div class="password-step w-1/4 h-full bg-surface-container-highest" id="strength-2"></div>
                    <div class="password-step w-1/4 h-full bg-surface-container-highest" id="strength-3"></div>
                    <div class="password-step w-1/4 h-full bg-surface-container-highest" id="strength-4"></div>
                </div>
                <p class="text-[10px] uppercase font-bold mt-1 text-on-surface-variant/60 tracking-wider" id="strength-text">Strength: None</p>
            </div>
            <div class="flex items-start pt-2">
                <div class="flex items-center h-5">
                    <input class="h-4 w-4 text-primary focus:ring-primary border-border-light rounded" id="terms" name="terms" required="" type="checkbox"/>
                </div>
                <div class="ml-3 text-sm">
                    <label class="font-body-md text-on-surface-variant" for="terms">
                        I agree to the <a class="text-primary hover:underline" href="#">Terms of Service</a> and <a class="text-primary hover:underline" href="#">Privacy Policy</a>.
                    </label>
                </div>
            </div>
            <button class="w-full py-4 bg-indigo-600 text-white font-headline-md rounded-lg shadow-sm hover:bg-indigo-700 hover:shadow-md active:scale-[0.98] transition-all duration-200 mt-4" type="submit">
                Sign Up
            </button>
        </form>
        <p class="mt-8 text-center font-body-md text-on-surface-variant">
            Already have an account? 
            <a class="text-primary font-semibold hover:underline" href="{{ route('login') }}">Sign In</a>
        </p>
    </div>
    <!-- Footer Bottom Links -->
    <footer class="mt-12 pt-8 border-t border-border-light flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
        <div class="flex space-x-6">
            <a class="font-label-sm text-secondary hover:text-primary transition-colors" href="#">Privacy Policy</a>
            <a class="font-label-sm text-secondary hover:text-primary transition-colors" href="#">Terms</a>
            <a class="font-label-sm text-secondary hover:text-primary transition-colors" href="{{ route('support') }}">Support</a>
        </div>
        <p class="font-label-sm text-outline">© 2026 DevConnect</p>
    </footer>
</section>
</main>
@endsection

@push('scripts')
<script>
    window.updatePasswordStrength = function(val) {
      const steps = [
        document.getElementById('strength-1'),
        document.getElementById('strength-2'),
        document.getElementById('strength-3'),
        document.getElementById('strength-4')
      ];
      const strengthText = document.getElementById('strength-text');
      
      let strength = 0;
      if (val.length > 0) strength = 1;
      if (val.length > 5) strength = 2;
      if (val.length > 8 && /[0-9]/.test(val)) strength = 3;
      if (val.length > 10 && /[A-Z]/.test(val) && /[^A-Za-z0-9]/.test(val)) strength = 4;

      const colors = ['#e4e1ee', '#ef4444', '#f59e0b', '#3b82f6', '#10b981'];
      const labels = ['None', 'Weak', 'Fair', 'Good', 'Strong'];

      steps.forEach((step, index) => {
        if (index < strength) {
          step.style.backgroundColor = colors[strength];
        } else {
          step.style.backgroundColor = '#e4e1ee';
        }
      });
      
      strengthText.innerText = `Strength: ${labels[strength]}`;
      strengthText.style.color = strength === 0 ? '#464555' : colors[strength];
    }

    document.getElementById('registration-form').addEventListener('submit', function(e) {
      const btn = this.querySelector('button[type="submit"]');
      btn.innerText = 'Creating Account...';
      btn.disabled = true;
      btn.classList.add('opacity-80', 'cursor-not-allowed');
    });
</script>
@endpush
