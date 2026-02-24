<!DOCTYPE html>
<html lang="en">
<body>

<!-- Splide JS -->
<script src="../node_modules/@splidejs/splide/dist/js/splide.min.js"></script>
<script src="../node_modules/@splidejs/splide-extension-auto-scroll/dist/js/splide-extension-auto-scroll.min.js"></script>

<script>
    document.addEventListener( 'DOMContentLoaded', function () {
        new Splide( '#image-autoscroll', {
            arrows: false,
            type   : 'loop',
            drag   : 'free',
            focus  : 'center',
            pagination: false,
            perPage: 2,
            autoScroll: {
                speed: 1,
            },
        } ).mount(window.splide.Extensions);
    } );
</script>
</body>
</html>