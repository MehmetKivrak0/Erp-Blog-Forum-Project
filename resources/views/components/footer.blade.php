@props([
    'brand' => 'DevConnect'
])

<footer {{ $attributes->merge(['class' => 'bg-surface-container border-t border-outline-variant']) }}>
    <div class="flex flex-col md:flex-row justify-between items-center w-full py-stack-lg px-margin-desktop max-w-container-max mx-auto">
        <div class="flex flex-col items-center md:items-start gap-2 mb-6 md:mb-0">
            <a href="{{ route('home') }}" class="font-headline-sm text-headline-sm font-bold text-on-surface text-decoration-none">{{ $brand }}</a>
            <p class="text-label-sm font-label-sm text-on-secondary-container">© {{ date('Y') }} {{ $brand }} Community. All rights reserved.</p>
        </div>
        <div class="flex flex-wrap justify-center gap-6">
            <a class="text-on-secondary-container hover:text-primary transition-colors font-label-sm text-label-sm text-decoration-none" href="#">Code of Conduct</a>
            <a class="text-on-secondary-container hover:text-primary transition-colors font-label-sm text-label-sm text-decoration-none" href="#">Privacy Policy</a>
            <a class="text-on-secondary-container hover:text-primary transition-colors font-label-sm text-label-sm text-decoration-none" href="#">Terms of Service</a>
            <a class="text-on-secondary-container hover:text-primary transition-colors font-label-sm text-label-sm text-decoration-none" href="{{ route('support') }}">Contact</a>
            <a class="text-on-secondary-container hover:text-primary transition-colors font-label-sm text-label-sm text-decoration-none" href="#">GitHub</a>
        </div>
    </div>
</footer>
