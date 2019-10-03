<script>
    const navContainer = document.getElementById('main-navbar-container'),
        navLinks = document.querySelectorAll('.main-navbar-link'),
        navToggleButton = document.getElementById('nav-toggle-button');

    let navigationShown = false;

    function toggleNav() {
        if (!navigationShown) {

            let promise = new Promise(function(resolve) {
                setTimeout(function() {
                    resolve(openNav());
                });
            });

            promise.then(function(result) {
                if (result && navigationShown) {
                    document.addEventListener('click', function(e) {
                       if (e.target.className !== 'main-navbar-link') {
                           closeNav();
                       }
                    });
                }
            });

        } else {
            closeNav();
        }
    }

    function openNav() {
        navigationShown = true;
        navContainer.style.width = window.screen.width > 768 ? "50%" : "100%";
        navLinks.forEach(function (link) {
            link.style.visibility = 'visible';
        });
        navToggleButton.classList.remove('fa-bars');
        navToggleButton.classList.add('fa-times');

        return true;
    }

    function closeNav() {
        navigationShown = false;
        navContainer.style.width = "0%";
        navLinks.forEach(function (link) {
            link.style.visibility = 'hidden';
        });
        navToggleButton.classList.remove('fa-times');
        navToggleButton.classList.add('fa-bars');
    }
</script>
