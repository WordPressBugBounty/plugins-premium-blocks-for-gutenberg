(() => {
    function initInstaFeed(blockId, postsCount, attributes, breakpoints) {
        const instaFeed = document.querySelector(`.${blockId}`);

        if (!instaFeed || postsCount === 0) return;

        const {
            clickAction,
            displayVideoOnClick,
            layoutStyle,
            autoPlay,
            imagesInRow,
            autoPlayTime,
            postsGap,
        } = attributes;

        if (clickAction === "none" && displayVideoOnClick) {
            const videoWrappers = instaFeed.querySelectorAll(
                ".pbg-insta-feed-media.pbg-insta-video-wrap",
            );

            if (!videoWrappers.length) return;

            videoWrappers.forEach((wrapper) => {
                const image = wrapper.querySelector("img");
                const video = wrapper.querySelector("video");

                if (!video || !image) return;

                image.style.cursor = "pointer";
                image.addEventListener("click", () => {
                    video.style.visibility = "visible";
                });
            });
        }

        if (clickAction === "lightBox") {
            const lightBoxInstance = fsLightboxInstances[blockId];

            if (!lightBoxInstance) return;

            lightBoxInstance.props.onInit = () => {
                lightBoxInstance.elements.container.classList.add(
                    `${blockId}`,
                    "pbg-insta-feed-fslightbox-theme",
                );
            };
        }

        if (layoutStyle === "masonry") {
            const $masonry = instaFeed.querySelector(".pbg-insta-feed-masonry");

            if (!$masonry) return;

            const { defaultView } = $masonry.ownerDocument;

            if (!defaultView?.Isotope) {
                console.error("Isotope library is not loaded.");
                return;
            }

            const ISOTOPE_CONFIG = {
                itemSelector: ".pbg-insta-feed-wrap",
                percentPosition: true,
                resize: false,
                layoutMode: "masonry",
                masonry: {
                    columnWidth: ".pbg-insta-feed-wrap",
                    horizontalOrder: true,
                },
            };

            let isotopeInstance;

            if (typeof imagesLoaded === "function") {
                imagesLoaded($masonry, function () {
                    isotopeInstance = new defaultView.Isotope(
                        $masonry,
                        ISOTOPE_CONFIG,
                    );

                    imagesLoaded($masonry).on("progress", function () {
                        isotopeInstance.arrange();
                    });
                });
            } else {
                console.warn("imagesLoaded library is not loaded.");
                isotopeInstance = new defaultView.Isotope(
                    $masonry,
                    ISOTOPE_CONFIG,
                );
            }

            const DEBOUNCE_DELAY = 100;
            let resizeObserver;
            let resizeTimeout;

            function handleResize() {
                if (resizeTimeout) {
                    clearTimeout(resizeTimeout);
                }
                resizeTimeout = setTimeout(() => {
                    if (isotopeInstance) {
                        isotopeInstance.layout();
                    }
                }, DEBOUNCE_DELAY);
            }

            resizeObserver = new ResizeObserver(handleResize);
            resizeObserver.observe($masonry);

            window.addEventListener("resize", handleResize);
        }

        if (layoutStyle === "carousel") {
            const $carousel = instaFeed.querySelector(
                ".pbg-insta-feed-carousel",
            );

            if (!$carousel) return;

            if (typeof Splide === "undefined") {
                console.error("Splide library is not loaded.");
                return;
            }

            if (!breakpoints || !breakpoints.tablet || !breakpoints.mobile) {
                console.warn(
                    "Breakpoints for tablet or mobile are not defined.",
                );
            }

            const CAROUSEL_SPEED = 500;
            const TABLET_BREAKPOINT = parseInt(
                breakpoints.tablet?.replace(/\D/g, ""),
                10,
            );
            const MOBILE_BREAKPOINT = parseInt(
                breakpoints.mobile?.replace(/\D/g, ""),
                10,
            );

            const carouselSettings = {
                type: autoPlay ? "loop" : "slide",
                perPage: +PBG_Helpers.getResponsiveValue(
                    imagesInRow,
                    "Desktop",
                ),
                perMove: 1,
                autoplay: autoPlay,
                arrows: true,
                pagination: false,
                interval: autoPlayTime,
                speed: CAROUSEL_SPEED,
                focus: 0,
                omitEnd: true,
                gap: PBG_Helpers.getResponsiveValue(postsGap, "Desktop"),
                breakpoints: {
                    [TABLET_BREAKPOINT]: {
                        perPage: +PBG_Helpers.getResponsiveValue(
                            imagesInRow,
                            "Tablet",
                        ),
                        gap: PBG_Helpers.getResponsiveValue(postsGap, "Tablet"),
                    },
                    [MOBILE_BREAKPOINT]: {
                        perPage: +PBG_Helpers.getResponsiveValue(
                            imagesInRow,
                            "Mobile",
                        ),
                        gap: PBG_Helpers.getResponsiveValue(postsGap, "Mobile"),
                    },
                },
            };

            if (typeof imagesLoaded === "function") {
                imagesLoaded($carousel, function () {
                    const splide = new Splide($carousel, carouselSettings);
                    splide.mount();
                });
            } else {
                console.warn("imagesLoaded library is not loaded.");
                const splide = new Splide($carousel, carouselSettings);
                splide.mount();
            }
        }
    }

    function initInstagramFeedPostsBlocks() {
        const instaFeedsSettings = window.PBG_INSTAFEED || {};
        const { breakpoints, blocks } = instaFeedsSettings;

        if (!blocks || typeof blocks !== "object") {
            return;
        }

        Object.keys(blocks).forEach((blockId) => {
            if (!blockId) return;

            const { postsCount, attributes } = blocks[blockId];

            initInstaFeed(blockId, postsCount, attributes, breakpoints);
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener(
            "DOMContentLoaded",
            initInstagramFeedPostsBlocks,
        );
    } else {
        initInstagramFeedPostsBlocks();
    }
})();
