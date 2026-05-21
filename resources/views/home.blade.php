@extends('layouts.app')

@section('title', 'DevConnect | Community Dashboard')
@section('body-class', 'bg-surface text-on-surface')

@section('content')
<!-- TopNavBar -->
<x-navigation active="feed" class="bg-surface-container-lowest border-b border-border-light" />
<main class="max-w-container-max mx-auto px-margin-desktop py-stack-lg">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-gutter">
        <!-- Left Column (Main Feed) -->
        <section class="lg:col-span-3 space-y-stack-lg">
            <!-- Category Filtering -->
            <div class="flex items-center gap-stack-sm overflow-x-auto pb-2 scrollbar-hide">
                <button class="whitespace-nowrap px-stack-md py-2 bg-primary text-on-primary rounded-full text-label-md font-label-md font-bold">All Topics</button>
                <button class="whitespace-nowrap px-stack-md py-2 bg-surface-container-highest text-on-surface-variant hover:bg-secondary-container transition-colors rounded-full text-label-md font-label-md font-medium">Internet/Web</button>
                <button class="whitespace-nowrap px-stack-md py-2 bg-surface-container-highest text-on-surface-variant hover:bg-secondary-container transition-colors rounded-full text-label-md font-label-md font-medium">Operating Systems</button>
                <button class="whitespace-nowrap px-stack-md py-2 bg-surface-container-highest text-on-surface-variant hover:bg-secondary-container transition-colors rounded-full text-label-md font-label-md font-medium">Mobile Devices</button>
                <button class="whitespace-nowrap px-stack-md py-2 bg-surface-container-highest text-on-surface-variant hover:bg-secondary-container transition-colors rounded-full text-label-md font-label-md font-medium">User Reviews</button>
            </div>
            <!-- Trending Blog Posts Feed -->
            <div class="space-y-stack-md">
                <!-- Post Card 1 -->
                <article class="group bg-surface-container-lowest border border-border-light rounded-xl overflow-hidden flex flex-col md:flex-row hover:shadow-lg transition-all duration-300">
                    <div class="md:w-64 h-48 md:h-auto overflow-hidden">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" data-alt="A high-quality top-down photo of a developer's workspace..." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAdA8VWix3PUFWD42jCNKrnd6Fm7xOddh4qbiygSrLeJkL1empJw8g_bIXbtYNxIaYawkVyyZDf3yJV4sVUx51kJRErlV0yqvGliG7sA1wkS9TdBXI5jGIIQtEZRJZ7DzQcsXU3OizgTeEs7Y2ffT3TvC9uUQxlRSJeuZDtP3cj6YxysWpi1yfT6V7EH5K0VqltlmSvFtR_1-Xc1ost1I-tn9f-9XZex_lFzBmkt-LnEX9UAcUi7edIfPvQKQABik_4ob9cTFYAatQ"/>
                    </div>
                    <div class="p-stack-md flex flex-col justify-between flex-1">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="bg-primary-fixed text-on-primary-fixed-variant px-2 py-0.5 rounded text-label-sm font-label-sm">Web Development</span>
                                <span class="text-outline text-label-sm font-label-sm">5 min read</span>
                            </div>
                            <h3 class="text-headline-md font-headline-md text-on-surface group-hover:text-primary transition-colors">
                                <a href="{{ route('blog.show', 1) }}">The Future of Edge Computing in Modern Web Frameworks</a>
                            </h3>
                            <p class="text-body-md font-body-md text-on-surface-variant line-clamp-2 mt-2">Exploring how edge computing is redefining the limits of latency and user experience in the next generation of web applications...</p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center gap-3">
                                <img alt="Author avatar" class="w-8 h-8 rounded-full" data-alt="A detailed digital illustration of a female software engineer's profile avatar..." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDvJbJyU0-zx7RUYmkBEu7k0RxVCyA3-jgOxVAZWSZW5iTwUktVZCwvb48KN0M_pZAeRqRvBhJL4EkgKsWoF06oBBYlsqKvWwXldCMXthPEiRcEWlGRG3RxzjzHWaz3WKX618qm8FQdg7XLWY8RPWWp_0uptR7OoaA0RZcMpDQigkVr2KJJNY-quXycu6-PQ7si2V24SMrQnolu1Mh0mrNAz0CRdK6CuyykacXaFs0nhm7DRNlkPHM2YcmaWRn4yKI26J_Z6KjqxoE"/>
                                <div>
                                    <p class="text-label-md font-label-md font-bold text-on-surface">Sarah Drasner</p>
                                    <p class="text-label-sm font-label-sm text-outline">Oct 12, 2026</p>
                                </div>
                            </div>
                            <button class="material-symbols-outlined text-outline hover:text-primary" data-icon="bookmark">bookmark</button>
                        </div>
                    </div>
                </article>
                <!-- Post Card 2 -->
                <article class="group bg-surface-container-lowest border border-border-light rounded-xl overflow-hidden flex flex-col md:flex-row hover:shadow-lg transition-all duration-300">
                    <div class="md:w-64 h-48 md:h-auto overflow-hidden">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" data-alt="A minimalist tech-themed workspace featuring vintage hardware..." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDLkQWRgIQsSXh1kjJCw_uCPzWhqMccsLL9qLCWTTlMSYmaTn_EYEH10A9wfLAMahdS7vvyvFuAyaTmOMKvCfrRL7fMr94M3oLJIZ9DxKUOcZmQ1YDwUwbuogw56deRUAKaCj_zm2uN73vsdvSusy2s4kfxro2LcxHpGNYWswIQvhRrb5OHn58zGffrGpdC4oI5ht0P_GVIFXJnvdkdXk8jhkR22aoZzWdtxt16w9EAB7FTAwaSGJ1Uk9i60JwQrIjG92lVD0_vpvc"/>
                    </div>
                    <div class="p-stack-md flex flex-col justify-between flex-1">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="bg-secondary-container text-on-secondary-container px-2 py-0.5 rounded text-label-sm font-label-sm">Hardware</span>
                                <span class="text-outline text-label-sm font-label-sm">8 min read</span>
                            </div>
                            <h3 class="text-headline-md font-headline-md text-on-surface group-hover:text-primary transition-colors">
                                <a href="{{ route('blog.show', 2) }}">Rust for Linux: A New Era of Kernel Development?</a>
                            </h3>
                            <p class="text-body-md font-body-md text-on-surface-variant line-clamp-2 mt-2">Diving deep into the implications of memory safety in the world's most critical operating system kernel and what it means for C developers.</p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center gap-3">
                                <img alt="Author avatar" class="w-8 h-8 rounded-full" data-alt="A professional male developer's profile avatar..." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDx1iWV36pxyGIifWKGbyW7_ll5zRKic7PS1jGLh8baueoYhx6O1Z-OnUTn6p_TXI3tMYU60LxgG3M_bcmXrfF7-_hWhi8Qm076BoPom5SwIHC3-zk61AdBUYnId6NVmril5Tub05aMwgsa63MiVZH0CYIXXhTw7ChluD55MBjQx3_V2OE9Vke971ATdVmyVqGwHlHK_c7jpgAMc4p8L-ogzjufU-CLT_hnBY7i3InAh17jmg64VcliZx6YAY4P8NC9Eo3_Rh-Pfws"/>
                                <div>
                                    <p class="text-label-md font-label-md font-bold text-on-surface">James Quick</p>
                                    <p class="text-label-sm font-label-sm text-outline">Oct 11, 2026</p>
                                </div>
                            </div>
                            <button class="material-symbols-outlined text-outline hover:text-primary" data-icon="bookmark">bookmark</button>
                        </div>
                    </div>
                </article>
            </div>
        </section>
        <!-- Right Column (Sidebar) -->
        <aside class="space-y-stack-lg">
            <!-- Action Button -->
            <a href="{{ route('blog.create') }}" class="w-full bg-primary text-on-primary py-4 rounded-xl font-bold shadow-md hover:opacity-90 transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined" data-icon="add_circle">add_circle</span>
                Create Post
            </a>
            <!-- New Topics -->
            <div class="bg-surface-container-low border border-border-light rounded-xl p-stack-md">
                <div class="flex items-center justify-between mb-stack-md">
                    <h4 class="text-headline-md font-headline-md text-on-surface">New Topics</h4>
                    <span class="material-symbols-outlined text-outline" data-icon="forum">forum</span>
                </div>
                <ul class="space-y-4">
                    <li class="group cursor-pointer">
                        <p class="text-label-md font-label-md font-bold text-on-surface group-hover:text-primary transition-colors">
                            <a href="{{ route('forum.thread', 1) }}">How to scale PostgreSQL for 1M+ users?</a>
                        </p>
                        <div class="flex items-center mt-2 gap-stack-sm">
                            <div class="flex -space-x-2">
                                <img alt="User" class="w-5 h-5 rounded-full border border-surface" src="https://lh3.googleusercontent.com/aida-public/AB6AXuChgzVl7eAK46YqSsPD7US1FcK9bD8nxfBwwOU49ARdzFtcFDlCqFf71L4gRFw5POj4gJaA22CXf8H4I5UxDBe5rqHsMhIhfdyojh2aaup9C-jaUYAD1LrmaCyyUc6lC3DuOd4-4qZcx_kY1uXFMF9NGa4FLPz1wBTKT4XrWFxttdItYxYo-xzpcQV_57nW8GEIhJedHWxGc_utPhLKru5GMcfNrrFvP5iaWXD80YUni9JlIA1iu8D7-WORnrR9PIG2T2DqKDlfhMo"/>
                                <img alt="User" class="w-5 h-5 rounded-full border border-surface" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAJ9yV_ZTSwoZ8XLg2LnYtjYYeov8Z1-W3A8q4C1RSFs6XTA0bw7aBGSOcXXuQx1wHeYfyqc0YIFTMpZ2J7SquMemmYovk6HDmqO7eofZB5aN9hyUabHTOYal2LzpBcOyGEj_E6-U38IfRVTk-GVGR6CmYE7Bfe6mIQqGSW0KSPvhdeLggp3bA01iMIK1tHMLENzh6s5YPABqgZcAN202sRdB3hPQAQ-YGcNzNviX6c090mTPBfAi5EgZy0W-scOh-z58hmjM38P-o"/>
                                <img alt="User" class="w-5 h-5 rounded-full border border-surface" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDLFXmtahzvODvAN1xN5iV0_-snWgGTXUoGSfzfHKMD-iVmE4_wWC5i9giz_CTsB3D1oqB3dCLO2fDMC-kjjhRaMe-r3IJjfPB8hDtTWsfjCLFg9Sk0TromKXvbUto2NhCArXeduUgI3iwhpF8kaDvD1fRCtI3fueDT8JaA02DoySNIII9uyrCWd4oTz5I9Q5PP-z3XKX8hE2mkLzTqNeQAtGICn5Y44Z57LcDqkArmWc5t49Ku5bSBHFdvqAaZT3si8pMNvMsg0s4"/>
                            </div>
                            <span class="text-label-sm font-label-sm text-outline">12 participants</span>
                        </div>
                    </li>
                    <li class="group cursor-pointer">
                        <p class="text-label-md font-label-md font-bold text-on-surface group-hover:text-primary transition-colors">
                            <a href="{{ route('forum.thread', 2) }}">Best practices for React Server Components?</a>
                        </p>
                        <div class="flex items-center mt-2 gap-stack-sm">
                            <div class="flex -space-x-2">
                                <img alt="User" class="w-5 h-5 rounded-full border border-surface" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBvti0vRk9dhFBcQarudYwWbwmd9slHV4dD15YBHu8ReIaSliqz00lGe1tk-6R6FwUfGNTMR_2ZvoA0G6Okiu_QcvrJ9NyP8BNLlFHDjdsPTi-v74TNw3EOigHJolHksURW1CmhfC6_beq-9bTzmwvcjj74Z8Vs4q90fjjBTjcujxxQrIDghrqh2dhJ5ss7YeqDaH6A3x8RNTRSdXKPE3-J6KfIU35N0EQiPzciS-2EitH2aXdVdt1i0F8Y67HpTTdhn0rL8tN2uWc"/>
                                <img alt="User" class="w-5 h-5 rounded-full border border-surface" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCatIoPpMyWSeWELXS9v9-d-zyJDkRZ3eves45w5Tyrl_zcbvCH-J9W5K3ubM0JZxfuJTvfblZvJwTpliaPNpydI1HSUpciYJc7lMTZcH8XWRc8y8tKw48BaTlCVbyrQ9osoIUHTOZhcFCAtwwk1EkTFwz374SP9_UUkzbXTjoSf84jLPFG8VRK03SbXoDiFZ89g4vB2jlBz0FuNBAmcHohiBVL6E-0SAUSofh1VY8yWDB-KHikQqHJl28FG_ZO5HMf_voU1BG37lA"/>
                            </div>
                            <span class="text-label-sm font-label-sm text-outline">8 participants</span>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- Recent Comments -->
            <div class="bg-surface-container-low border border-border-light rounded-xl p-stack-md">
                <h4 class="text-headline-md font-headline-md text-on-surface mb-stack-md">Recent Activity</h4>
                <div class="space-y-stack-md">
                    <div class="flex gap-3">
                        <img alt="User" class="w-6 h-6 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC4g1_3C_3dfx7Ws7jLqzZ5JcjElh2KEtQhhiLz_0T3Ykh2ZZHqdz4ZBfbGezFbI2WEsz7yHasazuAPlMNVy-qJCTmrxZYJQwh9AQFvZ7-I6v5ppO6-4vZRpIC-zDuKdg9T3ocrR1Xx9R3kLeiURj0_7J26YeIDRkD-yy3cKwmTwXyyVQJqRXBc7CzhMDRY3TfbL-G7UtzR2r5Nvf6YDjdZHjB4m7KHxNtsyGdEe7_cKQBK1vqrurpXgbwo31G2jI3zxM2JyjGpUWU"/>
                        <div>
                            <p class="text-label-md font-label-md text-on-surface-variant">
                                <span class="font-bold text-on-surface">Alex M.</span> commented on <span class="text-primary font-medium">Dark Mode CSS</span>
                            </p>
                            <p class="text-label-sm font-label-sm text-outline">2 minutes ago</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <img alt="User" class="w-6 h-6 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCMgZ3EGpNV4mhiV3dBkSB6T7UG2-_c75BZD4Eu1bBcct204anB8v1eJctEx69LYkywY6IcLDWeCjA4onT-z-5CNlWQHIvbX4kjxOce3cKgOlkRI6txwWFQbtQrCfZciIvCj57IG3gw4WT-HHPZdf3KYvuwCUA9ZnThDzhEvX9umGSgTgWU99LIdFWrtph3u_agDBKBeomxoQqrSVAx_UsYl472_Y-SH3toPOa_8BdpnvXGy5C_eu10FSYe179DJHuLKZbeTp0SZ34"/>
                        <div>
                            <p class="text-label-md font-label-md text-on-surface-variant">
                                <span class="font-bold text-on-surface">Kevin L.</span> started a discussion in <span class="text-primary font-medium">Operating Systems</span>
                            </p>
                            <p class="text-label-sm font-label-sm text-outline">15 minutes ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</main>
<!-- Footer / Blog Statistics Widget -->
<section class="bg-surface-container-low border-t border-border-light mt-stack-lg py-stack-lg">
    <div class="max-w-container-max mx-auto px-margin-desktop">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-gutter text-center">
            <div class="p-stack-md rounded-xl bg-surface-container-lowest border border-border-light">
                <p class="text-label-md font-label-md text-outline uppercase tracking-wider">Total Members</p>
                <p class="text-headline-xl font-headline-xl text-primary mt-1">12,482</p>
                <div class="h-1 w-12 bg-primary-fixed mx-auto mt-2 rounded-full"></div>
            </div>
            <div class="p-stack-md rounded-xl bg-surface-container-lowest border border-border-light">
                <p class="text-label-md font-label-md text-outline uppercase tracking-wider">Active Discussions</p>
                <p class="text-headline-xl font-headline-xl text-primary mt-1">1,054</p>
                <div class="h-1 w-12 bg-primary-fixed mx-auto mt-2 rounded-full"></div>
            </div>
            <div class="p-stack-md rounded-xl bg-surface-container-lowest border border-border-light">
                <p class="text-label-md font-label-md text-outline uppercase tracking-wider">Articles Published</p>
                <p class="text-headline-xl font-headline-xl text-primary mt-1">456</p>
                <div class="h-1 w-12 bg-primary-fixed mx-auto mt-2 rounded-full"></div>
            </div>
            <div class="p-stack-md rounded-xl bg-surface-container-lowest border border-border-light">
                <p class="text-label-md font-label-md text-outline uppercase tracking-wider">Solution Rate</p>
                <p class="text-headline-xl font-headline-xl text-primary mt-1">94%</p>
                <div class="h-1 w-12 bg-primary-fixed mx-auto mt-2 rounded-full"></div>
            </div>
        </div>
    </div>
</section>
<x-footer class="bg-surface-container-low border-t-0 mt-0" />
@endsection
