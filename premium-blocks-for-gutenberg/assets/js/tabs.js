function initTabs() {
    const tabBlocks = document.querySelectorAll(".premium-blocks-tabs");

    tabBlocks.forEach((tabBlock) => {
        const { autochange, delaytime, active, duration } = tabBlock.dataset;

        const autoChange = autochange === "true";
        const delay = +delaytime;
        const activeIndex = +active;
        const durationTime = duration == "fast" ? 300 : 600;

        const tabList = tabBlock.querySelector(".premium-tabs-nav-list");

        const tabItemList = tabBlock.querySelectorAll(
            ".premium-tabs-nav-list .premium-tabs-nav-list-item"
        );

        const accordionItemList = tabList.querySelectorAll(
            ".premium-accordion-tab-content"
        );

        const contentWrap = tabBlock.querySelector(".premium-content-wrap");

        const tabContentList = tabBlock.querySelectorAll(
            ".premium-content-wrap .premium-tabs-content-section"
        );

        const validActiveIndex = Math.max(
            0,
            Math.min(activeIndex, tabItemList.length - 1)
        );

        const isAccordionActive =
            (getCurrentDevice() === "Tablet" &&
                tabBlock.classList.contains("premium-accordion-tabs-tablet")) ||
            (getCurrentDevice() === "Mobile" &&
                tabBlock.classList.contains("premium-accordion-tabs-mobile"));

        // Initialize active states
        setActiveTab(tabItemList, validActiveIndex);
        setActiveTab(tabContentList, validActiveIndex);

        // Setup auto navigation if enabled
        if (
            autoChange &&
            !isAccordionActive &&
            tabItemList.length > 1 &&
            delay > 0
        ) {
            runAutoNavigation(
                tabItemList,
                tabContentList,
                delay,
                validActiveIndex
            );
        }

        if (isAccordionActive) {
            contentWrap.remove();
            changeToAccordion(
                tabList,
                tabItemList,
                tabContentList,
                accordionItemList,
                validActiveIndex,
                durationTime
            );
        } else {
            accordionItemList.forEach((accordionItem) => {
                accordionItem.remove();
            });
            tabItemList.forEach((tabItem, tabIndex) => {
                tabItem.addEventListener("click", (e) => {
                    e.preventDefault();
                    setActiveTab(tabItemList, tabIndex);
                    setActiveTab(tabContentList, tabIndex);
                });
            });
        }
    });
}

function changeToAccordion(
    tabList,
    tabItemList,
    tabContentList,
    accordionItemList,
    startIndex,
    durationTime
) {
    if (!tabList || !tabItemList?.length || !tabContentList?.length) return;

    let isAnimating = false;

    accordionItemList.forEach((accordionItem, index) => {
        const clonedContent = tabContentList[index].cloneNode(true);

        // Remove initialized class from cloned counters so they can be re-initialized
        const initializedCounters = clonedContent.querySelectorAll(".premium-countup-init");
        initializedCounters.forEach((counter) => {
            counter.classList.remove("premium-countup-init");
        });

        accordionItem.appendChild(clonedContent);

        clonedContent.classList.remove("active", "inactive");

        if (index !== startIndex) {
            accordionItem.classList.add("inactive");
        } else {
            accordionItem.classList.add("active");
            openAccordion(accordionItem, durationTime);
        }
    });

    if (window.premiumCountUpInit) {
        window.premiumCountUpInit();
    }

    tabItemList.forEach((tabItem, _) => {
        tabItem.addEventListener("click", function (e) {
            e.preventDefault();

            if (isAnimating) {
                return;
            }

            const tabLink = tabItem.querySelector(".premium-tab-link");
            if (!tabLink) return;

            const target = tabLink.getAttribute("href");
            if (!target) return;

            const accordionItems = tabList.querySelectorAll(
                `.premium-accordion-tab-content:not(${target})`
            );

            const targetAccordionItem = tabList.querySelector(target);
            if (!targetAccordionItem) return;

            const isCurrentlyActive =
                targetAccordionItem.classList.contains("active");

            isAnimating = true;

            // Close other accordion items with slide up animation
            accordionItems.forEach((accordionItem) => {
                if (accordionItem.classList.contains("active")) {
                    closeAccordion(
                        accordionItem,
                        () => {
                            accordionItem.classList.remove("active");
                            accordionItem.classList.add("inactive");
                        },
                        durationTime
                    );
                }
            });

            // Deactivate other tab items
            tabItemList.forEach((tab) => {
                if (tab !== tabItem) {
                    tab.classList.remove("active");
                    tab.classList.add("inactive");
                }
            });

            // Toggle target item with animation
            if (isCurrentlyActive) {
                tabItem.classList.remove("active");
                tabItem.classList.add("inactive");
                closeAccordion(
                    targetAccordionItem,
                    () => {
                        targetAccordionItem.classList.remove("active");
                        targetAccordionItem.classList.add("inactive");
                        isAnimating = false;
                    },
                    durationTime
                );
            } else {
                tabItem.classList.remove("inactive");
                tabItem.classList.add("active");
                targetAccordionItem.classList.remove("inactive");
                targetAccordionItem.classList.add("active");
                openAccordion(targetAccordionItem, durationTime);

                setTimeout(() => {
                    isAnimating = false;
                }, durationTime);
            }
        });
    });
}

function runAutoNavigation(navItems, contentItems, time, activeIndex) {
    if (!navItems?.length || !contentItems?.length) return;

    let intervalId;

    const stopAutoNavigation = () => {
        if (intervalId) {
            clearInterval(intervalId);
            intervalId = null;
        }
    };

    navItems.forEach((item) => {
        item.addEventListener("click", stopAutoNavigation, { once: true });
    });

    intervalId = setInterval(() => {
        activeIndex = (activeIndex + 1) % navItems.length;
        setActiveTab(navItems, activeIndex);
        setActiveTab(contentItems, activeIndex);
    }, time * 1000);
}

function setActiveTab(elements, currentIndex) {
    if (!elements?.length) return;

    elements.forEach((el) => {
        el.classList.remove("active");
        el.classList.add("inactive");
    });

    const targetElement = elements[currentIndex];
    if (targetElement) {
        targetElement.classList.remove("inactive");
        targetElement.classList.add("active");
    }
}

function getCurrentDevice() {
    const { breakPoints } = PBG_TABS;

    if (window.matchMedia(breakPoints.desktop).matches) {
        return "Desktop";
    } else if (
        window.matchMedia(breakPoints.tablet).matches &&
        !window.matchMedia(breakPoints.mobile).matches
    ) {
        return "Tablet";
    } else if (window.matchMedia(breakPoints.mobile).matches) {
        return "Mobile";
    }
    return "Desktop";
}

function openAccordion(element, duration = 300) {
    const content = element?.querySelector(".premium-tabs-content-section");
    if (!content) return;

    const targetHeight = content.offsetHeight + "px";

    content.style.overflow = "hidden";
    content.style.height = "0px";
    content.style.transition = `height ${duration}ms ease-in-out`;

    requestAnimationFrame(() => {
        content.style.height = targetHeight;

        setTimeout(() => {
            content.style.height = "";
            content.style.overflow = "";
            content.style.transition = "";
        }, duration);
    });
}

function closeAccordion(element, callback, duration = 300) {
    const content = element?.querySelector(".premium-tabs-content-section");
    if (!content) return;

    content.style.overflow = "hidden";
    content.style.height = content.offsetHeight + "px";
    content.style.transition = `height ${duration}ms ease-in-out`;

    requestAnimationFrame(() => {
        content.style.height = "0px";

        setTimeout(() => {
            content.style.height = "";
            content.style.overflow = "";
            content.style.transition = "";
            if (callback && typeof callback === "function") {
                callback();
            }
        }, duration);
    });
}

document.addEventListener("DOMContentLoaded", () => {
    initTabs();
});
