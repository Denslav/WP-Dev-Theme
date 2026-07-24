window.addEventListener('DOMContentLoaded', function () {
    if (!window.Fancybox) {
        return;
    }

    window.Fancybox.bind('[data-fancybox]', {
        on: {
            ready: function () {
                let fancyBoxItems = document.querySelectorAll('[data-fancybox]');
                let hashUrl = window.location.hash.toLowerCase();

                if (!fancyBoxItems.length || !hashUrl) {
                    return;
                }

                fancyBoxItems.forEach(function (link) {
                    let fancyAttribute = (link.getAttribute('data-fancybox') || '').toLowerCase();

                    if (!fancyAttribute || !hashUrl.includes(fancyAttribute)) {
                        return;
                    }

                    let image = link.querySelector('img:not(.skip-lazy)');

                    if (!image || !image.dataset.src) {
                        return;
                    }

                    image.src = image.dataset.src;

                    if (image.dataset.srcset) {
                        image.srcset = image.dataset.srcset;
                    }

                    if (image.dataset.sizes) {
                        image.sizes = image.dataset.sizes;
                    }

                    image.classList.add('lazy-loaded');
                    image.classList.remove('thm-lazy-loading');
                    image.removeAttribute('data-src');
                });
            }
        }
    });
});
