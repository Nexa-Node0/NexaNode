<!-- navbar -->
<navbar
    class="navbar bg-[#080d10] fixed top-0 z-100 max-w-[1920px] text-white h-[80px] lg:h-[100px] 2xl:h-[120px] lg:px-5"
    >
    <div class="navbar-start">
    <div class="dropdown">
        <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4 6h16M4 12h8m-8 6h16"
            />
        </svg>
        </div>
        <ul
        tabindex="-1"
        class="menu menu-sm dropdown-content bg-[#080d10] z-1 shadow w-screen h-screen left-0 fixed pt-[80px] px-[25px]"
        >
        <li class="border-b border-[#3F3E3E]">
            <a
            href="{{ route('blogs.index') }}"
            wire:navigate
            class="secondary-font font-bold text-white text-[18px] py-[20px]"
            >SERVICES</a
            >
        </li>
        <li class="border-b border-[#3F3E3E]">
            <a
            href="#offer-section"
            class="secondary-font font-bold text-white text-[18px] py-[20px]"
            >OFFERS</a
            >
        </li>
        <li class="border-b border-[#3F3E3E]">
            <a
            href="#insight-section"
            class="secondary-font font-bold text-white text-[18px] py-[20px]"
            >INSIGHTS</a
            >
        </li>
        <li class="border-b border-[#3F3E3E]">
            <a
            href="projects.html"
            class="secondary-font font-bold text-white text-[18px] py-[20px]"
            >PROJECTS</a
            >
        </li>
        <li class="border-b border-[#3F3E3E]">
            <details>
            <summary
                class="secondary-font font-bold text-white text-[18px] py-[20px]"
            >
                ABOUT US
            </summary>
            <ul class="primary-font font-bold">
                <li class="py-[20px]">
                <a class="text-[18px]" href="/blogs">BLOGS</a>
                </li>
                <li class="py-[20px]">
                <a class="text-[18px]">ABOUT NEXANODE</a>
                </li>
            </ul>
            </details>
        </li>
        <li class="mt-[30px]">
            <a
            href="application-form.html"
            class="bg-white text-black font-bold text-sm font-[Inter] rounded-sm p-[15px] w-[150px] text-center"
            >
            GET IN TOUCH ->
            </a>
        </li>
        </ul>
    </div>
    <a href="{{ route('homepage') }}">
        <img src="{{ asset('images/logos/nexa.png') }}" alt="" class="w-[80%] sm:w-1/2" />
    </a>
    </div>
    <div class="navbar-center hidden lg:flex secondary-font">
    <ul class="menu menu-horizontal px-1 gap-[60px] text-base">
        <li><a href="{{ route('blogs.index') }}" wire:navigate>SERVICES</a></li>
        <li><a href="#offer-section">OFFERS</a></li>
        <li><a href="#insight-section">INSIGHTS</a></li>
        <li><a href="projects.html">PROJECTS</a></li>
        <li>
        <details>
            <summary class="">ABOUT US</summary>
            <ul class="p-2 w-40 z-1 bg-[#1b2023] w-[200px]">
            <li><a href="{{ route('blogs.index') }}" wire:navigate>Blogs</a></li>
            <li><a>About NexaNode</a></li>
            </ul>
        </details>
        </li>
    </ul>
    </div>
    <div class="navbar-end">
    <a
        href="application-form.html"
        class="hidden lg:block lg:w-[150px] rounded-sm text-sm font-[Inter] bg-white text-black font-bold p-[15px]"
        >GET IN TOUCH -></a
    >
    </div>
</navbar>
<!-- navbar -->