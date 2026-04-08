(() => {
    const ANIMATION_DURATION = 500;

    const slideUpAccordion = (
        target,
        duration = ANIMATION_DURATION,
        callback = null,
    ) => {
        if (!target) return;

        const height = target.offsetHeight;

        Object.assign(target.style, {
            boxSizing: "border-box",
            height: `${height}px`,
            overflow: "hidden",
            transitionProperty: "height, margin, padding",
            transitionDuration: `${duration}ms`,
        });

        requestAnimationFrame(() => {
            Object.assign(target.style, {
                height: "0",
                paddingTop: "0",
                paddingBottom: "0",
                marginTop: "0",
                marginBottom: "0",
            });
        });

        setTimeout(() => {
            target.style.display = "none";
            const propertiesToRemove = [
                "height",
                "padding-top",
                "padding-bottom",
                "margin-top",
                "margin-bottom",
                "overflow",
                "transition-duration",
                "transition-property",
                "box-sizing",
            ];
            propertiesToRemove.forEach((prop) =>
                target.style.removeProperty(prop),
            );
            callback?.();
        }, duration);
    };

    const slideDownAccordion = (
        target,
        duration = ANIMATION_DURATION,
        callback = null,
    ) => {
        if (!target) return;

        target.style.removeProperty("display");
        const display =
            getComputedStyle(target).display === "none"
                ? "block"
                : getComputedStyle(target).display;
        target.style.display = display;

        const height = target.offsetHeight;

        Object.assign(target.style, {
            boxSizing: "border-box",
            height: "0",
            overflow: "hidden",
            paddingTop: "0",
            paddingBottom: "0",
            marginTop: "0",
            marginBottom: "0",
        });

        requestAnimationFrame(() => {
            Object.assign(target.style, {
                transitionProperty: "height, margin, padding",
                transitionDuration: `${duration}ms`,
                height: `${height}px`,
            });

            target.style.removeProperty("padding-top");
            target.style.removeProperty("padding-bottom");
            target.style.removeProperty("margin-top");
            target.style.removeProperty("margin-bottom");
        });

        setTimeout(() => {
            const propertiesToRemove = [
                "height",
                "overflow",
                "transition-duration",
                "transition-property",
                "box-sizing",
            ];
            propertiesToRemove.forEach((prop) =>
                target.style.removeProperty(prop),
            );
            callback?.();
        }, duration);
    };

    const openAccordionItem = (item, itemDescription, itemIcon, callback) => {
        slideDownAccordion(itemDescription, ANIMATION_DURATION, callback);
        itemIcon?.classList.remove("premium-accordion__closed");
        item.classList.add("is-active");
    };

    const closeAccordionItem = (item, itemDescription, itemIcon, callback) => {
        slideUpAccordion(itemDescription, ANIMATION_DURATION, callback);
        itemIcon?.classList.add("premium-accordion__closed");
        item.classList.remove("is-active");
    };

    const initAccordion = (accordion, settings) => {
        const { collapse_others = true, expand_first_item = true } =
            settings || {};

        const accordionItems = accordion.querySelectorAll(
            ".premium-accordion__content_wrap",
        );

        let isAnimating = false;

        if (!accordionItems.length) return;

        const resetAnimation = () => {
            isAnimating = false;
        };

        // Cache frequently accessed elements
        const itemData = Array.from(accordionItems).map((item) => ({
            item,
            title: item.querySelector(".premium-accordion__title_wrap"),
            description: item.querySelector(".premium-accordion__desc_wrap"),
            icon: item.querySelector(".premium-accordion__icon"),
        }));

        if (!collapse_others) {
            itemData.forEach(({ item, description, icon }) => {
                // Apply styles directly here to avoid animation on load
                description.style.display = "block";
                icon?.classList.remove("premium-accordion__closed");
                item.classList.add("is-active");
            });
        } else {
            if (expand_first_item && itemData[0]) {
                const { item, description, icon } = itemData[0];
                // Apply styles directly here to avoid animation on load
                description.style.display = "block";
                icon?.classList.remove("premium-accordion__closed");
                item.classList.add("is-active");
            }
            // Close all other items
            itemData.forEach(({ item, description, icon }, index) => {
                if (index !== 0 || !expand_first_item) {
                    description.style.display = "none";
                    icon?.classList.add("premium-accordion__closed");
                    item.classList.remove("is-active");
                }
            });
        }

        itemData.forEach(({ item, title, description, icon }, index) => {
            title?.addEventListener("click", () => {
                if (isAnimating) return;

                isAnimating = true;
                const isCurrentlyActive = item.classList.contains("is-active");

                if (isCurrentlyActive) {
                    closeAccordionItem(item, description, icon, resetAnimation);
                } else {
                    openAccordionItem(item, description, icon, resetAnimation);
                    if (collapse_others) {
                        itemData.forEach((otherItemData, otherIndex) => {
                            if (otherIndex !== index) {
                                const {
                                    item: otherItem,
                                    description: otherDescription,
                                    icon: otherIcon,
                                } = otherItemData;
                                slideUpAccordion(
                                    otherDescription,
                                    ANIMATION_DURATION,
                                );
                                otherIcon?.classList.add(
                                    "premium-accordion__closed",
                                );
                                otherItem.classList.remove("is-active");
                            }
                        });
                    }
                }
            });
        });
    };

    const initAccordions = () => {
        const accordionSettings = window?.pbg_accordion || {};

        Object.keys(accordionSettings).forEach((blockId) => {
            const accordion = document.querySelector(`.${blockId}`);

            if (accordion) {
                const settings = accordionSettings[blockId];
                initAccordion(accordion, settings);
            }
        });
    };

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initAccordions);
    } else {
        initAccordions();
    }
})();
