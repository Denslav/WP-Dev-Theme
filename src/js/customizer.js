/* global wp, jQuery */
(function ($) {
    wp.customize('blogname', function (value) {
        value.bind(function (to) {
            $('.site-title').text(to);
        });
    });

    wp.customize('blogdescription', function (value) {
        value.bind(function (to) {
            $('.site-description').text(to);
        });
    });

    wp.customize('header_textcolor', function (value) {
        value.bind(function (to) {
            let color = to === 'blank' ? '' : '#' + to;
            $('.site-title').css('color', color);
        });
    });

    wp.customize('main_container_width', function (value) {
        value.bind(function (to) {
            document.documentElement.style.setProperty('--main-container-width', to + 'px');
        });
    });

    wp.customize('main_container_padding', function (value) {
        value.bind(function (to) {
            document.documentElement.style.setProperty('--main-container-padding', to + 'px');
        });
    });

    wp.customize('main_header_bg_color', function (value) {
        value.bind(function (to) {
            document.documentElement.style.setProperty('--main-header-background', to);
        });
    });

    wp.customize('main_footer_bg_color', function (value) {
        value.bind(function (to) {
            document.documentElement.style.setProperty('--main-footer-background', to);
        });
    });
}(jQuery));
