<div
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
          <a class='secondary-font font-bold text-white text-[18px] py-[20px]' href='/#hero-section'>HOME</a
          >
        </li>

        <li class="border-b border-[#3F3E3E]">
          <a class='secondary-font font-bold text-white text-[18px] py-[20px]' href='/#service-section'>SERVICES</a
          >
        </li>

        <li class="border-b border-[#3F3E3E]">
          <a class='secondary-font font-bold text-white text-[18px] py-[20px]' href='/#offer-section'>OFFERS</a
          >
        </li>

        <li class="border-b border-[#3F3E3E]">
          <a class='secondary-font font-bold text-white text-[18px] py-[20px]' href='/projects'>PROJECTS</a
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
                <a class='text-[18px]' href='/blogs'>BLOGS</a>
              </li>
              <li class="py-[20px]">
                <a class="text-[18px]">ABOUT NEXANODE</a>
              </li>
            </ul>
          </details>
        </li>
        <li class="mt-[30px]">
          <a class='bg-white text-black font-bold text-sm font-[Inter] rounded-sm p-[15px] w-[150px] text-center' href='/application-form'>
            GET IN TOUCH ->
          </a>
        </li>
      </ul>
    </div>
    <a href='/#hero-section'>
      <img src="{{ Storage::url(setting('general.brand_logo')) }}" alt="{{ setting('general.brand_logo') }}" class="w-[80%] sm:w-1/2" />
    </a>
  </div>
  <div class="navbar-center hidden lg:flex secondary-font">
    <ul class="menu menu-horizontal px-1 gap-[60px] text-base">
      <li><a href='{{ route('homepage') }}' wire:navigate>HOME</a></li>
      <li><a href='/#service-section'>SERVICES</a></li>
      <li><a href='/#offer-section'>OFFERS</a></li>
      <li><a href='/projects'>PROJECTS</a></li>
     
      <li x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="cursor-pointer">
          ABOUT US
        </button>
        <ul 
          x-show="open"
          @click.outside="open = false"
          x-transition
          class="absolute left-1/2 -translate-x-1/2 mt-10 w-[200px] bg-[#1b2023] shadow z-50 p-3"
        >
          <li><a href="{{ route('blogs.index') }}" wire:navigate>Blogs</a></li>
          <li><a>About NexaNode</a></li>
        </ul>
      </li>
    
    </ul>
  </div>
  <div class="navbar-end">
    <a class='hidden lg:block lg:w-[150px] rounded-sm text-sm font-[Inter] bg-white text-black font-bold p-[15px]' href='/application-form'>GET IN TOUCH -></a
    >
  </div>
</div>