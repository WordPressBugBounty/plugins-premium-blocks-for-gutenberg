document.addEventListener("DOMContentLoaded", function () {
    const fancyTextBlocks = document.querySelectorAll(".premium-fancy-text");

    fancyTextBlocks.forEach((elem, index) => {
        let current = 0;
        let interval = null;
        let timeoutRef = null;
        const highlightedBlocks = elem.querySelector(
            ".premium-fancy-text-title-highlighted"
        );

        const effect = elem.dataset.effect;
        const strings = elem.dataset.strings;
        const fancyStrings = strings ? strings.split(",") : [];

        function clearCurrentTimeout() {
            if (timeoutRef) {
                clearTimeout(timeoutRef);
                timeoutRef = null;
            }
        }

        function getDataNum(attr) {
            return parseInt(elem.dataset[attr]) || 0;
        }

        function getDataBool(attr) {
            const value = elem.dataset[attr];
            return value === "true" || value === true;
        }

        // if (animationStyles == "text") {
        if (effect === "typing") {
            const fancyTextElement = elem.querySelector(
                ".premium-fancy-text-title-type"
            );

            if (fancyTextElement && typeof Typed !== "undefined") {
                const typedInstance = new Typed(fancyTextElement, {
                    strings: fancyStrings,
                    typeSpeed: getDataNum("typespeed"),
                    backSpeed: getDataNum("backspeed"),
                    startDelay: getDataNum("startdelay"),
                    backDelay: getDataNum("backdelay"),
                    showCursor: getDataBool("cursorshow"),
                    cursorChar: elem.dataset.cursormark || "|",
                    loop: getDataBool("loop"),
                });

                typedInstance.start();
            }
        } else {
            // Initialize first animation
            handleAnimation(elem, effect);

            // Set up interval for continuous animation
            interval = setInterval(() => {
                handleAnimation(elem, effect);
            }, getDataNum("pausetime"));

            // Mouse enter event
            elem.addEventListener("mouseenter", () => {
                if (interval && getDataBool("hoverpause")) {
                    clearInterval(interval);
                    interval = null;
                    clearCurrentTimeout();
                }
            });

            // Mouse leave event
            elem.addEventListener("mouseleave", () => {
                if (getDataBool("hoverpause") && !interval) {
                    interval = setInterval(() => {
                        handleAnimation(elem, effect);
                    }, getDataNum("pausetime"));

                    if (effect === "clip") {
                        const slideList = elem.querySelector(
                            ".premium-fancy-text-title-slide-list"
                        );
                        if (slideList) {
                            timeoutRef = setTimeout(() => {
                                slideList.style.width = "0px";
                            }, getDataNum("pausetime") - getDataNum("animationspeed"));
                        }
                    }
                }
            });
        }
        // }

        /**
         * Handles the animation for the given element based on the specified effect.
         *
         * @param {HTMLElement} elem - The element to animate.
         * @param {string} effect - The animation effect to apply.
         */
        function handleAnimation(elem, effect) {
            const parent = elem.querySelector(
                ".premium-fancy-text-title-slide-list"
            );

            if (!parent || !parent.children.length) return;

            const children = parent.children;
            const animationSpeed = getDataNum("animationspeed");
            const pauseTime = getDataNum("pausetime");

            clearCurrentTimeout();

            for (const element of children) {
                element.className = "";
            }

            const currentElement = children[current];
            if (!currentElement) return;

            const elementWidth = currentElement.offsetWidth;
            parent.style.width = `${elementWidth + 5}px`;
            currentElement.classList.add("is-visible");

            switch (effect) {
                case "clip":
                    parent.style.transitionDuration = `${
                        animationSpeed / 1000
                    }s`;

                    timeoutRef = setTimeout(() => {
                        parent.style.width = "0px";
                    }, pauseTime - animationSpeed);

                    current = (current + 1) % children.length;
                    break;

                case "slide":
                    currentElement.classList.add("fancy-slide-in");
                    currentElement.style.transitionDuration = `${
                        animationSpeed / 1000
                    }s`;

                    current = (current + 1) % children.length;

                    timeoutRef = setTimeout(() => {
                        currentElement.classList.add("fancy-slide-out");
                    }, pauseTime - animationSpeed);
                    break;

                case "letter-flow":
                    Array.from(children).forEach((word) => {
                        const letters = word.textContent.split("");
                        word.innerHTML = "";

                        letters.forEach((letter) => {
                            const span = document.createElement("span");
                            span.style.transitionDuration = `${
                                animationSpeed / letters.length
                            }ms`;
                            span.textContent = letter;
                            word.appendChild(span);
                        });
                    });

                    current = (current + 1) % children.length;
                    const nextElement = children[current];

                    if (nextElement) {
                        const currentLetters = Array.from(
                            currentElement.children
                        );
                        const nextLetters = Array.from(nextElement.children);

                        // Animate current letters out
                        currentLetters.forEach((letter, index) => {
                            timeoutRef = setTimeout(() => {
                                letter.classList.add("letter-flow-out");
                            }, pauseTime - animationSpeed + index * 0.25 * (animationSpeed / currentLetters.length));
                        });

                        // Animate next letters in
                        nextLetters.forEach((letter, index) => {
                            timeoutRef = setTimeout(() => {
                                letter.classList.add("letter-flow-in");
                                if (parent) {
                                    parent.style.width = `${nextElement.offsetWidth}px`;
                                }
                            }, pauseTime - animationSpeed + index * 0.25 * (animationSpeed / currentLetters.length));
                        });
                    }
                    break;

                default:
                    currentElement.classList.add(`fancy-${effect}`);
                    currentElement.style.animationDuration = `${
                        animationSpeed / 1000
                    }s`;
                    current = (current + 1) % children.length;
                    break;
            }
        }

        if (highlightedBlocks) {
            var computedStyle = getComputedStyle(elem),
                animationDelay =
                    computedStyle.getPropertyValue("--pbg-animation-delay") ||
                    "4",
                animationSpeed =
                    computedStyle.getPropertyValue(
                        "--pbg-animation-duration"
                    ) || "3";

            // Parse the values and convert to numbers
            animationDelay = parseFloat(animationDelay);
            animationSpeed = parseFloat(animationSpeed);

            var animationInterval = null;

            var eleObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        highlightedBlocks.classList.add(
                            "pbg-highlighted-draw-shape"
                        );

                        // Set up continuous animation loop
                        const intervalDuration =
                            (animationSpeed + animationDelay) * 1000;
                        animationInterval = setInterval(function () {
                            highlightedBlocks.classList.add(
                                "pbg-highlighted-hide-shape"
                            );

                            setTimeout(function () {
                                highlightedBlocks.classList.remove(
                                    "pbg-highlighted-hide-shape"
                                );
                            }, 1000);
                        }, intervalDuration);

                        // Don't unobserve - let it continue repeating
                    } else {
                        // Clear interval when element is out of view
                        if (animationInterval) {
                            clearInterval(animationInterval);
                            animationInterval = null;
                        }
                        highlightedBlocks.classList.remove(
                            "pbg-highlighted-draw-shape",
                            "pbg-highlighted-hide-shape"
                        );
                    }
                });
            });

            eleObserver.observe(highlightedBlocks);
        }
    });
});
