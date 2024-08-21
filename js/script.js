document.addEventListener("DOMContentLoaded", function() {
    // Handle form switch functionality
    var formSwitches = document.querySelectorAll(".form-switch");
    formSwitches.forEach(function(formSwitch) {
        formSwitch.addEventListener("click", function() {
            var targetCard = document.querySelector(this.getAttribute("data-target"));
            var allCards = document.querySelectorAll(".card");
            allCards.forEach(function(card) {
                card.style.display = "none";
            });
            if (targetCard) {
                targetCard.style.display = "block";
            }
        });
    });

    // Client-side validation
    var forms = document.querySelectorAll(".needs-validation");
    forms.forEach(function(form) {
        form.addEventListener("submit", function(event) {
            var isValid = form.checkValidity();
            if (!isValid) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add("was-validated");
        });
    });

    // Additional client-side checks
    document.getElementById("signup-form").addEventListener("submit", function(event) {
        var name = document.getElementById("signup-name").value.trim();
        var email = document.getElementById("signup-email").value.trim();
        var password = document.getElementById("signup-password").value;

        if (!name || !email || !password) {
            event.preventDefault();
            alert("All fields are required.");
        } else if (!validateEmail(email)) {
            event.preventDefault();
            alert("Please enter a valid email address.");
        }
    });

    document.getElementById("signin-form").addEventListener("submit", function(event) {
        var email = document.getElementById("signin-email").value.trim();
        var password = document.getElementById("signin-password").value;

        if (!email || !password) {
            event.preventDefault();
            alert("Both email and password are required.");
        } else if (!validateEmail(email)) {
            event.preventDefault();
            alert("Please enter a valid email address.");
        }
    });

    document.getElementById("forgot-password-form").addEventListener("submit", function(event) {
        var email = document.getElementById("forgot-password-email").value.trim();

        if (!email) {
            event.preventDefault();
            alert("Email is required.");
        } else if (!validateEmail(email)) {
            event.preventDefault();
            alert("Please enter a valid email address.");
        }
    });

    // Function to validate email format
    function validateEmail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});
