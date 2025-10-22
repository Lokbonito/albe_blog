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

