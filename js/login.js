document.addEventListener('DOMContentLoaded', function () {
    const switches = document.querySelectorAll('.form-switch');

    switches.forEach(function (switchElement) {
        switchElement.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const targetCard = document.querySelector(targetId);

            if (targetCard) {
                // Hide all cards
                document.querySelectorAll('.card').forEach(card => {
                    card.style.display = 'none';
                });

                // Show the target card
                targetCard.style.display = 'block';
            }
        });
    });
});
