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

slideLeft(".slide-left");
slideRight(".slide-right");
