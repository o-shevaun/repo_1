document.addEventListener("DOMContentLoaded", function () {
  const navLinks = document.querySelectorAll(".dashboard-nav a");

  navLinks.forEach(link => {
    link.addEventListener("click", function () {
      removeActiveClass();
      link.classList.add("active");
    });
  });

  function removeActiveClass() {
    navLinks.forEach(link => {
      link.classList.remove("active");
    });
  }
});
