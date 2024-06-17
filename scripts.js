document.addEventListener('DOMContentLoaded', function() {
    // Manejo del dropdown
    var dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(function(dropdown) {
        dropdown.addEventListener('click', function(event) {
            var content = this.querySelector('.dropdown-content');
            if (content.style.display === 'block') {
                content.style.display = 'none';
            } else {
                content.style.display = 'block';
            }
            event.stopPropagation();
        });
    });

    document.addEventListener('click', function() {
        dropdowns.forEach(function(dropdown) {
            var content = dropdown.querySelector('.dropdown-content');
            if (content.style.display === 'block') {
                content.style.display = 'none';
            }
        });
    });

    // Script para el acordeón
    var acc = document.querySelectorAll(".accordion");
    acc.forEach(function(accItem) {
        accItem.addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            } 
        });
    });
});
