const premiumCountUpInit = () => {
    // Check if CountUp library is available
    if (typeof countUp === "undefined") {
        console.error("CountUp library not loaded");
        return;
    }

    const counterBlocks = document.querySelectorAll(
        ".premium-countup__wrap"
    );

    if (!counterBlocks.length) return;

    // Store timeout IDs and CountUp instances for each element
    const elementData = new Map();

    // Single shared IntersectionObserver for all counter elements
    const sharedObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                const element = entry.target;
                const data = elementData.get(element);

                if (!data) return;

                if (entry.isIntersecting) {
                    // Clear any existing timeout
                    if (data.timeoutId) {
                        clearTimeout(data.timeoutId);
                    }

                    // Start animation after delay
                    data.timeoutId = setTimeout(() => {
                        if (data.counterUp && !data.counterUp.error) {
                            data.counterUp.start();
                        }
                        // Stop observing this element after animation starts
                        sharedObserver.unobserve(element);
                        // Clean up the stored data
                        elementData.delete(element);
                    }, data.delay);
                } else {
                    // Element left viewport before animation started
                    if (data.timeoutId) {
                        clearTimeout(data.timeoutId);
                        data.timeoutId = null;
                    }
                }
            });
        },
        { threshold: 0.1 }
    );

    counterBlocks.forEach((wrapperElement) => {
        const counterElements = wrapperElement.querySelectorAll(
            ".premium-countup__increment"
        );

        // Validation
        if (!counterElements.length) {
            console.warn("Counter elements not found in:", wrapperElement);
            return;
        }

        counterElements.forEach((counterElement) => {
            // Check if already initialized
            if (counterElement.classList.contains("premium-countup-init")) {
                return;
            }

            // Parse and validate attributes
            const intervalAttr = counterElement.getAttribute("data-interval");
            const delayAttr = counterElement.getAttribute("data-delay");
            const targetAttr = counterElement.getAttribute("data-target");
            const counterText = counterElement.textContent.trim();

            const duration = Math.max(0, Number(intervalAttr) / 1000) || 2;
            const delay = Math.max(0, Number(delayAttr)) || 0;

            let counter;
            if (targetAttr) {
                counter = Number(targetAttr);
            } else {
                const cleanedText = counterText.replace(/[,\s]/g, "");
                counter = Number(cleanedText);
            }

            if (isNaN(counter)) {
                console.warn("Invalid counter value:", counterText);
                return;
            }

            // Initialize CountUp instance
            const counterUp = new countUp.CountUp(counterElement, counter, {
                duration: duration,
                useGrouping: true, // Enable grouping to show commas (e.g., 12,374)
                enableScrollSpy: false,
                useEasing: false,
            });

            if (counterUp.error) {
                console.error("CountUp initialization error:", counterUp.error);
                return;
            }

            // Mark as initialized
            counterElement.classList.add("premium-countup-init");

            // Store data for this specific counter element (not the wrapper)
            elementData.set(counterElement, {
                counterUp: counterUp,
                delay: delay,
                timeoutId: null,
            });

            // Start observing the individual counter element, not the wrapper
            sharedObserver.observe(counterElement);
        });
    });
};

window.premiumCountUpInit = premiumCountUpInit;

document.addEventListener("DOMContentLoaded", () => {
    premiumCountUpInit();
});
