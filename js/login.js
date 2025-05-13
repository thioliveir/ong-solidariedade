// Mensagem Validation inputs
document.querySelector("form").addEventListener("submit", function (event) {
    if(!this.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
    }

    this.classList.add("was-validated")
})

// Button toggle password
document.getElementById("togglePassword").addEventListener("click", function() {
    const passwordInput = document.getElementById("password")
    const icon = document.querySelector("i")

    const isPassword = passwordInput.type === "password"
    passwordInput.type = isPassword ? "text" : "password"

    icon.classList.toggle("bi-eye-slash")
    icon.classList.toggle("bi-eye") 
})