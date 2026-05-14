<div class=" h-full w-full relative flex items-end " id="login-bg">

    <img src="{{ asset('images/logos/NEXALOGO.png') }}" alt="" class="absolute top-5 left-5 w-30 z-10">


    <div class=" w-3/4 h-50 flex flex-col">
        <p class="text-4xl font-bold mb-5 text-white">Building the next generation of connected digital experiences.</p>
        <p class="text-sm font-light  text-gray-300  mb-5">Web Design & Development Company Based in the Philippines</p>

        <div class=" w-full flex items-center gap-2 z-10">
            <div class="h-[2px] w-10 bg-white rounded-full"></div>
            <div class="h-[2px] w-5 bg-white/30 rounded-full"></div>
            <div class="h-[2px] w-3 bg-white/10 rounded-full"></div>
        </div>
    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.halo.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        VANTA.HALO({
            el: "#login-bg",
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200.00,
            minWidth: 200.00,
            baseColor: 0x0d1418,
            backgroundColor: 0x0d1418,
            amplitudeFactor: 0.40,
            yOffset: -0.01,
            size: 1.20
        })
    })
</script>
