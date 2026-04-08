window.addEventListener("livewire:navigated", () => {
    gsap.registerPlugin(ScrollTrigger, ScrambleTextPlugin);

    ScrollTrigger.getAll().forEach((t) => t.kill());
    gsap.killTweensOf("*");

    // loader
    const loaderEl = document.getElementById("loader");
    const countEl = document.getElementById("loader-count");
    if (!loaderEl || !countEl) return;
    const counter = { val: 0 };

    gsap.to(counter, {
        val: 100,
        duration: 2,
        ease: "power2.inOut",
        onUpdate() {
            countEl.textContent = Math.round(counter.val);
        },
        onComplete() {
            const percentSpan = countEl.nextElementSibling;
            if (percentSpan) percentSpan.style.display = "none";

            countEl.innerHTML = "NexaNode"
                .split("")
                .map(
                    (char) =>
                        `<span class="wave-letter" style="display:inline-block;opacity:0">${char}</span>`,
                )
                .join("");

            const letters = document.querySelectorAll(".wave-letter");
            const tl = gsap.timeline();

            tl.to(letters, {
                y: 0,
                opacity: 1,
                duration: 0.5,
                ease: "back.out(1.7)",
                stagger: 0.07,
                from: { y: -60, opacity: 0 },
            })
                .to(letters, {
                    y: -40,
                    opacity: 0,
                    duration: 0.3,
                    ease: "power2.in",
                    stagger: 0.05,
                })
                .to(loaderEl, {
                    opacity: 0,
                    duration: 0.5,
                    ease: "power2.inOut",
                    onComplete() {
                        loaderEl.style.display = "none";
                    },
                })
                .to(
                    "body > *:not(#loader)",
                    {
                        opacity: 1,
                        duration: 0.6,
                        ease: "power2.out",
                    },
                    "-=0.2",
                );
        },
    });

    // scroll animations
    function scrambleOnScroll(selector, options = {}) {
        const elements = document.querySelectorAll(selector);
        elements.forEach((el) => {
            const originalText = el.textContent;
            gsap.fromTo(
                el,
                { scrambleText: { text: "" } },
                {
                    scrambleText: {
                        text: originalText,
                        chars: options.chars || "upperCase",
                        speed: options.speed || 1,
                    },
                    duration: options.duration || 2,
                    ease: options.ease || "power2.out",
                    scrollTrigger: {
                        trigger: el,
                        start: options.start || "top 80%",
                        toggleActions: "play none none none",
                    },
                },
            );
        });
    }

    function slideRightStagger(selector, options = {}) {
        const container = document.querySelector(selector);
        if (!container) return;
        gsap.from(container.children, {
            x: options.x || -50,
            opacity: 0,
            duration: options.duration || 2,
            ease: options.ease || "power3.out",
            stagger: options.stagger || 1,
            scrollTrigger: {
                trigger: container,
                start: options.start || "top 80%",
                toggleActions: "play none none none",
            },
        });
    }

    function slideLeft(selector, options = {}) {
        document.querySelectorAll(selector).forEach((el) => {
            const items = el.children.length ? el.children : [el];
            gsap.from(items, {
                x: options.x || 50,
                opacity: 0,
                duration: options.duration || 1,
                ease: options.ease || "power3.out",
                stagger: options.stagger || 0.2,
                scrollTrigger: {
                    trigger: el,
                    start: options.start || "top 80%",
                    toggleActions: "play none none none",
                },
            });
        });
    }

    function slideRight(selector, options = {}) {
        document.querySelectorAll(selector).forEach((el) => {
            const items = el.children.length ? el.children : [el];
            gsap.from(items, {
                x: options.x || -50,
                opacity: 0,
                duration: options.duration || 1,
                ease: options.ease || "power3.out",
                stagger: items.length > 1 ? options.stagger || 0.2 : 0,
                scrollTrigger: {
                    trigger: el,
                    start: options.start || "top 80%",
                    toggleActions: "play none none none",
                },
            });
        });
    }

    scrambleOnScroll(".scramble-text");
    slideLeft(".slide-left");
    slideRight(".slide-right");
    slideRightStagger(".slide-right-group");

    gsap.utils.toArray(".slide-right-card").forEach((card) => {
        gsap.from(card, {
            opacity: 0,
            x: -40,
            duration: 2,
            ease: "power3.out",
            scrollTrigger: {
                trigger: card,
                start: "top 85%",
                toggleActions: "play none none none",
            },
        });
    });

    gsap.utils.toArray(".slide-left-card").forEach((card) => {
        gsap.from(card, {
            opacity: 0,
            x: 40,
            duration: 2,
            ease: "power3.out",
            scrollTrigger: {
                trigger: card,
                start: "top 85%",
                toggleActions: "play none none none",
            },
        });
    });

    const rows = [
        { el: ".service-cols-1", x: 60 },
        { el: ".service-cols-2", x: -60 },
        { el: ".service-cols-3", x: 60 },
    ];

    rows.forEach(({ el, x }) => {
        gsap.set(el, { opacity: 0, x });
        gsap.to(el, {
            opacity: 1,
            x: 0,
            duration: 2,
            ease: "power3.out",
            scrollTrigger: {
                trigger: el,
                start: "top 80%",
                toggleActions: "play none none none",
            },
        });
    });
});
