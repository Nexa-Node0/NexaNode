<section class="flex justify-center overflow-x-hidden">
    <!-- fab -->
    <div class="fab fab-flower fixed bottom-5 right-5 z-50">
      <div
        tabindex="0"
        role="button"
        class="btn btn-lg btn-circle border-0 btn btn-lg btn-circle bg-[#1b2023] text-white border-0 hover:bg-[#1b2023]/80 tooltip tooltip-left"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16"
          />
        </svg>
      </div>

      <!-- Main Action (shows when open) -->
      <button
        class="fab-main-action btn btn-circle btn-lg border-0 bg-white text-black hover:bg-white/90"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </button>

      <!-- FAQs -->
      <button
        class="flex items-center justify-center btn btn-lg btn-circle bg-[#1b2023] text-white border-0 hover:bg-[#1b2023]/80 tooltip tooltip-left"
        data-tip="FAQs"
        onclick="window.location.href = '#faq'"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg>
      </button>

      <!-- Customer Service -->
      <button
        class="flex items-center justify-center btn btn-lg btn-circle bg-[#1b2023] text-white border-0 hover:bg-[#1b2023]/80 tooltip tooltip-left"
        data-tip="Customer Service"
        onclick="window.location.href = '#contact-section'"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"
          />
        </svg>
      </button>

      <!-- Logout -->
      <button
        class="flex items-center justify-center btn btn-lg btn-circle bg-red-500/20 text-red-400 border border-red-500/30 hover:bg-red-500/30 tooltip tooltip-left"
        data-tip="Logout"
        onclick="document.getElementById('logout-confirm').showModal()"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
          />
        </svg>
      </button>
    </div>
    <!-- fab -->

    <!-- Logout Confirm Modal -->
    <!--  
        <dialog id="logout-confirm" class="modal">
        <div
            class="modal-box bg-[#0f1518] text-white border border-white/10 rounded-xl max-w-sm"
        >
            <h3 class="text-lg font-bold secondary-font mb-1">Logging out?</h3>
            <p class="text-sm text-white/50 primary-font mb-6">
            You'll need to sign in again to access your account.
            </p>
            <div class="flex justify-end gap-3">
            <form method="dialog">
                <button
                type="button"
                onclick="logout_confirm.close()"
                class="btn btn-ghost text-white/50 hover:text-white hover:bg-white/10 rounded-sm primary-font"
                >
                Cancel
                </button>
            </form>
            <form>
                <button
                type="button"
                onclick="window.location.href = 'signup.html'"
                class="btn bg-red-500/20 text-red-400 border border-red-500/30 hover:bg-red-500/30 rounded-sm primary-font"
                >
                Yes, Logout
                </button>
            </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
        </dialog>
    -->
    <!-- Logout Confirm Modal -->

    <!-- loader -->
    <div
      id="loader"
      class="fixed inset-0 z-[9999] bg-[#080d10] flex items-center justify-center"
    >
      <div class="flex items-center gap-3">
        <span
          id="loader-count"
          class="text-white font-['Bricolage_Grotesque'] font-bold text-[40px] lg:text-[120px] leading-none tabular-nums"
          >0</span
        >
        <span
          class="text-[#88898B] font-['Bricolage_Grotesque'] font-bold text-[40px] lg:text-[60px] leading-none"
          >%</span
        >
      </div>
    </div>
    <!-- loader -->

    <div
      class="bg-[#080d10] w-full max-w-[1920px] grid grid-cols-1 grid-rows-[768px_.5fr_.5fr_1fr_.7fr_.8fr_.3fr] md:grid-rows-[768px_.6fr_1.5fr_1fr_.8fr_.5fr_.3fr] 2xl:grid-rows-[1fr_.9fr_1.8fr_1.4fr_1fr_.8fr_.4fr]"
    >
      <!-- hero section -->
      <div
        id="hero-section"
        class="bg-[#080d10] relative flex items-center justify-center lg:pl-[30px] lg:justify-start lg:h-[768px] 2xl:h-[1080px] 2xl:items-start 2xl:pt-[120px]"
      >
        <div
          class="w-[90%] h-[80%] mt-[20px] grid grid-cols-1 grid-rows-[1fr_.2fr] primary-font md:h-[50%] lg:w-[49%] lg:h-[80%] lg:mt-0 2xl:h-[90%] 2xl:w-[50%]"
        >
          <div class="flex flex-col 2xl:gap-[20px] slide-right-group">
            <h5 class="text-[#88898B] secondary-font font-bold mb-1">
              Website Design & Development Company
            </h5>
            <h1
              class="text-white font-semibold text-3xl lg:text-[50px] leading-[60px] mb-2 2xl:text-7xl"
            >
              Building the next generation of connected digital experiences.
            </h1>
            <h6 class="text-white mb-7 2xl:text-2xl">
              We design and develop modern websites powered by future-ready
              technology, seamless performance, and scalable connectivity. By
              combining creative design with clean, efficient code, we build
              digital platforms that elevate brands and support long-term
              growth.
            </h6>

            <div class="flex gap-5 flex-col lg:flex-row">
              <button
                class="p-[18px] lg:w-[180px] bg-white text-black rounded-sm font-bold text-sm"
              >
                LET’S TALK →
              </button>
              <button
                class="p-[18px] bg-[#1B2023] text-white rounded-sm font-medium text-sm"
              >
                EXPLORE OUR PROJECTS &nbsp;→
              </button>
            </div>
          </div>
          <div class="hidden gap-5 lg:flex lg:items-center">
            <div class="icons aspect-square bg-cover w-[50px] mix-blend-screen icon-github"></div>
            <div class="icons aspect-square bg-cover w-[50px] mix-blend-screen icon-repo"></div>
            <div class="icons aspect-square bg-cover w-[50px] mix-blend-screen icon-laravel" ></div>
            <div class="icons aspect-square bg-cover w-[50px] mix-blend-screen icon-mysql"></div>
            <div class="icons aspect-square bg-cover w-[50px] mix-blend-screen icon-js"></div>
            <div class="icons aspect-square bg-cover w-[50px] mix-blend-screen icon-tailwind" ></div>
          </div>
        </div>
        <img
          src="{{ asset('images/logos/NEXALOGO.png') }}"
          class="absolute z-1 bottom-[-160px] right-[-140px] object-contain lg:w-2/3 hidden lg:block 2xl:w-3/5 2xl:overflow-hidden"
          draggable="false"
        />
      </div>
      <!-- hero section -->

      <!-- introduction -->
      <div
        class="bg-[#080d10] grid grid-cols-1 grid-rows-[.5fr_1fr] md:grid-rows-[1fr_1.5fr] lg:grid-cols-2 lg:grid-rows-[1fr]"
      >
        <div
          class="photos-grid grid auto-rows-[1fr] p-2 lg:p-10 gap-2 lg:gap-5"
        >
          <div
            class="rounded-xl bg-cover introduction-thumbnail-1"
            style="
              grid-area: photo_1;"
          >
            1
          </div>
          <div
            class="rounded-xl bg-cover introduction-thumbnail-2"
            style="
              grid-area: photo_2;
            "
          >
            2
          </div>
          <div
            class="rounded-xl bg-cover introduction-thumbnail-3"
            style="
              grid-area: photo_3;
            "
          >
            3
          </div>
        </div>
        <div class="grid grid-cols-1 grid-rows-[.8fr_2fr] px-[15px]">
          <div class="flex items-center">
            <h1
              class="font-light primary-font text-white text-[20px] lg:text-[30px] 2xl:text-4xl slide-left"
            >
              From concept to digital success — your reliable partner in modern
              web design, development, and scalable digital solutions.
            </h1>
          </div>
          <div class="grid grid-cols-1 grid-rows-[50px_1fr]">
            <div class="flex items-center">
              <h5
                class="secondary-font text-[#88898B] font-bold tracking-[2px] scramble-text"
              >
                NEXANODE IN NUMBERS
              </h5>
            </div>
            <div
              class="grid grid-cols-2 auto-rows-[1fr] border-t-1 border-[#3F3E3E]"
            >
              <div
                class="flex items-center justify-center flex-col text-white secondary-font border-r-1 border-b-1 border-[#3F3E3E]"
              >
                <h1
                  class="text-3xl lg:text-5xl font-bold mb-1 scramble-text 2xl:text-6xl"
                >
                  98%
                </h1>
                <h5 class="text-center scramble-text 2xl:text-xl">
                  Client Satifaction Rate
                </h5>
              </div>
              <div
                class="flex items-center justify-center flex-col text-white border-b-1 border-[#3F3E3E]"
              >
                <h1
                  class="text-3xl lg:text-5xl font-bold mb-1 scramble-text 2xl:text-6xl"
                >
                  100%
                </h1>
                <h5 class="text-center scramble-text 2xl:text-xl">
                  Reliable Project Delivery
                </h5>
              </div>
              <div
                class="flex items-center justify-center flex-col text-white border-r-1 border-[#3F3E3E]"
              >
                <h1
                  class="text-3xl lg:text-5xl font-bold mb-1 scramble-text 2xl:text-6xl"
                >
                  100%
                </h1>
                <h5 class="text-center scramble-text 2xl:text-xl">
                  Modern & Scalable Web Solutions
                </h5>
              </div>
              <div class="flex items-center justify-center flex-col text-white">
                <h1
                  class="text-3xl lg:text-5xl font-bold mb-1 scramble-text 2xl:text-6xl"
                >
                  3X
                </h1>
                <h5 class="text-center scramble-text 2xl:text-xl">
                  Faster Website Performance
                </h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- introduction -->

      <!-- services -->
      <div
        id="service-section"
        class="bg-white px-[25px] grid grid-cols-1 grid-rows-[.1fr_1fr] md:grid-rows-[.1fr_1fr] gap-5"
      >
        <div class="flex flex-col justify-center">
          <h4
            class="text-[#3f3e3e] secondary-font font-bold mt-10 scramble-text"
          >
            Website Design & Development Company Services
          </h4>
          <h1
            class="font-medium text-black text-[28px] lg:text-[60px] leading-[60px] mb-2 2xl:w-3/4 2xl:text-7xl secondary-font slide-right"
          >
            Your vision deserves the right development partner.
          </h1>
        </div>
        <div
          class="services grid grid-cols-1 auto-rows-[1fr] gap-y-[40px] mb-5"
        >
          <!-- insights -->
          <div class="grid services-grid gap-[30px] service-cols-1">
            <div style="grid-area: col-1">
              <h2
                class="text-[#3F3E3E] text-[20px] lg:text-[26px] secondary-font"
              >
                Need a modern website but don’t know where to start?
              </h2>
            </div>
            <div
              style="grid-area: col-2"
              class="text-[20px] lg:text-[25px] 2xl:text-[30px] primary-font flex flex-col justify-between"
            >
              <h2>
                Building a website requires strategy, design, and development
                working together. Our team helps turn your ideas into a fully
                functional digital experience—designed to look great, perform
                fast, and grow with your business.
              </h2>

              <button
                class="text-white bg-black primary-font text-[13px] w-[150px] p-[15px] lg:w-[200px] lg:text-[15px] font-semibold lg:p-[20px] rounded-sm mt-[10px]"
              >
                INQUIRE US
              </button>
            </div>
            <div
              class="rounded-[20px] bg-cover insight-thumbnail-1"
              style="
                grid-area: col-3;
              "
            ></div>
          </div>
          <!-- insights -->

          <!-- insights -->
          <div class="grid services-grid gap-[30px] gap-[30px] service-cols-2">
            <div style="grid-area: col-1">
              <h2
                class="text-[#3F3E3E] text-[20px] lg:text-[26px] secondary-font"
              >
                Struggling to turn your idea into a working digital product?
              </h2>
            </div>
            <div
              class="text-[20px] lg:text-[25px] 2xl:text-[30px] primary-font flex flex-col justify-between"
              style="grid-area: col-2"
            >
              <h2>
                Transforming concepts into real platforms takes the right mix of
                creativity and technical expertise. We design and develop
                scalable web solutions that bring your vision to life and help
                your business stand out online.
              </h2>

              <button
                class="text-white bg-black primary-font text-[13px] w-[150px] p-[15px] lg:w-[200px] lg:text-[15px] font-semibold lg:p-[20px] rounded-sm mt-[10px]"
              >
                LET'S DISCUSS
              </button>
            </div>
            <div
              class="rounded-[20px] bg-cover bg-center insight-thumbnail-2"
              style="
                grid-area: col-3;
              "
            ></div>
          </div>
          <!-- insights -->

          <!-- insights -->
          <div class="grid services-grid gap-[30px] service-cols-3">
            <div style="grid-area: col-1">
              <h2
                class="text-[#3F3E3E] text-[20px] lg:text-[26px] secondary-font"
              >
                Need a modern website but don’t know where to start?
              </h2>
            </div>
            <div
              class="text-[20px] lg:text-[25px] 2xl:text-[30px] primary-font flex flex-col justify-between"
              style="grid-area: col-2"
            >
              <h2>
                Building a website requires strategy, design, and development
                working together. Our team helps turn your ideas into a fully
                functional digital experience—designed to look great, perform
                fast, and grow with your business.
              </h2>

              <button
                class="text-white bg-black primary-font text-[13px] w-[150px] p-[15px] lg:w-[200px] lg:text-[15px] font-semibold lg:p-[20px] rounded-sm mt-[10px]"
              >
                GET STARTED
              </button>
            </div>
            <div
              class="rounded-[20px] bg-cover insight-thumbnail-3"
              style="
                grid-area: col-3;
              "
            ></div>
          </div>
          <!-- insights -->
        </div>
      </div>
      <!-- services -->

      <!-- offers -->
      <div
        id="offer-section"
        class="bg-[#080d10] px-[25px] grid grid-cols-1 grid-rows-[.2fr_1fr] py-[50px] gap-[20px] md:gap-[50px]"
      >
        <div class="flex flex-col justify-center">
          <h4
            class="text-[#88897d] secondary-font font-bold mb-1 scramble-text"
          >
            Website Design & Development Company Offers
          </h4>
          <h1
            class="slide-right w-full lg:w-3/4 font-medium text-white text-[30px] lg:text-[50px] leading-[60px] mb-2 2xl:text-[65px] secondary-font"
          >
            Tailored support from first connection to long-term scale
          </h1>
          <h5
            class="text-white w-full lg:w-1/2 primary-font md:text-justify 2xl:text-xl"
          >
            Great websites don't happen by accident. As a next-generation web
            development company, we help startups grow through future-proof
            architecture, seamless connectivity, and scalable solutions built
            from the ground up.
          </h5>
        </div>

        <div
          class="grid grid-cols-1 grid-rows-[50px_1fr] md:grid-cols-[.3fr_1fr] md:grid-rows-[1fr]"
        >
          <div
            class="lg:relative border-b-1 md:border-r-1 md:border-b-0 border-[#3F3E3E]"
          >
            <div
              class="lg:sticky top-30 bg-[#080d10] w-full h-[500px] flex flex-col justify-between"
            >
              <ul
                class="h-[100px] flex md:flex-col justify-between secondary-font font-bold text-white text-[15px] md:text-[16px] 2xl:text-xl"
              >
                <li>Design</li>
                <li>Develop</li>
                <li>Scale & Optimize</li>
              </ul>

              <button
                class="hidden md:block primary-font bg-[#1b2023] text-white font-semibold text-xs md:text-[12px] p-[15px] rounded-sm md:w-[150px] lg:w-[200px] 2xl:text-base 2xl:w-[250px]"
              >
                EXPLORE OUR PROJECTS ->
              </button>
            </div>
          </div>

          <div class="grid grid-cols-1 auto-rows-[1fr] gap-[10px] md:px-[20px]">
            <div
              class="grid grid-cols-1 grid-rows-[100px_1fr] md:grid-rows-[.3fr_1fr]"
            >
              <div>
                <h1
                  class="text-white secondary-font font-semibold text-[25px] w-full lg:text-[35px] 2xl:text-[50px] md:w-3/4"
                >
                  Build your web presence & gain market traction
                </h1>
              </div>
              <div
                class="grid md:grid-cols-3 auto-rows-[1fr] md:border-t-1 border-[#3F3E3E] md:divide-x-1 divide-[#3F3E3E]"
              >
                <div class="flex flex-col items-center justify-center">
                  <div
                    class="w-5/6 md:w-full md:px-[10px] h-40 text-white flex flex-col justify-center"
                  >
                    <h2
                      class="secondary-font font-bold md:text-[18px] lg:text-[25px]"
                    >
                      Product Discovery
                    </h2>
                    <h4 class="md:text-[14px] 2xl:text-xl 2xl:text-xl">
                      Map out key features, user flows, and architecture to
                      align your team and reduce risks.
                    </h4>
                  </div>
                  <div class="w-5/6 h-24 2xl:w-full 2xl:px-3 flex items-center">
                    <a
                      href=""
                      class="font-[inter] text-white underline underline-offset-4 md:text-[12px] md:text-[14px] 2xl:text-md"
                      >EXPLORE -></a
                    >
                  </div>
                </div>

                <div class="flex flex-col items-center justify-center">
                  <div
                    class="w-5/6 md:w-full md:px-[10px] h-40 text-white flex flex-col justify-center"
                  >
                    <h2
                      class="secondary-font font-bold md:text-[18px] lg:text-[25px]"
                    >
                      Web Development
                    </h2>
                    <h4 class="md:text-[14px] 2xl:text-xl 2xl:text-xl">
                      Launch a fast, scalable site that converts and supports
                      product growth.
                    </h4>
                  </div>
                  <div class="w-5/6 h-24 2xl:w-full 2xl:px-3 flex items-center">
                    <a
                      href=""
                      class="font-[inter] text-white underline underline-offset-4 md:text-[12px] md:text-[14px] 2xl:text-md"
                      >EXPLORE -></a
                    >
                  </div>
                </div>

                <div class="flex flex-col items-center justify-center">
                  <div
                    class="w-5/6 md:w-full md:px-[10px] h-40 text-white flex flex-col justify-center"
                  >
                    <h2
                      class="secondary-font font-bold md:text-[18px] lg:text-[25px]"
                    >
                      Design Prototype
                    </h2>
                    <h4 class="md:text-[14px] 2xl:text-xl">
                      Test product ideas fast with clickable user journeys and
                      visual flows.
                    </h4>
                  </div>
                  <div class="w-5/6 h-24 2xl:w-full 2xl:px-3 flex items-center">
                    <a
                      href=""
                      class="font-[inter] text-white underline underline-offset-4 md:text-[12px] md:text-[14px] 2xl:text-md"
                      >EXPLORE -></a
                    >
                  </div>
                </div>
              </div>
            </div>

            <div
              class="grid grid-cols-1 grid-rows-[100px_1fr] md:grid-rows-[.3fr_1fr]"
            >
              <div>
                <h1
                  class="text-white secondary-font font-semibold text-[25px] w-full lg:text-[35px] 2xl:text-[50px] md:w-3/4"
                >
                  Scale, optimize & reach more  users
                </h1>
              </div>
              <div
                class="grid md:grid-cols-3 auto-rows-[1fr] md:border-t-1 border-[#3F3E3E] md:divide-x-1 divide-[#3F3E3E]"
              >
                <div class="flex flex-col items-center justify-center">
                  <div
                    class="w-5/6 md:w-full md:px-[10px] h-40 text-white flex flex-col justify-center"
                  >
                    <h2
                      class="secondary-font font-bold md:text-[18px] lg:text-[25px]"
                    >
                      UX Audit
                    </h2>
                    <h4 class="md:text-[14px] 2xl:text-xl">
                      Identify usability bottlenecks, improve engagement, and
                      optimize for conversions.
                    </h4>
                  </div>
                  <div class="w-5/6 h-24 2xl:w-full 2xl:px-3 flex items-center">
                    <a
                      href=""
                      class="font-[inter] text-white underline underline-offset-4 md:text-[12px] md:text-[14px] 2xl:text-md"
                      >EXPLORE -></a
                    >
                  </div>
                </div>

                <div class="flex flex-col items-center justify-center">
                  <div
                    class="w-5/6 md:w-full md:px-[10px] h-40 text-white flex flex-col justify-center"
                  >
                    <h2
                      class="secondary-font font-bold md:text-[18px] lg:text-[25px]"
                    >
                      Website Redesign
                    </h2>
                    <h4 class="md:text-[14px] 2xl:text-xl">
                      Modernize your web presence with a digital product design
                      agency that drives engagement and brand authority.
                    </h4>
                  </div>
                  <div class="w-5/6 h-24 2xl:w-full 2xl:px-3 flex items-center">
                    <a
                      href=""
                      class="font-[inter] text-white underline underline-offset-4 md:text-[12px] md:text-[14px] 2xl:text-md"
                      >EXPLORE -></a
                    >
                  </div>
                </div>

                <div class="flex flex-col items-center justify-center">
                  <div
                    class="w-5/6 md:w-full md:px-[10px] h-40 text-white flex flex-col justify-center"
                  >
                    <h2
                      class="secondary-font font-bold md:text-[18px] lg:text-[25px]"
                    >
                      Dedicated Team
                    </h2>
                    <h4 class="md:text-[14px] 2xl:text-xl">
                      Access a team of experts to fuel your product’s growth.
                    </h4>
                  </div>
                  <div class="w-5/6 h-24 2xl:w-full 2xl:px-3 flex items-center">
                    <a
                      href=""
                      class="font-[inter] text-white underline underline-offset-4 md:text-[12px] md:text-[14px] 2xl:text-md"
                      >EXPLORE -></a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- offers -->

      <!-- insights -->
      <div
        id="insight-section"
        class="bg-white grid grid-cols-1 grid-rows-[.1fr_1fr] md:grid-rows-[.2fr_1fr] px-[25px] my-[50px]"
      >
        <div class="flex flex-col justify-center">
          <h4
            class="text-[#3f3e3e] secondary-font font-bold mb-1 scramble-text mt-10"
          >
            WHY CHOOSE US?
          </h4>
          <h1
            class="slide-right font-medium text-black text-[28px] lg:text-[60px] leading-[60px] mb-2 2xl:text-[70px] secondary-font"
          >
            Your success is our priority
          </h1>
        </div>

        <div
          class="card-container grid auto-rows-[1fr] gap-[20px] md:grid-cols-2 2xl:px-25 mb-10"
        >
          <div
            class="slide-right-card rounded-md bg-[#f5f6f6] px-[20px] flex flex-col justify-center gap-[5px] md:gap-[10px]"
          >
            <h4 class="text-[#3F3E3E] primary-font mb-3">
              CODE THAT LAST BEYOND TRENDS
            </h4>
            <h1 class="primary-font text-[20px] md:text-[25px] 2xl:text-3xl">
              We don't chase the hype. We build websites that stay relevant
            </h1>
            <h5 class="primary-font 2xl:text-2xl font-light">
              Our work performs sharply today and scales seamlessly tomorrow —
              engineered around long-term value. Clean architecture, consistent
              structure, and smart development that grows with your business.
            </h5>
          </div>

          <div
            class="slide-left-card rounded-md bg-[#f5f6f6] px-[20px] flex flex-col justify-center gap-[5px] md:gap-[10px]"
          >
            <h4
              class="text-[#3F3E3E] text-[13px] md:text-[16px] primary-font mb-3"
            >
              DEVELOPMENT THAT'S LAUNCH READY
            </h4>
            <h1 class="primary-font text-[20px] md:text-[25px] 2xl:text-3xl">
              We build for the real world, not just the demo.
            </h1>
            <h5 class="primary-font 2xl:text-2xl font-light">
              Every line of code is written with performance and maintainability
              in mind: reusable components, accessibility, scalability, and
              real-world constraints. We collaborate closely with your team,
              work within your stack, and stay involved until everything is
              live.
            </h5>
          </div>

          <div
            class="slide-right-card rounded-md bg-[#f5f6f6] px-[20px] flex flex-col justify-center gap-[5px] md:gap-[10px]"
          >
            <h4
              class="text-[#3F3E3E] text-[13px] md:text-[16px] primary-font mb-3"
            >
              LOCAL PRESENCE, GLOBAL DELIVERY
            </h4>
            <h1 class="primary-font text-[20px] md:text-[25px] 2xl:text-3xl">
              Work directly with the builders — not a chain of account managers.
            </h1>
            <h5 class="primary-font 2xl:text-2xl font-light">
              Our senior development teams in Philippines deliver fast,
              consistent results. We integrate into your tools and workflow,
              working as part of your team — from a single embedded developer to
              a full web squad.
            </h5>
          </div>

          <div
            class="slide-left-card rounded-md bg-[#f5f6f6] px-[20px] flex flex-col justify-center gap-[5px] md:gap-[10px]"
          >
            <h4
              class="text-[#3F3E3E] text-[13px] md:text-[16px] primary-font mb-3"
            >
              CONNECT WITH YOUR AUDIENCE
            </h4>
            <h1 class="primary-font text-[20px] md:text-[25px] 2xl:text-3xl">
              Your website should speak before you do.
            </h1>
            <h5 class="primary-font 2xl:text-2xl font-light">
              From landing pages to full web experiences, we craft designs where
              every element serves a purpose — intuitive layouts, cohesive
              visuals, and interfaces that guide users naturally toward action.
              At NexaNode, great design isn't decoration, it's the first node in
              your customer's journey.
            </h5>
          </div>
        </div>
      </div>
      <!-- insights -->

      <!-- contact-section -->
      <div
        class="bg-[#080d10] grid grid-cols-1 grid-rows-[.1fr_1fr] md:grid-rows-[.1fr_1fr] px-[25px] gap-[20px]"
        id="contact-section"
      >
        <div class="flex flex-col justify-center">
          <h4
            class="text-[#88897d] secondary-font font-bold mb-1 scramble-text"
          >
            INQUIRE US
          </h4>
          <h1
            class="slide-right font-medium w-full md:w-1/2 text-white text-[28px] lg:text-[50px] leading-[60px] mb-2 2xl:text-[55px] secondary-font 2xl:text-[70px] 2xl:w-full"
          >
            Have any questions? Let's chat
          </h1>
        </div>

        <div
          class="contact-container grid grid-rows-[1fr_.5fr] md:grid-rows-[1fr] lg:grid-cols-[1fr_.5fr]"
        >
          <div
            class="lg:border-t-1 lg:border-r-1 border-[#3F3E3E] flex items-center justify-center"
          >
            <div
              class="container w-full h-[90%] md:h-full md:w-5/6 h-3/4 grid grid-cols-1 auto-rows-[1fr]"
            >
              <!-- input-1 -->
              <div
                class="grid md:grid-cols-2 auto-rows-[1fr] secondary-font font-bold gap-[20px]"
              >
                <div
                  class="text-[#88898B] text-[14px] flex flex-col justify-center"
                >
                  <label for="username">TELL US YOUR NAME:</label>
                  <input
                    type="text"
                    name="username"
                    class="h-[50px] font-normal outline-none border-0 border-b border-[#3F3E3E] rounded-none bg-transparent w-full text-white"
                  />
                </div>

                <div
                  class="text-[#88898B] text-[14px] flex flex-col justify-center"
                >
                  <label for="email">YOUR EMAIL:</label>
                  <input
                    type="email"
                    name="email"
                    class="h-[50px] font-normal outline-none border-0 border-b border-[#3F3E3E] rounded-none bg-transparent w-full text-white"
                  />
                </div>
              </div>
              <!-- input-1 -->

              <!-- input-2-->
              <div
                class="text-[#88898B] text-[14px] flex flex-col justify-center secondary-font font-bold"
              >
                <label for="message">MESSAGE:</label>
                <input
                  type="text"
                  name="message"
                  class="h-[50px] font-normal outline-none border-0 border-b border-[#3F3E3E] rounded-none bg-transparent w-full text-white"
                />
              </div>
              <!-- input-2-->

              <!-- input-3 -->
              <div class="flex items-center">
                <button
                  class="w-[180px] p-[14px] rounded-md bg-[#1B2023] text-white text-[12px] primary-font"
                >
                  ATTACH FILES
                </button>
              </div>
              <!-- input-3 -->

              <!-- input-4 -->
              <div class="flex flex-col justify-center secondary-font">
                <p class="text-[#88898B] font-bold tracking-[2px] text-sm mb-3">
                  YOUR BUDGET FOR THIS PROJECT
                </p>
                <div class="flex flex-wrap gap-3">
                  <label class="cursor-pointer">
                    <input
                      type="radio"
                      name="budget"
                      value="10k"
                      class="hidden peer"
                    />
                    <span
                      class="inline-block px-5 py-3 border border-[#4a4a4a] rounded-lg text-white text-[13px] font-semibold tracking-wider peer-checked:border-white peer-checked:bg-[#1b2023] hover:border-[#888] transition-all duration-200"
                      >UP TO 10K PHP</span
                    >
                  </label>
                  <label class="cursor-pointer">
                    <input
                      type="radio"
                      name="budget"
                      value="10k-20k"
                      class="hidden peer"
                    />
                    <span
                      class="inline-block px-5 py-3 border border-[#4a4a4a] rounded-lg text-white text-[13px] font-semibold tracking-wider peer-checked:border-white peer-checked:bg-[#1b2023] hover:border-[#888] transition-all duration-200"
                      >10K-20K PHP</span
                    >
                  </label>
                  <label class="cursor-pointer">
                    <input
                      type="radio"
                      name="budget"
                      value="20k-50k"
                      class="hidden peer"
                    />
                    <span
                      class="inline-block px-5 py-3 border border-[#4a4a4a] rounded-lg text-white text-[13px] font-semibold tracking-wider peer-checked:border-white peer-checked:bg-[#1b2023] hover:border-[#888] transition-all duration-200"
                      >20K-50K PHP</span
                    >
                  </label>
                  <label class="cursor-pointer">
                    <input
                      type="radio"
                      name="budget"
                      value="50k-100k"
                      class="hidden peer"
                    />
                    <span
                      class="inline-block px-5 py-3 border border-[#4a4a4a] rounded-lg text-white text-[13px] font-semibold tracking-wider peer-checked:border-white peer-checked:bg-[#1b2023] hover:border-[#888] transition-all duration-200"
                      >50-100K PHP</span
                    >
                  </label>
                </div>
              </div>
              <!-- input-4 -->

              <!-- input-5 -->
              <div class="flex items-center gap-[10px]">
                <button
                  class="w-[180px] p-[14px] rounded-md bg-[#1B2023] text-white text-[12px] primary-font"
                >
                  SUBMIT ->
                </button>

                <p
                  class="font-bold secondary-font text-xs md:text-[15px] text-white"
                >
                  By clicking this button you accept Terms of Service and
                  <br />
                  Privacy Policy
                </p>
              </div>
              <!-- input-5 -->

              <div class="flex items-center justify-center">
                <p class="text-center secondary-font text-gray-400 text-sm">
                  Interested?
                  <a
                    href="application-form.html"
                    class="text-white font-bold primary-font underline underline-offset-3"
                    >Get in Touch -></a
                  >
                </p>
              </div>
            </div>
          </div>

          <!-- profile -->
          <div
            class="md:border-t-1 border-[#3F3E3E] grid grid-cols-1 auto-rows-[450px]"
          >
            <div class="flex items-center justify-center">
              <!-- dp container -->
              <div
                class="container w-full md:w-5/6 h-full p-[20px] grid grid-cols-1 grid-rows-[.2fr_1fr] md:grid-rows-[.3fr_1fr] gap-[10px]"
              >
                <div class="flex items-center">
                  <h1
                    class="text-white font-bold text-[25px] w-full md:w-4/5 secondary-font"
                  >
                    Have a Website Design to Discuss?
                  </h1>
                </div>
                <div class="grid grid-cols-1 auto-rows-[100px] gap-[10px]">
                  <!-- dp -->
                  <div class="grid grid-cols-[100px_1fr]">
                    <div
                      class="bg-cover bg-center dev-profile-dharjay"
                    ></div>
                    <div
                      class="flex flex-col justify-center primary-font pl-[10px]"
                    >
                      <h1 class="text-white font-bold text-sm md:text-[18px]">
                        Dharjay Escarlan
                      </h1>
                      <h4
                        class="font-regular text-[#88897c] text-sm md:text-[15px]"
                      >
                        Front End Developer
                      </h4>
                      <h4
                        class="font-bold text-white text-xs md:text-[15px] underline underline-offset-4"
                      >
                        dharjayescarlan@gmail.com
                      </h4>
                    </div>
                  </div>
                  <!-- dp -->

                  <!-- dp -->
                  <div class="grid grid-cols-[100px_1fr]">
                    <div
                      class="bg-cover bg-center dev-profile-rj"
                    ></div>
                    <div
                      class="flex flex-col justify-center primary-font pl-[10px]"
                    >
                      <h1 class="text-white font-bold text-sm md:text-[18px]">
                        R-jay Opiana
                      </h1>
                      <h4
                        class="font-regular text-[#88897c] text-sm md:text-[15px]"
                      >
                        UI / UX Designer
                      </h4>
                      <h4
                        class="font-bold text-white text-xs md:text-[15px] underline underline-offset-4"
                      >
                        opianarjay@gmail.com
                      </h4>
                    </div>
                  </div>
                  <!-- dp -->
                </div>
              </div>
              <!-- dp container -->
            </div>
            <div
              class="flex items-center justify-center border-t-1 border-[var(--secondary-color)]"
            >
              <!-- dp container -->
              <div
                class="container w-full md:w-5/6 h-full p-[20px] grid grid-cols-1 grid-rows-[.2fr_1fr] md:grid-rows-[.3fr_1fr] gap-[10px]"
              >
                <div class="flex items-center">
                  <h1
                    class="text-white font-bold text-[25px] w-full md:w-4/5 secondary-font"
                  >
                    Have a Concepts in mind?
                  </h1>
                </div>
                <div class="grid grid-cols-1 auto-rows-[100px] gap-[10px]">
                  <!-- dp -->
                  <div class="grid grid-cols-[100px_1fr]">
                    <div
                      class="bg-cover bg-center dev-profile-jericho"
                    ></div>
                    <div
                      class="flex flex-col justify-center primary-font pl-[10px]"
                    >
                      <h1 class="text-white font-bold text-sm md:text-[18px]">
                        Jericho Umayam
                      </h1>
                      <h4
                        class="font-regular text-[#88897c] text-sm md:text-[15px]"
                      >
                        Back End Developer
                      </h4>
                      <h4
                        class="font-bold text-white text-xs md:text-[15px] underline underline-offset-4"
                      >
                        jerichoumayam@gmail.com
                      </h4>
                    </div>
                  </div>
                  <!-- dp -->

                  <!-- dp -->
                  <div class="grid grid-cols-[100px_1fr]">
                    <div
                      class="bg-cover bg-center dev-profile-jose"
                    ></div>
                    <div
                      class="flex flex-col justify-center primary-font pl-[10px]"
                    >
                      <h1 class="text-white font-bold text-sm md:text-[18px]">
                        Jose Valerie Dalanon
                      </h1>
                      <h4
                        class="font-regular text-[#88897c] text-sm md:text-[15px]"
                      >
                        Back End Developer
                      </h4>
                      <h4
                        class="font-bold text-white text-xs md:text-[15px] underline underline-offset-4"
                      >
                        josedalanon630@gmail.com
                      </h4>
                    </div>
                  </div>
                  <!-- dp -->
                </div>
              </div>
              <!-- dp container -->
            </div>
          </div>
          <!-- profile -->
        </div>
      </div>
      <!-- contact-section -->
    </div>

    @push('scripts')
        <script src="{{ asset('js/livewire/animations.js') }}"></script>
        <script src="{{ asset('js/livewire/navigation.js') }}"></script>
    @endpush
    
</section>