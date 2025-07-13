function toggleMenu(el) {
    const nav = document.getElementById("main-nav");
    nav.classList.toggle("show");
    el.classList.toggle("active");
  }
  

function handleContactForm(event) {
    event.preventDefault();
    document.getElementById("formResponse").textContent = "Thank you! We’ll contact you soon.";
}
