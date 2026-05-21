@extends('layouts.app')

@section('title', 'Support & Help Center | DevConnect')
@section('body-class', 'bg-background text-on-background font-body-md min-h-screen flex flex-col')

@push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
          width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
          background-color: #777587;
          border-radius: 10px;
        }
    </style>
@endpush

@section('content')
<!-- TopNavBar -->
<x-navigation active="support" class="w-full bg-background border-b border-outline-variant sticky top-0" />
<main class="flex-grow">
    <!-- Breadcrumbs -->
    <nav class="max-w-container-max mx-auto px-margin-desktop py-4 flex items-center gap-2 text-label-md font-label-md text-on-surface-variant">
        <a class="hover:text-primary transition-colors" href="{{ route('home') }}">Home</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-primary font-bold">Support</span>
    </nav>
    <!-- Hero Section -->
    <section class="max-w-container-max mx-auto px-margin-desktop py-stack-lg">
        <div class="bg-surface-container-low rounded-xl p-stack-lg flex flex-col items-center text-center gap-stack-md border border-outline-variant">
            <h1 class="text-headline-xl font-headline-xl text-on-surface">How can we help?</h1>
            <p class="text-body-lg font-body-lg text-on-surface-variant max-w-2xl">Search our documentation or browse FAQs to find quick answers to common developer questions.</p>
            <div class="w-full max-w-2xl relative mt-4">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span>
                <input class="w-full pl-12 pr-4 py-4 rounded-lg border border-outline bg-surface-container-lowest focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none text-body-md font-body-md" placeholder="Search keywords like 'API key', 'billing', 'git integration'..." type="text"/>
            </div>
        </div>
    </section>
    <!-- FAQ Accordion Section -->
    <section class="max-w-container-max mx-auto px-margin-desktop py-stack-lg">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
            <!-- FAQ Categories & Accordion -->
            <div class="lg:col-span-8 space-y-gutter">
                <h2 class="text-headline-md font-headline-md text-on-surface">Frequently Asked Questions</h2>
                <!-- Category: Account -->
                <div class="space-y-stack-sm">
                    <h3 class="text-label-md font-label-md text-primary uppercase tracking-wider px-2">Account</h3>
                    <div class="space-y-2">
                        <details class="group bg-white border border-outline-variant rounded-lg overflow-hidden hover:border-primary transition-colors">
                            <summary class="flex items-center justify-between p-4 cursor-pointer list-none text-body-md font-semibold text-on-surface">
                                How do I reset my multi-factor authentication?
                                <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                            </summary>
                            <div class="px-4 pb-4 text-on-surface-variant text-body-md border-t border-outline-variant pt-4">
                                You can reset your MFA settings through the Security tab in your Profile settings. If you have lost access to your recovery codes, please use the 'Submit a Ticket' form below and select 'Account Recovery' as the category.
                            </div>
                        </details>
                        <details class="group bg-white border border-outline-variant rounded-lg overflow-hidden hover:border-primary transition-colors">
                            <summary class="flex items-center justify-between p-4 cursor-pointer list-none text-body-md font-semibold text-on-surface">
                                Can I merge two different DevConnect profiles?
                                <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                            </summary>
                            <div class="px-4 pb-4 text-on-surface-variant text-body-md border-t border-outline-variant pt-4">
                                Profile merging is currently handled manually by our support team to ensure data integrity. Please provide the email addresses for both accounts in a support ticket.
                            </div>
                        </details>
                    </div>
                </div>
                <!-- Category: Technical -->
                <div class="space-y-stack-sm">
                    <h3 class="text-label-md font-label-md text-primary uppercase tracking-wider px-2">Technical</h3>
                    <div class="space-y-2">
                        <details class="group bg-white border border-outline-variant rounded-lg overflow-hidden hover:border-primary transition-colors">
                            <summary class="flex items-center justify-between p-4 cursor-pointer list-none text-body-md font-semibold text-on-surface">
                                Rate limiting for DevConnect API v2
                                <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                            </summary>
                            <div class="px-4 pb-4 text-on-surface-variant text-body-md border-t border-outline-variant pt-4">
                                Standard developer accounts are limited to 5,000 requests per hour. If you require higher throughput for your enterprise application, please check our documentation on quota increases.
                            </div>
                        </details>
                        <details class="group bg-white border border-outline-variant rounded-lg overflow-hidden hover:border-primary transition-colors">
                            <summary class="flex items-center justify-between p-4 cursor-pointer list-none text-body-md font-semibold text-on-surface">
                                Webhook delivery failures and retries
                                <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                            </summary>
                            <div class="px-4 pb-4 text-on-surface-variant text-body-md border-t border-outline-variant pt-4">
                                We use an exponential backoff strategy for failed webhook deliveries. We will attempt to deliver the payload 8 times over a 24-hour period before marking the delivery as failed.
                            </div>
                        </details>
                    </div>
                </div>
            </div>
            <!-- Support Sidecard -->
            <div class="lg:col-span-4 space-y-gutter">
                <div class="bg-primary-container text-on-primary-container p-6 rounded-xl shadow-sm space-y-4">
                    <h3 class="text-headline-md font-headline-md">Developer Portal</h3>
                    <p class="text-body-md opacity-90">Access our technical documentation, SDKs, and API references directly.</p>
                    <button class="w-full py-3 px-4 bg-white text-primary font-bold rounded-lg hover:bg-opacity-90 transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">terminal</span>
                        Go to Docs
                    </button>
                </div>
                <div class="border border-outline-variant p-6 rounded-xl space-y-4 bg-surface-container-lowest">
                    <h3 class="text-label-md font-label-md text-on-surface-variant uppercase tracking-widest">Community Status</h3>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-body-md font-semibold text-on-surface">All Systems Operational</span>
                    </div>
                    <p class="text-label-sm font-label-sm text-on-surface-variant">Last updated 5 minutes ago</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Ticket Submission Form -->
    <section class="max-w-container-max mx-auto px-margin-desktop py-stack-lg">
        <div class="bg-white border border-outline-variant rounded-xl overflow-hidden shadow-sm">
            <div class="p-8 border-b border-outline-variant bg-surface-container-low">
                <h2 class="text-headline-lg font-headline-lg text-on-surface">Submit a Ticket</h2>
                <p class="text-body-md font-body-md text-on-surface-variant">Can't find what you're looking for? Our developer advocates are here to help.</p>
            </div>
            <form action="{{ route('support.submit') }}" class="p-8 grid grid-cols-1 md:grid-cols-2 gap-stack-lg" method="POST">
                @csrf
                <!-- Subject -->
                <div class="md:col-span-2 flex flex-col gap-2">
                    <label class="text-label-md font-label-md text-on-surface">Subject</label>
                    <input class="w-full p-3 rounded border border-outline-variant bg-surface-container-lowest focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-on-surface" name="subject" placeholder="Summary of the issue..." required="" type="text"/>
                </div>
                <!-- Category -->
                <div class="flex flex-col gap-2">
                    <label class="text-label-md font-label-md text-on-surface">Category</label>
                    <div class="relative">
                        <select class="w-full p-3 rounded border border-outline-variant bg-surface-container-lowest focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none cursor-pointer text-on-surface" name="category">
                            <option value="technical">Technical Issue</option>
                            <option value="account">Account &amp; Security</option>
                            <option value="billing">Billing &amp; Subscription</option>
                            <option value="community">Community Guidelines</option>
                            <option value="feedback">Product Feedback</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
                    </div>
                </div>
                <!-- Priority -->
                <div class="flex flex-col gap-2">
                    <label class="text-label-md font-label-md text-on-surface">Priority</label>
                    <div class="flex gap-4 items-center h-full">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input class="w-4 h-4 text-primary focus:ring-primary" name="priority" type="radio" value="low"/>
                            <span class="text-body-md group-hover:text-primary transition-colors text-on-surface">Low</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input checked="" class="w-4 h-4 text-primary focus:ring-primary" name="priority" type="radio" value="medium"/>
                            <span class="text-body-md group-hover:text-primary transition-colors text-on-surface">Medium</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input class="w-4 h-4 text-primary focus:ring-primary" name="priority" type="radio" value="high"/>
                            <span class="text-body-md group-hover:text-primary transition-colors text-on-surface">High</span>
                        </label>
                    </div>
                </div>
                <!-- Message -->
                <div class="md:col-span-2 flex flex-col gap-2">
                    <label class="text-label-md font-label-md text-on-surface">Detailed Message</label>
                    <textarea class="w-full p-3 rounded border border-outline-variant bg-surface-container-lowest focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all resize-none text-on-surface" name="message" placeholder="Describe your technical challenge, provide error logs, or share steps to reproduce..." required="" rows="6"></textarea>
                </div>
                <!-- File Upload -->
                <div class="md:col-span-2 flex flex-col gap-2">
                    <label class="text-label-md font-label-md text-on-surface">Screenshots / Attachments</label>
                    <div class="border-2 border-dashed border-outline-variant rounded-lg p-8 flex flex-col items-center justify-center gap-4 bg-surface-container-lowest hover:bg-surface-container-low transition-colors cursor-pointer">
                        <span class="material-symbols-outlined text-[48px] text-outline">cloud_upload</span>
                        <div class="text-center">
                            <p class="text-body-md font-semibold text-on-surface">Click to upload or drag and drop</p>
                            <p class="text-label-sm text-on-surface-variant">PNG, JPG, PDF, or TXT up to 10MB</p>
                        </div>
                        <input class="hidden" type="file"/>
                    </div>
                </div>
                <!-- Submit Button -->
                <div class="md:col-span-2 flex justify-end">
                    <button class="bg-primary text-white py-3 px-8 rounded-lg font-bold hover:bg-opacity-90 active:scale-95 transition-all shadow-md flex items-center gap-2" type="submit">
                        <span class="material-symbols-outlined">send</span>
                        Submit Support Request
                    </button>
                </div>
            </form>
        </div>
    </section>
    <!-- Success Message (shown after form submission) -->
    @if(session('success'))
    <div class="max-w-2xl mx-auto my-stack-lg p-8 bg-emerald-50 border border-emerald-200 rounded-xl text-center space-y-4">
        <span class="material-symbols-outlined text-[64px] text-emerald-600">check_circle</span>
        <h3 class="text-headline-lg font-headline-lg text-emerald-900">Talebiniz Alındı</h3>
        <p class="text-body-md text-emerald-800">{{ session('success') }}</p>
    </div>
    @endif
</main>
<!-- Footer -->
<x-footer class="w-full py-stack-lg mt-auto bg-surface-container-low border-t border-outline-variant" />
@endsection
