<footer id="luxury-footer"
    class="relative mt-32
    bg-white
    dark:bg-gray-900
    text-gray-900 dark:text-gray-400
    border-t border-gray-300 dark:border-gray-800
    overflow-hidden transition-all duration-700">

    <div class="relative max-w-7xl mx-auto px-6 py-20 md:py-28">

        <div class="grid gap-16 md:grid-cols-2 lg:grid-cols-3
                    opacity-0 translate-y-10 transition-all duration-1000 ease-out"
            id="footer-content">

            {{-- BRAND --}}
            <div class="space-y-6 text-center md:text-left">

                <div class="flex flex-col md:flex-row items-center md:items-start gap-4">

                    <img src="{{ asset('images/logos/logo.png') }}"
                        class="h-14 w-auto object-contain hidden dark:block">

                    <div>
                        <h3 class="text-3xl font-serif tracking-tight text-gray-900 dark:text-white">
                            Aventura506
                        </h3>

                        <p class="text-xs uppercase tracking-[0.3em]
                           text-black dark:text-gray-400 mt-1">
                            {{ __('footer.tagline') }}
                        </p>
                    </div>

                </div>

                <p class="text-sm leading-relaxed max-w-sm mx-auto md:mx-0 font-light
                          text-gray-800 dark:text-gray-400">
                    {{ __('footer.description') }}
                </p>

                {{-- SOCIAL --}}
                <div class="flex justify-center md:justify-start gap-6 pt-4
            text-black dark:text-gray-400">

                    {{-- FACEBOOK --}}
                    <a href="#"
                        target="_blank"
                        class="transition duration-300 hover:-translate-y-1 hover:text-green-600 dark:hover:text-green-400">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="w-5 h-5">

                            <path d="M22 12.073C22 6.477 17.523 2 12 2S2 6.477 
                     2 12.073c0 4.991 3.657 9.128 8.438 
                     9.878v-6.99H8.078v-2.888h2.36V9.845
                     c0-2.327 1.385-3.616 3.506-3.616
                     .996 0 2.038.178 2.038.178v2.24
                     h-1.148c-1.13 0-1.482.705-1.482 
                     1.428v1.713h2.522l-.403 
                     2.888h-2.119v6.99C18.343 21.2 
                     22 17.063 22 12.073z" />
                        </svg>

                    </a>


                    {{-- INSTAGRAM --}}
                    <a href="#"
                        target="_blank"
                        class="transition duration-300 hover:-translate-y-1 hover:text-green-600 dark:hover:text-green-400">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="w-5 h-5">

                            <path d="M7.75 2C4.575 2 2 4.575 
                     2 7.75v8.5C2 19.425 4.575 
                     22 7.75 22h8.5C19.425 22 
                     22 19.425 22 16.25v-8.5
                     C22 4.575 19.425 2 
                     16.25 2h-8.5zM12 
                     7a5 5 0 110 10 
                     5 5 0 010-10zm5.5-.5
                     a1 1 0 110 2 
                     1 1 0 010-2z" />
                        </svg>

                    </a>

                </div>
            </div>

            {{-- NAVIGATION --}}
            <div class="space-y-6 text-center md:text-left">

                <h4 class="text-xs uppercase tracking-[0.3em]
                           text-gray-800 dark:text-gray-400">
                    {{ __('navigation.tours') }}
                </h4>

                <nav class="flex flex-col gap-4 text-sm font-light
                           text-gray-900 dark:text-gray-400">

                    <a href="/" class="transition hover:text-green-600 dark:hover:text-green-400">
                        {{ __('navigation.home') }}
                    </a>

                    <a href="/tours" class="transition hover:text-green-600 dark:hover:text-green-400">
                        {{ __('navigation.tours') }}
                    </a>

                    <a href="/accommodations" class="transition hover:text-green-600 dark:hover:text-green-400">
                        {{ __('navigation.accommodations') }}
                    </a>

                    <a href="/about_us" class="transition hover:text-green-600 dark:hover:text-green-400">
                        {{ __('navigation.about') }}
                    </a>

                    <a href="/contact" class="transition hover:text-green-600 dark:hover:text-green-400">
                        {{ __('navigation.contact') }}
                    </a>

                </nav>

            </div>

            {{-- NEWSLETTER --}}
            <div class="space-y-6 text-center md:text-left">

                <h4 class="text-xs uppercase tracking-[0.3em]
                           text-gray-800 dark:text-gray-400">
                    {{ __('footer.newsletter_title') }}
                </h4>

                <p class="text-sm font-light
                          text-gray-800 dark:text-gray-400">
                    {{ __('footer.newsletter_subtitle') }}
                </p>

                
                {{-- SUBSCRIPTION --}}
                <form method="POST" action="{{ route('subscribe.store') }}"
                    class="relative max-w-md mx-auto md:mx-0">

                    @csrf

                    <div class="rounded-full flex items-center
                            bg-white
                            dark:bg-white/5
                            border-2 border-green-600
                            shadow-[0_0_0_3px_rgba(34,197,94,0.15)]
                            transition-all duration-300">

                        <input type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="{{ __('footer.email_placeholder') }}"
                            class="flex-1 px-5 py-3 bg-transparent text-sm font-light
                            text-gray-900 dark:text-gray-200
                            placeholder-gray-600 dark:placeholder-gray-500
                            focus:outline-none">

                        <button type="submit"
                            class="luxury-btn relative px-6 py-3 rounded-full
                            bg-gradient-to-r from-green-600 to-green-700
                            text-white text-xs uppercase tracking-widest
                            overflow-hidden">
                            {{ __('footer.subscribe') }}
                        </button>

                    </div>

                </form>

            </div>

        </div>

        <div class="border-t border-gray-300 dark:border-gray-800 my-16"></div>

        {{-- BOTTOM --}}
        <div class="flex flex-col md:flex-row justify-between items-center text-xs gap-6 text-center md:text-left
                    text-gray-800 dark:text-gray-400">

            <div>
                © {{ date('Y') }} Aventura506 · La Fortuna, Costa Rica
            </div>

            <div>
                {{ __('footer.rights') }}
            </div>

            <div>
                {{ __('footer.designed_by') }}
                <span class="font-medium text-gray-900 dark:text-white">
                    Deivis Jimenez
                </span>
            </div>

        </div>

    </div>
</footer>

<style>
    .luxury-btn::after {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.7), transparent);
        transform: skewX(-20deg);
        transition: 0.8s;
    }

    .luxury-btn:hover::after {
        left: 130%;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const footer = document.getElementById("footer-content");
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    footer.classList.remove("opacity-0", "translate-y-10");
                    footer.classList.add("opacity-100", "translate-y-0");
                }
            });
        }, {
            threshold: 0.15
        });

        observer.observe(footer);

    });
</script>