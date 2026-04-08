(() => {
    const initVideoBoxes = () => {
        const videoBoxes = document.querySelectorAll(".premium-video-box");

        if (!videoBoxes.length) {
            return;
        }

        videoBoxes.forEach((box) => {
            try {
                initVideoBox(box);
            } catch (error) {
                console.error("Error initializing video box:", error);
            }
        });
    };

    const initVideoBox = (box) => {
        // Early validation
        const container = box.querySelector(
            ".premium-video-box-video-container",
        );
        if (!container) {
            console.warn("Video container not found in video box");
            return;
        }

        const video = box.querySelector("iframe, video");

        const type = box.dataset.type;
        const showOverlay = box.dataset.overlay;
        const src = container.dataset.src;

        // Validate required data
        if (!src && type !== "self") {
            console.warn("Video source not found in video box");
            return;
        }

        // Set initial overlay state
        if (type === "self" && showOverlay === "false") {
            box.classList.add("video-overlay-false");
        }

        // Extract autoplay value once
        const autoPlayValue = src
            ? src.match(/autoplay=(false|0|true|1)/)?.[1]
            : null;
        const shouldAutoPlay =
            autoPlayValue === "1" || autoPlayValue === "true";

        const handleBoxClick = () => {
            try {
                // Update video source for autoplay
                const updatedVideoSrc = src.replace(
                    /autoplay=(false|0)/,
                    (match, value) => {
                        return value === "false"
                            ? "autoplay=true"
                            : "autoplay=1";
                    },
                );

                container.style.background = "#000";

                // Create iframe for external videos (YouTube, Vimeo, etc.)
                if (type !== "self") {
                    const existingIframe = container.querySelector("iframe");

                    if (!existingIframe) {
                        const iframe = document.createElement("iframe");
                        iframe.src = updatedVideoSrc;
                        iframe.allow = "encrypted-media; autoplay;";
                        iframe.allowFullscreen = true;
                        iframe.loading = "lazy";

                        container.appendChild(iframe);
                    }
                }

                // Update overlay classes
                box.classList.add("video-overlay-false");
                box.classList.remove("video-overlay-true");

                // Play video after transition
                setTimeout(() => {
                    const currentVideo = box.querySelector("iframe, video");

                    if (type === "self" && currentVideo) {
                        // For self-hosted videos
                        if (typeof currentVideo.play === "function") {
                            currentVideo.play().catch((error) => {
                                console.error("Error playing video:", error);
                            });
                        }
                    } else if (type !== "self" && currentVideo) {
                        // For external videos (update src if needed)
                        if (currentVideo.src !== updatedVideoSrc) {
                            currentVideo.src = updatedVideoSrc;
                        }
                    }
                }, 300);
            } catch (error) {
                console.error("Error handling video box click:", error);
            }
        };

        box.addEventListener("click", handleBoxClick, { once: true });

        // Handle autoplay for external videos
        if (type !== "self" && shouldAutoPlay) {
            handleBoxClick();
        }

        // Handle autoplay for self-hosted videos with overlay
        if (type === "self" && showOverlay === "true" && video) {
            const autoPlayAttr = video.getAttribute("autoplay");
            if (autoPlayAttr !== null && autoPlayAttr !== "false") {
                handleBoxClick();
            }
        }
    };

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initVideoBoxes);
    } else {
        initVideoBoxes();
    }
})();
