// mobile nav
const btn = document.getElementById("btnMobile");
const drawer = document.getElementById("drawer");
btn?.addEventListener("click", () => {
    drawer.classList.toggle("hidden");
});

// back to top
const back = document.getElementById("backToTop");

window.addEventListener("scroll", () => {
    if (window.scrollY > 600) back.classList.remove("hidden");
    else back.classList.add("hidden");
});

back?.addEventListener("click", () => {
    const start = window.scrollY;
    const duration = 700; // thời gian (ms)
    const startTime = performance.now();

    const easeOutCubic = (t) => 1 - Math.pow(1 - t, 3);

    const scroll = (currentTime) => {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const eased = easeOutCubic(progress);
        window.scrollTo(0, start * (1 - eased));

        if (elapsed < duration) requestAnimationFrame(scroll);
    };

    requestAnimationFrame(scroll);
});

// year
document.getElementById("year").textContent = new Date().getFullYear();
