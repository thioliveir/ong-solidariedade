// Menu Toggle
const menuToggle = document.querySelector("#menu-toggle")
const asideMenu = document.querySelector("#aside-menu")
const mainContent = document.querySelector("#main-content")

menuToggle.addEventListener("click", () => {
    asideMenu.classList.toggle("collapsed")
    mainContent.classList.toggle("collapsed")
})

