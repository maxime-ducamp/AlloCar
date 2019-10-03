<script>
    let flashContainer = document.querySelector('.flash-show'),
        timeout = setTimeout(function() {
            switchFlashClasses();
        }, 5000);

    flashContainer.addEventListener('click', hideFlashContainer);

    function hideFlashContainer() {
        clearTimeout(timeout);
        switchFlashClasses();
    }

    function switchFlashClasses() {
        flashContainer.classList.remove('flash-show');
        flashContainer.classList.add('flash-hide');
    }

</script>
