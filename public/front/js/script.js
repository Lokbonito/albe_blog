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
back?.addEventListener("click", () =>
  window.scrollTo({ top: 0, behavior: "smooth" })
);

// year
document.getElementById("year").textContent = new Date().getFullYear();

// Slider

const slider = document.getElementById("sliderTrack");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");

let currentIndex = 0;
const totalSlides = slider.children.length;

function updateSlider() {
  slider.style.transform = `translateX(-${currentIndex * 100}%)`;
}

function goNext() {
  currentIndex = (currentIndex + 1) % totalSlides;
  updateSlider();
}

function goPrev() {
  currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
  updateSlider();
}

prevBtn.addEventListener("click", goPrev);
nextBtn.addEventListener("click", goNext);

setInterval(goNext, 5000);


