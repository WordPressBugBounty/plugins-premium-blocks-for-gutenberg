window.addEventListener("DOMContentLoaded", () => {
    const wpAdminBar = document.querySelector("#wpadminbar") ? true : false;

    const siteContent = document.querySelectorAll(
        "body > *:not(.premium-off-canvas-wrapper)",
    );

    const siteContentWrapper = document.createElement("div");
    siteContentWrapper.classList.add("premium-off-canvas-site-content-wrapper");

    siteContent.forEach((element) => {
        siteContentWrapper.appendChild(element);
    });

    document.body.appendChild(siteContentWrapper);

    const offCanvasBlocks = document.querySelectorAll(".premium-off-canvas");

    offCanvasBlocks.forEach((block) => {
        const offCanvasBox = block;

        const {
            blockid: blockId,
            triggertype: triggerType,
            contentposition: contentPosition,
            contenttransition: contentTransition,
            contentcornertransition: contentCornerTransition,
            offcanvastype: offCanvasType,
            closeonesc: closeOnESC,
            closeonclickoutside: closeOnClickOutside,
            icontypeselect: iconTypeSelect,
            svgurl: svgUrl,
        } = offCanvasBox.dataset;

        const contentEntranceAnimation = JSON.parse(
            offCanvasBox.dataset.contententranceanimation,
        );

        const offCanvasWrapper = offCanvasBox.querySelector(
            ".premium-off-canvas-wrapper",
        );

        const offCanvasContent = offCanvasWrapper.querySelector(
            ".premium-off-canvas-content",
        );

        document.body.appendChild(offCanvasWrapper);

        let startAnimationListener = false;

        if (wpAdminBar) {
            offCanvasContent.style.marginTop = "32px";

            if (contentPosition === "bottom") {
                offCanvasContent.style.marginTop = "0px";
            }

            offCanvasWrapper.querySelector(
                ".premium-off-canvas-overlay",
            ).style.marginTop = "32px";
        }

        if (triggerType === "button") {
            let button = offCanvasBox.querySelector(
                " .premium-off-canvas-trigger .premium-off-canvas-trigger-btn",
            );

            if (iconTypeSelect === "svg") {
                let svg = button.querySelector(
                    ` #premium-off-canvas-svg-${blockId}`,
                );
                svg.innerHTML = svgUrl;
            }

            button.addEventListener("click", openCanvas);
        }

        if (triggerType === "icon") {
            let icon = offCanvasBox.querySelector(
                ".premium-off-canvas-trigger .premium-off-canvas-trigger-icon",
            );

            icon.addEventListener("click", openCanvas);
        }

        if (triggerType === "image") {
            let image = offCanvasBox.querySelector(
                " .premium-off-canvas-trigger .premium-off-canvas-trigger-img",
            );

            image.addEventListener("click", openCanvas);
        }

        if (triggerType === "svg") {
            let svg = offCanvasBox.querySelector(
                ` #premium-off-canvas-trigger-svg-${blockId}`,
            );
            svg.innerHTML = svgUrl;

            svg.addEventListener("click", openCanvas);
        }

        if (triggerType === "lottie") {
            let lottie = offCanvasBox.querySelector(
                ".premium-off-canvas-trigger-lottie-animation",
            );

            lottie.addEventListener("click", openCanvas);
        }

        offCanvasWrapper
            .querySelector(".premium-off-canvas-content-close-button")
            ?.addEventListener("click", closeCanvas);

        if (closeOnClickOutside)
            offCanvasWrapper.addEventListener("click", (e) => {
                if (!offCanvasContent.contains(e.target)) {
                    closeCanvas();
                }
            });

        if (closeOnESC)
            document.addEventListener("keydown", (event) => {
                if (event.key === "Escape") {
                    closeCanvas();
                }
            });

        function openCanvas() {
            document.querySelector("body").style.overflow = "hidden";
            offCanvasWrapper.setAttribute("aria-hidden", "false");

            offCanvasContent.classList.add("panel-active");

            offCanvasWrapper
                .querySelector(".premium-off-canvas-overlay")
                ?.classList.add("overlay-active");

            // Applying Transition Push Animation
            if (
                offCanvasType === "slide" &&
                contentPosition &&
                contentTransition === "push"
            ) {
                setTimeout(() => {
                    offCanvasWrapper.style.zIndex = 99999;
                }, 500);
            }

            offCanvasContent.style.opacity = "1";
            offCanvasContent.style.contentVisibility = "visible";

            addContentEntranceAnimation();
        }

        function closeCanvas() {
            setTimeout(() => {
                document.querySelector("body").style.overflow = "";
                offCanvasWrapper.setAttribute("aria-hidden", "true");

                offCanvasContent.classList.remove("panel-active");

                offCanvasWrapper
                    .querySelector(".premium-off-canvas-overlay")
                    ?.classList.remove("overlay-active");

                setTimeout(() => {
                    offCanvasContent.style.opacity = "0";
                    offCanvasContent.style.contentVisibility = "hidden";
                }, 500);

                removeContentEntranceAnimation();
            }, 100);
        }

        const addContentEntranceAnimation = () => {
            const blockElement = offCanvasContent.querySelector(
                ".premium-off-canvas-content-body > .premium-off-canvas-content-body-inner-blocks-wrapper",
            );

            let animation = contentEntranceAnimation?.contentAnimation;

            // Handling backward compatibility for contentAnimation 2_2_11a
            if (typeof animation === "object") {
                animation = animation.value;
            }

            if (animation) {
                blockElement.style.contentVisibility = "hidden";

                if (!startAnimationListener) {
                    blockElement.addEventListener("animationstart", (e) => {
                        e.target.style.contentVisibility = "visible";
                    });

                    startAnimationListener = true;
                }

                blockElement.classList.add(animation);

                blockElement.style.animationTimingFunction =
                    contentEntranceAnimation.animationCurve;

                blockElement.style.animationDuration =
                    contentEntranceAnimation.animationDuration
                        ? `${contentEntranceAnimation.animationDuration}ms`
                        : "";
                blockElement.style.animationDelay =
                    contentEntranceAnimation.animationDelay
                        ? `${contentEntranceAnimation.animationDelay}ms`
                        : "";
            }
        };

        const removeContentEntranceAnimation = () => {
            const blockElement = offCanvasContent.querySelector(
                ".premium-off-canvas-content-body > .premium-off-canvas-content-body-inner-blocks-wrapper",
            );

            blockElement.classList.forEach((curClass) => {
                if (curClass.startsWith("pbg-")) {
                    blockElement.classList.remove(curClass);
                }
            });

            blockElement.style.removeProperty("animation-timing-function");
            blockElement.style.removeProperty("animation-duration");
            blockElement.style.removeProperty("animation-delay");
        };
    });
});
