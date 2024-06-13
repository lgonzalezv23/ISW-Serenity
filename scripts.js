document.addEventListener('DOMContentLoaded', function() {
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
});
