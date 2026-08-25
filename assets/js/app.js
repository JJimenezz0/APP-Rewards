document.addEventListener("DOMContentLoaded", () => {
    const loginFormElement = document.querySelector("#loginForm");

    if (loginFormElement) {
        loginFormElement.addEventListener("submit", (eventObject) => {
            const emailInput = document.querySelector("#userEmail");
            const passwordInput = document.querySelector("#userPassword");

            if (emailInput.value.trim() === "" || passwordInput.value.trim() === "") {
                eventObject.preventDefault();
                alert("ACCESS DENIED: All fields are required.");
            }
        });
    }
});