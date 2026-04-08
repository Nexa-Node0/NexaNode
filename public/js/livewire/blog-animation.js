gsap.utils.toArray(".staggerRight").forEach((el) => {
  gsap.fromTo(
    el,
    { x: 40, opacity: 0 },
    {
      x: 0,
      opacity: 1,
      duration: 1,
      ease: "power3.out",
      overwrite: "auto",
      scrollTrigger: {
        trigger: el, // 👈 each card triggers itself
        start: "top 85%",
        toggleActions: "play none none none",
      },
    },
  );
});

let mm = gsap.matchMedia();

mm.add("(min-width: 768px)", () => {
  gsap.utils.toArray(".slideLeftCard").forEach((el) => {
    gsap.fromTo(
      el,
      { x: -40, opacity: 0 },
      {
        x: 0,
        opacity: 1,
        duration: 1,
        ease: "power3.out",
        scrollTrigger: {
          trigger: el,
          start: "top 85%",
          toggleActions: "play none none none",
        },
      },
    );
  });
});

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

slideRight(".slide-right");
