<section class="bg-white">
    <div class="w-full max-w-[1920px] grid grid-cols-1 grid-rows-[.1fr_2fr_1.3fr_.1fr_.2fr] md:grid-rows-[.1fr_2fr_1.3fr_.1fr_.3fr_.3fr] pt-[140px] lg:grid-rows-[.1fr_1fr_.5fr_.1fr_.3fr] 2xl:grid-rows-[.1fr_5fr_2.6fr_.5fr_1fr] md:pt-[180px]">
         <!-- header -->
      <div
        class="blog_header flex flex-col justify-center px-[25px] gap-[20px]"
      >
        <h1 class="text-5xl md:text-7xl font-medium secondary-font slide-right text-black">
          Expert articles
        </h1>

        <!-- desktop size -->
    <!-- Desktop filters -->
<div class="hidden h-24 md:flex flex-wrap items-center gap-5 primary-font font-semibold">
    <label class="cursor-pointer">
        <input 
            type="radio" 
            name="category" 
            class="hidden peer"
            wire:model="selectedCategoryValue" 
            value="all" 
        />
        <span 
            class="inline-block tracking-widest p-4 rounded-sm transition ease-in duration-200 text-sm
                   {{ $selectedCategoryValue === 'all' ? 'bg-black text-white' : 'bg-transparent text-black' }}">
            ALL
        </span>
    </label>

    <label class="cursor-pointer">
        <input 
            type="radio" 
            name="category" 
            class="hidden peer"
            wire:model="selectedCategoryValue" 
            value="business_design" 
        />
        <span 
            class="inline-block tracking-widest p-4 rounded-sm transition ease-in duration-200 text-sm
                   {{ $selectedCategoryValue === 'business_design' ? 'bg-black text-white' : '' }}">
            BUSINESS & DESIGN
        </span>
    </label>

    <label class="cursor-pointer">
        <input 
            type="radio" 
            name="category" 
            class="hidden peer"
            wire:model="selectedCategoryValue" 
            value="development" 
        />
        <span 
            class="inline-block tracking-widest p-4 rounded-sm transition ease-in duration-200 text-sm
                   {{ $selectedCategoryValue === 'development' ? 'bg-black text-white' : '' }}">
            DEVELOPMENT
        </span>
    </label>

    <!-- Add DEPLOYMENT similarly if needed -->
</div>
        <!-- desktop size -->

        <!-- mobile size -->
        <select
          name="category"
          id="category"
          class="border-1 border-gray-300 text-black text-sm font-medium px-4 size-16 w-full rounded-sm primary-font md:hidden tracking-widest"
        >
          <option value="All">ALL</option>
          <option value="BUSINESS & DESIGN">BUSINESS & DESIGN</option>
          <option value="DEVELOPMENT">DEVELOPMENT</option>
          <option value="DEPLOYMENT">DEPLOYMENT</option>
        </select>
        <!-- mobile size -->
      </div>
      <!-- header -->
      <div class="blog_wrapper p-[25px]">
            <div class="h-full w-full grid lg:grid-cols-2 gap-5">
                    <!-- main blog -->
                <div
                    class="slideLeftCard grid grid-cols-1 grid-rows-[.3fr_.7fr_1fr] md:grid-rows-[.1fr_1fr_.7fr] 2xl:grid-rows-[.1fr_1fr_.7fr] md:gap-5 primary-font text-black border-b-1 border-black md:border-b-0"
                >
                    <!-- creator -->
                    <div class="flex items-center justify-between">
                    <div class="creator w-64 h-full flex items-center gap-5">
                        <span
                        class="bg-black text-white p-3 rounded-full aspect-square w-[50px] flex items-center justify-center"
                        >M</span
                        >
                        <p>Mork N' Means</p>
                    </div>
                    <button
                        class="p-3 2xl:p-4 2xl:text-sm text-xs bg-black rounded-sm text-white text-center w-32"
                        onclick="window.location.href = 'blog-page.html'"
                    >
                        READ BLOG
                    </button>
                    </div>
                    <!-- creator -->

                    <div
                    class="image_wrapper bg-cover bg-center bg-no-repeat"
                    style="
                        background-image: url('{{ $postHeadline->thumbnail}}');
                    "
                    ></div>
                    <!-- blog_info -->
                    <div
                    class="blog_info grid grid-cols-1 grid-rows-[50px_.5fr_1fr_.5fr] gap-0 md:gap-5"
                    >
                    <!-- category -->
                    <div class="flex items-center justify-between">
                        <p
                        class="font-bold text-[15px] 2xl:text-[18px] text-[var(--secondary-color)] uppercase"
                        >
                            {{ $postHeadline->category->name }}
                        </p>
                        <span
                        class="font-bold text-[12px] 2xl:text-[15px] text-center md:text-start hidden md:block"
                        >
                        {{  $postHeadline->published_date->format('M d, Y') }}
                        </span>
                    </div>
                    <!-- category -->
                    <div class="flex items-center">
                        <p class="font-bold text-[20px] 2xl:text-3xl secondary-font uppercase">
                            {{ $postHeadline->title }}
                        </p>
                    </div>
                    <div class="flex items-center">
                        <p class="text-base md:text-xl 2xl:text-2xl">
                            {!! $postHeadline->content !!}
                        </p>
                    </div>
                    <!--  tags-->
                    <div
                        class="flex flex-wrap items-center text-medium text-[12px] 2xl:text-[15px] text-white gap-3"
                    >
                        @foreach ($postHeadline->tags as $tag)
                            <p class="p-2 rounded-full bg-black">{{ $tag }}</p>
                        @endforeach
                    </div>
                    <!--  tags-->
                    </div>
                    <!-- blog_info -->
                </div>
                <!-- main blog -->
                <div class="grid grid-cols-1 auto-rows-[1fr] gap-10 md:gap-5 primary-font divide-y-1">
                    <!-- other blogs -->
                    @foreach ($otherPosts as $post)
                        <!-- blog -->
                        <div
                                class="overflow-hidden group grid grid-cols-1 md:grid-cols-[.5fr_1fr] gap-5 hover:scale-102 transition ease"
                            >
                                <!-- Image -->
                                <div
                                    class="bg-cover bg-center group-hover:scale-110 transition ease"
                                    style="background-image: url('{{ $post->thumbnail }}');"
                                ></div>

                                <!-- Content -->
                                <div class="flex flex-col justify-between gap-3">
                                    <div>
                                        <p class="font-bold text-lg secondary-font 2xl:text-2xl text-black">
                                            {{ $post->title }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-sm 2xl:text-xl text-black">
                                            {!! Str::limit(strip_tags($post->content), 120) !!}
                                        </p>
                                    </div>

                                    <div class="flex items-center justify-between pb-2">
                                        <div class="creator flex items-center gap-2">
                                            <span
                                                class="bg-black text-white rounded-full w-[30px] h-[30px] flex items-center justify-center"
                                            >M</span>
                                            <p class="text-xs 2xl:text-base text-black">Mork N' Means</p>
                                        </div>

                                        <a
                                            href="#"
                                            class="p-3 text-xs bg-black rounded-sm text-white w-32 text-center"
                                        >
                                            READ BLOG
                                        </a>
                                    </div>
                                </div>
                        </div>
                        <!-- blog -->
                    @endforeach
                    <!-- other blogs -->
                </div>
            </div>
      </div> 
      <!-- recommended_blogs -->
      <div class="recommended_blogs px-[25px] grid grid-cols-1 grid-rows-[50px_1fr]">
            <div class="flex items-center">
                <h3 class="secondary-font font-bold text-[var(--secondary-color)]">
                    MORE INSIGHTS
                </h3>
            </div>
            <!-- recommended_blogs_wrapper-->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 auto-rows-[1fr] gap-5">
                <!-- recommended_blog -->
                    @foreach ($recommendedPost as $post)
                    <div class="grid grid-cols-1 grid-rows-[1fr_1fr] gap-2 primary-font">
                         <div
                        class="bg-cover bg-center rounded-sm"
                        style="
                            background-image: url('{{ $post->thumbnail }}');
                        "
                    ></div>
                        <div
                            class="grid grid-cols-1 grid-rows-[.2fr_.3fr_.5fr] md:grid-rows-[.5fr_1fr_.5fr] 2xl:grid-rows-[.2fr_1fr_100px]"
                            >
                            <div class="flex items-center">
                                <p class="text-base font-bold secondary-font 2xl:text-xl text-black">
                                    {{ $post->title }}
                                </p>
                            </div>

                            <div class="flex items-center">
                                <p class="text-sm font-regular 2xl:text-lg text-black">
                                    {!! $post->content !!}
                                </p>
                            </div>

                            <div class="flex items-center justify-between pb-2">
                                <div class="creator w-64 h-full flex items-center gap-2">
                                <span
                                    class="bg-black text-white rounded-full aspect-square w-[30px] 2xl:w-[40px] flex items-center justify-center"
                                    >M</span
                                >
                                <p class="text-xs 2xl:text-base">Mork N' Means</p>
                                </div>

                                <a
                                href="blog-page.html"
                                class="p-3 2xl:p-4 2xl:text-sm text-xs bg-black rounded-sm text-white text-center w-32"
                                >READ BLOG</a
                                >
                            </div>
                        </div>
                    </div>
                    @endforeach
                <!-- recommended_blog -->
            </div>
            <!-- recommended_blogs_wrapper-->
      </div>
      <!-- recommended_blogs -->

      <!-- pagination -->
      <div class="flex items-center justify-center">
        <div
          class="button_wrapper font-medium text-black primary-font gap-5 flex items-center justify-center h-[80%]"
        >
          <button class="aspect-square w-[50px] rounded-sm"><-</button>
          <button class="aspect-square w-[50px] rounded-sm bg-black text-white">
            1
          </button>
          <button class="aspect-square w-[50px] rounded-sm">2</button>
          <button class="aspect-square w-[50px] rounded-sm">3</button>
          <button class="aspect-square w-[50px] rounded-sm">-></button>
        </div>
      </div>
      <!-- pagination -->
      <!-- SUBSCRIPTION -->
      <div class="bg-[#080d10] px-7">
        <div class="grid md:grid-cols-2 auto-rows-[1fr] h-full">
          <div class="flex flex-col justify-center gap-5">
            <p class="text-white secondary-font font-bold text-lg lg:text-2xl">
              Subscribe to our Blog
            </p>
            <p class="text-white text-sm primary-font">
              Subscribe to our blog to stay updated with the latest insights,
              tips, and industry trends. Get valuable content, helpful
              resources, and fresh ideas delivered straight to you—so you never
              miss an update.
            </p>

            <div class="flex items-center">
              <input
                type="email"
                class="w-full md:w-6/9 h-full pl-3 outline-0 bg-white text-sm"
                placeholder="Enter your email here"
              />
              <button
                class="primary-font p-3 2xl:p-4 2xl:text-sm text-xs font-bold bg-[var(--secondary-color)] text-white text-center w-32"
              >
                SUBSCRIBE
              </button>
            </div>
          </div>
          <div class="hidden md:flex items-center justify-center">
            <img src="{{ Storage::url(setting('general.brand_logo')) }}" class="w-6/9 2xl:w-4/9" alt="" />
          </div>
        </div>
      </div>
      <!-- SUBSCRIPTION -->
    </div>   
</section>