document.addEventListener("DOMContentLoaded", function() {
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
});
