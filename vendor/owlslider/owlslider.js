jQuery(window).ready(function () {
    const owl = jQuery(".featured-insights .owl-carousel");
    function initializeCarousel() {

        owl.owlCarousel({
            onInitialized: updateDots,
            onChanged: updateDots,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 800,
            dots: true,
            nav: true,
            center: true,
            mouseDrag: false,
            touchDrag: true,
            responsive: {
                0: {
                    items: 1.47,
                    margin: 32
                },
                768: {
                    items: window.matchMedia("(orientation: portrait)").matches ? 1.89 : 3,
                    margin: window.matchMedia("(orientation: portrait)").matches ? 57.3 : 50,
                    stagePadding: window.matchMedia("(orientation: portrait)").matches ? 0 : 40
                },

                1024: {
                    items: 3,
                    margin: 40,
                    stagePadding: 40
                },
                1440: {
                    items: 3,
                    margin: 86,
                    stagePadding: 64
                }
            }
        });
    }
    // Function to update responsiveness dynamically
    function updateResponsiveSettings() {
        const isPortrait = window.matchMedia("(orientation: portrait)").matches;

        const newResponsive = {
            0: {
                items: 1.47,
                margin: 32
            },
            768: {
                items: isPortrait ? 1.89 : 3,
                margin: isPortrait ? 57.3 : 50,
                stagePadding: isPortrait ? 0 : 40
            },

            1024: {
                items: 3,
                margin: 40,
                stagePadding: 40
            },
            1440: {
                items: 3,
                margin: 86,
                stagePadding: 64
            }
        };

        // Use the `trigger` method to update responsive settings
        jQuery(owl).trigger("refresh.owl.carousel");
        jQuery(owl).data("owl.carousel").options.responsive = newResponsive;
    }
    // Initialize the carousel on page load
    initializeCarousel();

    // Pause only on center item hover
    function handleActiveHover() {
    owl.find(".owl-item.active .insights-featured").off("mouseenter mouseleave");
    owl.find(".owl-item.active .insights-featured").each(function () {
        jQuery(this).on("mouseenter", function () {
            owl.trigger("stop.owl.autoplay");
        }).on("mouseleave", function () {
            const playPauseBtn = jQuery(".carousel-controls #playPauseBtn svg");
            if (!playPauseBtn.hasClass("ic-pause")) {
                owl.trigger("play.owl.autoplay", [5000]);
            }
        });
    });
}

// Call after initialization
owl.on("initialized.owl.carousel changed.owl.carousel refreshed.owl.carousel", function () {
    handleActiveHover();
});

    // Initial setup
    handleActiveHover();

    let resizeTimeout;
    jQuery(window).on("resize", function () {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(updateResponsiveSettings, 300);
    });

    // Pause autoplay on swipe and resume after a delay
    let autoplayTimeout;
    owl.on("dragged.owl.carousel", function () {
        owl.trigger("stop.owl.autoplay");
        clearTimeout(autoplayTimeout);
        autoplayTimeout = setTimeout(() => {
            owl.trigger("play.owl.autoplay", [5000]);
        }, 100);
    });
    function updateDots(event) {
        const totalItems = event.item.count;
        const dotsContainer = jQuery(".featured-insights .owl-carousel .owl-dots");
        const navContainer = jQuery(".featured-insights .owl-carousel .owl-nav");
        if (totalItems <= 3) {
            dotsContainer.removeClass('disabled');
            navContainer.removeClass('disabled');
        }
    }

});