document.addEventListener("DOMContentLoaded", ()=> {
      // Show/Hide password toggle
      const togglePassword = document.querySelector("#togglePassword");
      const password = document.querySelector("#password");

      togglePassword.addEventListener("click", function () {
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        // Change icon
        this.innerHTML = type === "password" 
          ? '<i class="bi bi-eye-fill"></i>' 
          : '<i class="bi bi-eye-slash-fill"></i>';
      });
});


  document.addEventListener("DOMContentLoaded", ()=> {
    let myModal = new bootstrap.Modal(document.getElementById('modal_data'));
    myModal.show();
});


document.addEventListener("DOMContentLoaded", () => {
    let password = document.getElementById("password");
    let checkbox = document.getElementById("checkbox");

    checkbox.addEventListener("change", () => {
        if (checkbox.checked) {
            password.type = "text";
        } else {
            password.type = "password";
        }
    });
});