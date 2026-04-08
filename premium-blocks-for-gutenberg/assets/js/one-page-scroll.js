(function () {
    window.pbgVerticalScroll = function (blockId, settings) {
        const self = this;
        const isTouch =
            navigator.userAgent.match(
                /(iPhone|iPod|iPad|Android|playbook|silk|BlackBerry|BB10|Windows Phone|Tizen|Bada|webOS|IEMobile|Opera Mini)/,
            ) ||
            (navigator.userAgent.includes("Mac") && "ontouchend" in document);
        const isSafari = /^((?!chrome|android).)*safari/i.test(
            navigator.userAgent,
        );

        const $instance2 = document.querySelector(`.${blockId}`);
        const checkTemps = $instance2.querySelectorAll(
            ".pbg-one-page-scroll__inner",
        ).length;
        const $itemsList = $instance2.querySelectorAll(
            ".pbg-one-page-scroll-dot",
        );
        const $menuItems = $instance2.querySelectorAll(
            ".pbg-one-page-scroll-menu-item",
        );
        const $arrows = $instance2.querySelectorAll(
            ".pbg-one-page-scroll-arrows span",
        );

        const sections = {};
        let inScope = false;
        let isScrolling = false;
        let scrollings = [];
        let oldSectionId = null;
        let canTouchScroll = true;

        self.init = () => {
            self.setSectionsData();

            inScope = self.getVisibleSection() ? true : false;

            oldSectionId = self.getVisibleSection();

            self.scrollHandler();

            self.vscrollEffects();

            if (!isTouch && settings.fullSection) {
                if (settings.fullCheckOverflow) {
                    self.setSectionsOverflow();
                }
            }

            $itemsList.forEach((item) => {
                item.addEventListener("click", self.onNavDotChange);
                item.querySelector(
                    ".pbg-one-page-scroll-dot__inner",
                ).addEventListener("mouseenter", self.onNavDotEnter);
                item.querySelector(
                    ".pbg-one-page-scroll-dot__inner",
                ).addEventListener("mouseleave", self.onNavDotLeave);
            });
            $menuItems.forEach((item) => {
                item.addEventListener("click", self.onNavDotChange);
            });

            $arrows[0]?.addEventListener("click", (event) =>
                self.onScroll(event, "up"),
            );
            $arrows[1]?.addEventListener("click", (event) =>
                self.onScroll(event, "down"),
            );

            if (settings.showTooltipOnScroll) {
                const tooltip = $instance2.querySelector(
                    `.pbg-one-page-scroll-dot.active .pbg-one-page-scroll-dot__tooltip`,
                );

                tooltip?.classList.add("pbg-one-page-scroll-dot__tooltip-show");

                setTimeout(() => {
                    tooltip?.classList.remove(
                        "pbg-one-page-scroll-dot__tooltip-show",
                    );
                }, 1000);
            }

            window.addEventListener("resize", self.debounce(50, self.onResize));
            window.addEventListener(
                "orientationchange",
                self.debounce(50, self.onResize),
            );

            if (!settings.fullSection || isTouch) {
                window.addEventListener("scroll", self.scrollHandler);
            }

            if (settings.fullSection && !isTouch) {
                self.fullSectionHandler();
            }
        };

        // Add Ids and store offset to each Scroll Item
        self.setSectionsData = function () {
            const $sections = $instance2.querySelectorAll(
                ".pbg-one-page-scroll__inner .premium-one-page-scroll-item",
            );

            const availableHeight = window.innerHeight - settings.offset;

            $sections.forEach(function (section, index) {
                const $section = section;

                const sectionId = `${blockId}-${index}`;

                // Add section id
                $section.id = sectionId;
                const sectionOffset = Math.round(
                    section.getBoundingClientRect().top + window.scrollY,
                );

                sections[sectionId] = {
                    offset: sectionOffset,
                };

                if (
                    settings.enableFitToScreen &&
                    settings.fullSection &&
                    !isTouch
                ) {
                    section.style.minHeight = availableHeight + "px";
                }
            });
        };

        // Check if there's content-overflow to add scrollable content.
        self.setSectionsOverflow = function () {
            Object.keys(sections).forEach(function (sectionId) {
                let $section = document.getElementById(sectionId),
                    animeType = $instance2.querySelector(
                        ".pbg-one-page-scroll__inner",
                    ).dataset.animation,
                    height = animeType
                        ? $section.querySelector("div")?.offsetHeight
                        : $section.offsetHeight;

                const availableHeight = window.innerHeight - settings.offset;

                $section.style.setProperty(
                    "--pbg-one-page-scroll-overlay-height",
                    height + "px",
                );

                if (height > availableHeight) {
                    if (!$section.querySelector("#scroller-" + sectionId)) {
                        const wrapperDiv = document.createElement("div");
                        wrapperDiv.id = "scroller-" + sectionId;

                        while ($section.firstChild) {
                            wrapperDiv.appendChild($section.firstChild);
                        }

                        $section.appendChild(wrapperDiv);
                    }

                    let slimHeight = isSafari
                        ? availableHeight + 100 + "px"
                        : availableHeight + "px";

                    let $scroller = $section.querySelector(
                        `#scroller-${sectionId}`,
                    );

                    $scroller.style.height = slimHeight;
                }
            });
        };

        // Handling Full Section Scroll
        self.fullSectionHandler = function () {
            if (checkTemps) {
                document.addEventListener
                    ? window.addEventListener("wheel", self.onScroll, {
                          passive: false,
                      })
                    : document.attachEvent("onmousewheel", self.onScroll);
                self.keyboardHandler();
            }
        };

        // Handling Default Scrolling on Touch Devices
        self.scrollHandler = function () {
            let $firstSection = document.getElementById(
                    self.getFirstSection(sections),
                ),
                $lastSection = document.getElementById(
                    self.getLastSection(sections),
                ),
                firstSectionTopOffset =
                    $firstSection.getBoundingClientRect().top,
                lastSectionBottomOffset =
                    $lastSection.getBoundingClientRect().top +
                    $lastSection.offsetHeight;

            if (self.getFirstSection(sections) === self.getVisibleSection()) {
                $arrows[0]?.classList.add("pbg-one-page-scroll-dots-hide");
            } else {
                $arrows[0]?.classList.remove("pbg-one-page-scroll-dots-hide");
            }

            if (self.getLastSection(sections) === self.getVisibleSection()) {
                $arrows[1]?.classList.add("pbg-one-page-scroll-dots-hide");
            } else {
                $arrows[1]?.classList.remove("pbg-one-page-scroll-dots-hide");
            }

            // Check if the scroll item within the viewport
            if (
                lastSectionBottomOffset >= window.innerHeight &&
                firstSectionTopOffset <= settings.offset
            ) {
                let currentSectionId = self.getVisibleSection();

                if (!currentSectionId) return;

                $instance2
                    .querySelectorAll(
                        ".pbg-one-page-scroll-dots, .pbg-one-page-scroll-menu-list, .pbg-one-page-scroll-arrows",
                    )
                    .forEach((list) => {
                        list.classList.remove("pbg-one-page-scroll-dots-hide");
                    });

                if (!isScrolling) {
                    $itemsList.forEach((item) => {
                        item.classList.remove("active");
                    });
                    $menuItems.forEach((item) => {
                        item.classList.remove("active");
                    });
                    $instance2
                        .querySelectorAll(
                            `[data-menuanchor="${currentSectionId}"]`,
                        )
                        .forEach((item) => {
                            item.classList.add("active");
                        });
                }

                if (currentSectionId !== oldSectionId) {
                    oldSectionId = currentSectionId;

                    $instance2
                        .querySelectorAll(".pbg-one-page-scroll-dot__tooltip")
                        ?.forEach((item) => {
                            item.classList.remove(
                                "pbg-one-page-scroll-dot__tooltip-show",
                            );
                        });

                    const tooltip = $instance2.querySelector(
                        `.pbg-one-page-scroll-dot[data-menuanchor='${currentSectionId}'] .pbg-one-page-scroll-dot__tooltip`,
                    );

                    tooltip?.classList.add(
                        "pbg-one-page-scroll-dot__tooltip-show",
                    );

                    setTimeout(() => {
                        tooltip?.classList.remove(
                            "pbg-one-page-scroll-dot__tooltip-show",
                        );
                    }, 1000);
                }
            } else {
                $instance2
                    .querySelectorAll(
                        ".pbg-one-page-scroll-dots, .pbg-one-page-scroll-menu-list, .pbg-one-page-scroll-arrows",
                    )
                    .forEach((list) => {
                        list.classList.add("pbg-one-page-scroll-dots-hide");
                    });

                oldSectionId = null;
            }
        };

        // Handling Scrolling Using Keyboard
        self.keyboardHandler = function () {
            document.addEventListener("keydown", function (event) {
                if (event.key === "ArrowUp") {
                    self.onScroll(event, "up");
                }

                if (event.key === "ArrowDown") {
                    self.onScroll(event, "down");
                }
            });
        };

        // Check if scrolling is happening within the scrollable content
        self.isScrolled = function (sectionId, direction) {
            let $section = document.getElementById(sectionId);

            let $scroller = $section.querySelector(`#scroller-${sectionId}`);

            if ($scroller) {
                if (direction === "down") {
                    if (self.getFirstSection(sections) === sectionId) {
                        if (
                            Math.floor($section.getBoundingClientRect().top) >
                            settings.offset
                        ) {
                            return $scroller.scrollTop >= 0;
                        } else {
                            return (
                                $scroller.scrollTop +
                                    $scroller.clientHeight +
                                    5 >=
                                $scroller.scrollHeight
                            );
                        }
                    } else {
                        return (
                            $scroller.scrollTop + $scroller.clientHeight + 5 >=
                            $scroller.scrollHeight
                        );
                    }
                } else if ("up" === direction) {
                    if (self.getLastSection(sections) === sectionId) {
                        if (
                            Math.round($section.getBoundingClientRect().top) < 0
                        ) {
                            return $scroller.scrollTop >= 0;
                        } else {
                            return $scroller.scrollTop <= 0;
                        }
                    } else {
                        return $scroller.scrollTop <= 0;
                    }
                }
            } else {
                return true;
            }
        };

        // Check if there's a next scroll item to the current one
        self.checkNextSection = function (object, key) {
            let keys = Object.keys(object),
                idIndex = keys.indexOf(key),
                nextIndex = (idIndex += 1);

            if (nextIndex >= keys.length) {
                return false;
            }

            let nextKey = keys[nextIndex];

            return nextKey;
        };

        // Check if there's a previous scroll item to the current one
        self.checkPrevSection = function (object, key) {
            let keys = Object.keys(object),
                idIndex = keys.indexOf(key),
                prevIndex = (idIndex -= 1);

            if (0 > idIndex) {
                return false;
            }

            let prevKey = keys[prevIndex];

            return prevKey;
        };

        self.debounce = function (threshold, callback) {
            let timeout;

            return function debounced($event) {
                function delayed() {
                    callback.call(this, $event);
                    timeout = null;
                }

                if (timeout) {
                    clearTimeout(timeout);
                }

                timeout = setTimeout(delayed, threshold);
            };
        };

        // Check if there's a visible scroll item within the viewport
        self.getVisibleSection = function () {
            let sectionsAvailable = $instance2.querySelectorAll(
                ".pbg-one-page-scroll__inner .premium-one-page-scroll-item",
            );

            let windowHeight = window.innerHeight;

            let visibleSectionId = null;

            for (const section of sectionsAvailable) {
                let actualBlock = section,
                    offsetTop = Math.ceil(
                        actualBlock.getBoundingClientRect().top,
                    ),
                    offsetBottom = Math.floor(
                        actualBlock.getBoundingClientRect().bottom,
                    );

                if (
                    (offsetTop <= windowHeight &&
                        offsetTop >= settings.offset) ||
                    (offsetBottom > settings.offset + 1 &&
                        offsetBottom <= windowHeight) ||
                    (offsetTop <= settings.offset &&
                        offsetBottom >= windowHeight)
                ) {
                    visibleSectionId = actualBlock.getAttribute("id");
                    break;
                }
            }
            return visibleSectionId;
        };

        // Handling hovering on Nav Dots to show the Tooltip
        self.onNavDotEnter = function () {
            let $this = this.parentElement,
                index = Array.from($itemsList).indexOf($this);

            if (settings.tooltips && settings.dotsText[index]) {
                // make sure only one tool tip is showing.
                document
                    .querySelectorAll(".pbg-one-page-scroll-dot__tooltip")
                    ?.forEach((item) => {
                        item.classList.remove(
                            "pbp-one-page-scroll-dot__tooltip-show",
                        );
                    });

                document
                    .querySelectorAll(".pbg-one-page-scroll-dot__tooltip")
                    [index].classList.add(
                        "pbg-one-page-scroll-dot__tooltip-show",
                    );
            }
        };

        // Handling leaving Nav Dots to hide the Tooltip
        self.onNavDotLeave = function () {
            document
                .querySelectorAll(".pbg-one-page-scroll-dot__tooltip")
                ?.forEach((item) => {
                    item.classList.remove(
                        "pbg-one-page-scroll-dot__tooltip-show",
                    );
                });
        };

        // Handling clicking on Nav dots or Nav Items to scroll to the specific item.
        self.onNavDotChange = function (event) {
            let $this = this,
                index = [...$this.parentElement.children].indexOf($this),
                sectionId = $this.dataset.menuanchor,
                offset = null;

            if ($this.classList.contains("active")) {
                return false;
            }

            if (!sections.hasOwnProperty(sectionId)) {
                return false;
            }

            offset = sections[sectionId].offset - settings.offset;

            if (offset < 0) offset = sections[sectionId].offset;

            if (sections[self.getVisibleSection()]?.offset === offset) {
                return false;
            }

            if (!isScrolling) {
                isScrolling = true;

                $menuItems.forEach((item) => {
                    item.classList.remove("active");
                });
                $itemsList.forEach((item) => {
                    item.classList.remove("active");
                });

                if ($this.classList.contains("pbg-one-page-scroll-menu-item")) {
                    $itemsList[index]?.classList.add("active");
                } else {
                    $menuItems[index]?.classList.add("active");
                }

                $this.classList.add("active");

                if (sectionId === self.getFirstSection(sections)) {
                    $arrows[0]?.classList.add("pbg-one-page-scroll-dots-hide");
                } else {
                    $arrows[0]?.classList.remove(
                        "pbg-one-page-scroll-dots-hide",
                    );
                }

                if (sectionId === self.getLastSection(sections)) {
                    $arrows[1]?.classList.add("pbg-one-page-scroll-dots-hide");
                } else {
                    $arrows[1]?.classList.remove(
                        "pbg-one-page-scroll-dots-hide",
                    );
                }

                smoothScroll({
                    yPos: offset,
                    duration: settings.speed,
                    easing: "swing",
                    complete: function () {
                        isScrolling = false;
                    },
                });
            }
        };

        self.preventDefault = function (event) {
            if (event.preventDefault) {
                event.preventDefault();
            } else {
                event.returnValue = false;
            }
        };

        // Handling changing the active Nav dot or Nav item and scroll to the new item.
        self.onAnchorChange = function (sectionId) {
            let $this = $instance2.querySelectorAll(
                    `[data-menuanchor="${sectionId}"]`,
                ),
                offset = null;

            if (!sections.hasOwnProperty(sectionId)) {
                return false;
            }

            offset = sections[sectionId].offset - settings.offset;

            if (offset < 0) offset = sections[sectionId].offset;

            if (!isScrolling) {
                isScrolling = true;
                canTouchScroll = false;

                if (settings.addToHistory) {
                    window.history.pushState(null, null, "#" + sectionId);
                }

                $itemsList.forEach((item) => {
                    item.classList.remove("active");
                });
                $menuItems.forEach((item) => {
                    item.classList.remove("active");
                });

                $this.forEach((item) => {
                    item.classList.add("active");
                });

                if (settings.showTooltipOnScroll) {
                    $instance2
                        .querySelectorAll(".pbg-one-page-scroll-dot__tooltip")
                        ?.forEach((item) => {
                            item.classList.remove(
                                "pbg-one-page-scroll-dot__tooltip-show",
                            );
                        });
                    const tooltip = $instance2.querySelector(
                        `.pbg-one-page-scroll-dot.active .pbg-one-page-scroll-dot__tooltip`,
                    );
                    tooltip?.classList.add(
                        "pbg-one-page-scroll-dot__tooltip-show",
                    );
                    setTimeout(() => {
                        tooltip?.classList.remove(
                            "pbg-one-page-scroll-dot__tooltip-show",
                        );
                    }, 1000);
                }

                smoothScroll({
                    yPos: offset,
                    duration: settings.speed,
                    easing: "swing",
                    complete: function () {
                        isScrolling = false;
                    },
                });
            }
        };

        self.getFirstSection = function (object) {
            return Object.keys(object)[0];
        };

        self.getLastSection = function (object) {
            return Object.keys(object)[Object.keys(object).length - 1];
        };

        function getScrollData(e) {
            e = e || window.event;

            let t = e.wheelDelta ?? -e.deltaY ?? -e.detail;

            return t;
        }

        let prevTime = new Date().getTime();

        self.onScroll = function (event, scrollDir) {
            let curTime = new Date().getTime();
            let timeDiff = curTime - prevTime;
            prevTime = curTime;

            if (timeDiff >= settings.speed) {
                canTouchScroll = true;
            }

            if (inScope && !isTouch) {
                self.preventDefault(event);
            }
            if (
                isScrolling ||
                (Math.abs(getScrollData(event)) < 50 && !canTouchScroll)
            ) {
                self.preventDefault(event);
                return false;
            }

            let sectionId = self.getVisibleSection(),
                $section = document.getElementById(sectionId),
                newSectionId = false,
                prevSectionId = false,
                nextSectionId = false,
                windowScrollTop = Math.ceil(window.scrollY),
                scrollData,
                delta,
                direction;

            if (!scrollDir) {
                scrollData = getScrollData(event);
                if (scrollData > 0) {
                    scrollData += 100;
                } else if (scrollData < 0) {
                    scrollData -= 100;
                }

                delta = Math.max(-1, Math.min(1, scrollData));

                if (delta === 0) {
                    return;
                } else {
                    direction = 0 > delta ? "down" : "up";
                }
            } else {
                direction = scrollDir;
                scrollData = direction === "down" ? 100 : -100;
            }

            if (scrollings.length > 149) {
                scrollings.shift();
            }

            //keeping record of the previous scrollings
            scrollings.push(Math.abs(scrollData));

            if (timeDiff >= 300) {
                scrollings = [];
            }

            if (sectionId && sections.hasOwnProperty(sectionId)) {
                prevSectionId = self.checkPrevSection(sections, sectionId);
                nextSectionId = self.checkNextSection(sections, sectionId);

                if ("up" === direction) {
                    if (
                        !nextSectionId &&
                        sections[sectionId].offset < windowScrollTop
                    ) {
                        newSectionId = sectionId;
                    } else {
                        newSectionId = prevSectionId;
                    }
                } else {
                    if (
                        !prevSectionId &&
                        sections[sectionId].offset - settings.offset >
                            windowScrollTop
                    ) {
                        newSectionId = sectionId;
                    } else {
                        newSectionId = nextSectionId;
                    }
                }

                let averageEnd = self.getAverage(scrollings, 10);
                let averageMiddle = self.getAverage(scrollings, 70);
                let isAccelerating = averageEnd >= averageMiddle;

                if (newSectionId) {
                    inScope = true;

                    if (!self.isScrolled(sectionId, direction) && !isTouch) {
                        let $scroller = $section.querySelector(
                            `#scroller-${sectionId}`,
                        );

                        if (direction === "down") {
                            let scrollAmount = event.deltaY ?? 100;
                            $scroller.scrollBy(0, scrollAmount);
                        } else if (direction === "up") {
                            let scrollAmount = -(event.deltaY ?? -100);
                            $scroller.scrollBy(0, -scrollAmount);
                        }
                        return;
                    }

                    if (newSectionId === self.getFirstSection(sections)) {
                        $arrows[0]?.classList.add(
                            "pbg-one-page-scroll-dots-hide",
                        );
                    } else {
                        $arrows[0]?.classList.remove(
                            "pbg-one-page-scroll-dots-hide",
                        );
                    }

                    if (newSectionId === self.getLastSection(sections)) {
                        $arrows[1]?.classList.add(
                            "pbg-one-page-scroll-dots-hide",
                        );
                    } else {
                        $arrows[1]?.classList.remove(
                            "pbg-one-page-scroll-dots-hide",
                        );
                    }

                    $instance2
                        .querySelectorAll(
                            ".pbg-one-page-scroll-dots, .pbg-one-page-scroll-menu-list, .pbg-one-page-scroll-arrows",
                        )
                        .forEach((list) => {
                            list.classList.remove(
                                "pbg-one-page-scroll-dots-hide",
                            );
                        });

                    if (isAccelerating && !isScrolling) {
                        self.onAnchorChange(newSectionId);
                    }
                } else {
                    let $lastselector = document.getElementById(sectionId);

                    $lastselector = $instance2.contains($lastselector)
                        ? $lastselector
                        : null;

                    if ($lastselector) {
                        const $scroller = $lastselector.querySelector(
                            `#scroller-${sectionId}`,
                        );

                        if ("down" === direction) {
                            //check if still there's overflow-content, don't hide the nav dots and menu items
                            if (
                                $scroller &&
                                $scroller.scrollTop +
                                    $scroller.clientHeight +
                                    5 <
                                    $scroller.scrollHeight &&
                                Math.round(
                                    $lastselector.getBoundingClientRect().top,
                                ) >= settings.offset &&
                                Math.round(
                                    $lastselector.getBoundingClientRect().top,
                                ) <=
                                    settings.offset + 1
                            ) {
                                let scrollAmount = event.deltaY ?? 100;
                                $scroller.scrollBy(0, scrollAmount);
                                return;
                            }
                            if (
                                Math.floor(
                                    $lastselector.getBoundingClientRect().top,
                                ) <=
                                settings.offset + 1
                            ) {
                                inScope = false;
                            }
                        } else if ("up" === direction) {
                            //check if still there's overflow-content, don't hide the nav dots and menu items
                            if (
                                $scroller &&
                                $scroller.scrollTop !== 0 &&
                                Math.round(
                                    $lastselector.getBoundingClientRect().top,
                                ) >= settings.offset &&
                                Math.round(
                                    $lastselector.getBoundingClientRect().top,
                                ) <=
                                    settings.offset + 1
                            ) {
                                let scrollAmount = -(event.deltaY ?? -100);
                                $scroller.scrollBy(0, -scrollAmount);
                                return;
                            }

                            if (
                                Math.round(
                                    $lastselector.getBoundingClientRect().top,
                                ) >= settings.offset
                            ) {
                                inScope = false;
                            }
                        }
                    } else {
                        inScope = false;
                    }

                    const documentHeight = document.body.scrollHeight;
                    const windowHeight = window.innerHeight;
                    const scrollPosition = window.scrollY;

                    // Check if there is no more scroll to not hide the navigations.
                    if (
                        scrollPosition + windowHeight >= documentHeight ||
                        scrollPosition === 0
                    ) {
                        return;
                    }

                    $instance2
                        .querySelectorAll(
                            ".pbg-one-page-scroll-dots, .pbg-one-page-scroll-menu-list, .pbg-one-page-scroll-arrows",
                        )
                        .forEach((list) => {
                            list.classList.add("pbg-one-page-scroll-dots-hide");
                        });
                }
            } else {
                inScope = false;

                $instance2
                    .querySelectorAll(
                        ".pbg-one-page-scroll-dots, .pbg-one-page-scroll-menu-list, .pbg-one-page-scroll-arrows",
                    )
                    .forEach((list) => {
                        list.classList.add("pbg-one-page-scroll-dots-hide");
                    });
            }
        };

        self.onResize = function () {
            self.setSectionsData();
        };

        self.getAverage = function (elements, number) {
            let sum = 0;

            let lastElements = elements.slice(
                Math.max(elements.length - number, 1),
            );

            for (let i = 0; i < lastElements.length; i++) {
                sum = sum + lastElements[i];
            }

            return Math.ceil(sum / number);
        };

        // Handling Scroll Effects (Parallax - Zoomed Parallax - Cube)
        self.vscrollEffects = function () {
            let animationType = $instance2.querySelector(
                ".pbg-one-page-scroll__inner",
            ).dataset.animation;

            // Check if we are on Touch devices, The animation will be changed to default.
            if (isTouch && animationType) {
                $instance2.querySelector(
                    ".pbg-one-page-scroll__inner",
                ).dataset.animation = "default";

                $instance2.classList.replace(
                    `pbg-one-page-scroll-effect-${animationType}`,
                    "pbg-one-page-scroll-effect-default",
                );
                return;
            }

            if (animationType) {
                let sectionsAvailable = $instance2.querySelectorAll(
                    ".pbg-one-page-scroll__inner .premium-one-page-scroll-item",
                );

                for (const section of sectionsAvailable) {
                    let actualBlock = section;
                    if (!actualBlock.querySelector(".animation-wrapper")) {
                        const animationWrapper = document.createElement("div");

                        animationWrapper.classList.add("animation-wrapper");
                        animationWrapper.style.boxSizing = "border-box";

                        while (actualBlock.firstChild) {
                            animationWrapper.appendChild(
                                actualBlock.firstChild,
                            );
                        }

                        actualBlock.appendChild(animationWrapper);
                    }
                }

                //bind the animation to the window scroll event, arrows click and keyboard.
                scrollAnimation();

                window.addEventListener("scroll", () => {
                    scrollAnimation();
                });

                function scrollAnimation() {
                    //normal scroll - use requestAnimationFrame (if defined) to optimize performance.
                    !window.requestAnimationFrame
                        ? animateSection()
                        : window.requestAnimationFrame(animateSection);
                }

                function animateSection() {
                    windowHeight = window.innerHeight;

                    for (const section of sectionsAvailable) {
                        let actualBlock = section,
                            offset = Math.round(
                                actualBlock.getBoundingClientRect().top,
                            );
                        // according to animation type and window scroll, define animation parameters.
                        let animationValues = setSectionAnimation(
                            actualBlock.id,
                            offset,
                            windowHeight,
                            animationType,
                        );

                        transformSection(
                            actualBlock.querySelector("div"),
                            animationValues[0],
                            animationValues[1],
                            animationValues[2],
                            animationValues[3],
                            animationValues[4],
                        );
                    }
                }

                function transformSection(
                    element,
                    translateY,
                    rotateXValue,
                    opacityValue,
                    scaleValue,
                    pointerEvents,
                ) {
                    element.style.transform =
                        (animationType === "flipcover"
                            ? "perspective(1000px)"
                            : "") +
                        "translateY(" +
                        translateY +
                        "vh) rotateX(" +
                        rotateXValue +
                        ") scale(" +
                        scaleValue +
                        ")";
                    element.style.opacity = opacityValue;
                    element.style.pointerEvents = pointerEvents;
                }

                function setSectionAnimation(
                    sectionId,
                    sectionOffset,
                    windowHeight,
                    animationName,
                ) {
                    // select section animation - normal scroll
                    let translateY = 100,
                        rotateX = "0deg",
                        opacity = 1,
                        scale = 1,
                        pointerEvents = "auto";

                    if (sectionOffset < windowHeight && sectionOffset >= 0) {
                        // section entering the viewport.
                        translateY = (sectionOffset * 100) / windowHeight;
                        if ("flipcover" === animationName) {
                            if (self.getFirstSection(sections) !== sectionId) {
                                translateY = 0;
                                rotateX =
                                    (-sectionOffset * 100) / windowHeight +
                                    "deg";
                            } else {
                                rotateX = "0deg";
                            }
                        }
                    } else if (
                        sectionOffset > -windowHeight * 1.05 &&
                        sectionOffset < windowHeight
                    ) {
                        //section leaving the viewport - still has the '.visible' class.
                        if ("parallax" === animationName) {
                            if (self.getLastSection(sections) !== sectionId) {
                                translateY =
                                    (sectionOffset * 50) / windowHeight;
                            } else {
                                translateY =
                                    (sectionOffset * 100) / windowHeight;
                            }
                        } else if ("flipcover" === animationName) {
                            if (self.getLastSection(sections) !== sectionId) {
                                translateY = 0;
                            } else {
                                translateY =
                                    (sectionOffset * 100) / windowHeight;
                            }
                        }
                    } else if (sectionOffset >= windowHeight) {
                        //section not yet visible.
                        translateY = 100;
                        if ("flipcover" === animationName) {
                            rotateX = "-90deg";
                        }
                    } else if (sectionOffset < -windowHeight * 1.05) {
                        //section not visible anymore.
                        translateY = -100;
                    }

                    return [translateY, rotateX, opacity, scale, pointerEvents];
                }
            }
        };
    };
})();

window.addEventListener("DOMContentLoaded", function () {
    const wpAdminBar = document.getElementById("wpadminbar")?.offsetHeight ?? 0;

    const { blocks } = PBG_OnePageScroll ?? {};

    if (!blocks) return;

    Object.keys(blocks).map((blockId) => {
        const { attributes } = blocks[blockId];

        const settings = {
            id: blockId,
            speed: attributes.scrollSpeed ? attributes.scrollSpeed * 1000 : 700,
            offset:
                attributes.scrollOffset && attributes.scrollEffect === "default"
                    ? attributes.scrollOffset + wpAdminBar
                    : attributes.scrollEffect === "default"
                    ? wpAdminBar
                    : 0,
            tooltips: attributes?.enableDotsTooltip && attributes?.navDots,
            dotsText: attributes?.navDots,
            showTooltipOnScroll: attributes?.showTooltipOnScroll,
            fullSection:
                "default" !== attributes.scrollEffect ||
                attributes.fullSectionScroll
                    ? true
                    : false,
            fullCheckOverflow:
                "default" !== attributes.scrollEffect ||
                attributes.fullSectionScroll
                    ? true
                    : false,
            addToHistory: attributes.saveToBrowser,
            enableFitToScreen: attributes.enableFitToScreen,
        };

        const pbgVerticalScroll = new window.pbgVerticalScroll(
            blockId,
            settings,
        );

        pbgVerticalScroll.init();

        setTimeout(() => {
            pbgVerticalScroll.setSectionsData();
        }, 200);
    });
});
