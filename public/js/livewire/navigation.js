window.addEventListener("load", () => {
    gsap.registerPlugin(ScrollTrigger);
    const navbar = document.querySelector(".navbar");

    ScrollTrigger.create({
        onUpdate: (self) => {
            if (self.direction === 1 && window.scrollY > 100) {
                gsap.to(navbar, {
                    yPercent: -100,
                    duration: 0.3,
                    ease: "power2.out",
                });
            } else {
                gsap.to(navbar, {
                    yPercent: 0,
                    duration: 0.3,
                    ease: "power2.out",
                });
            }
        },
    });
});
