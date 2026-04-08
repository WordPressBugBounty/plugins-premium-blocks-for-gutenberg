(function () {
    const postsConfigs = {};

    const SELECTORS = {
        POST_BLOCK: (blockId) => `.${blockId}`,
        POST_INNER_CONTAINER: ".premium-blog-wrap",
        FILTER_ITEMS: ".premium-post-grid-taxonomy-filter-list-item",
        POST_PAGINATION: ".premium-blog-pagination-container",
        CURRENT_PAGE: ".page-numbers.current",
    };

    function showPostsLoading(container) {
        if (!container) return null;

        const existingLoader = container.querySelector(".pbg-spinner-wrapper");
        if (existingLoader) existingLoader.remove();

        const loader = document.createElement("div");

        loader.className = "pbg-spinner-wrapper";
        loader.innerHTML = '<div class="pbg-spinner"></div>';

        container.appendChild(loader);
        return loader;
    }

    function getFilterFromURL(urlFilterFlag) {
        if (!urlFilterFlag) return "*";

        const urlParams = new URLSearchParams(window.location.search);
        const filterParam = urlParams.get(urlFilterFlag);

        return filterParam || "*";
    }

    function updateUrlParam(param, value) {
        if (!param) return;

        const url = new URL(window.location);

        if (value && value !== "*") {
            url.searchParams.set(param, value);
        } else {
            url.searchParams.delete(param);
        }

        // Update the browser's URL and history state to reflect the current filter selection.
        // This enables browser navigation (back/forward) to restore the filter state.
        window.history.pushState({ [param]: value }, "", url);
    }

    function updateActiveFilter(filterItems, newFilterTerm) {
        if (!filterItems.length) return;

        filterItems.forEach((tab) => {
            tab.classList.remove("active");
        });

        const activeTab = filterItems.find(
            (tab) => tab.dataset.filter === newFilterTerm,
        );

        if (activeTab) {
            activeTab.classList.add("active");
        }
    }

    /**
     * initialize and cache post settings for a block instance
     */
    function initPostConfigs() {
        const { blocks } = pbgPostGridAjax ?? {};

        if (!blocks) return;

        Object.keys(blocks).forEach((blockId) => {
            const postBlock = document.querySelector(
                SELECTORS.POST_BLOCK(blockId),
            );

            if (!postBlock) {
                console.warn(`No Post Configs found for block ID: ${blockId}`);
                return;
            }

            const selectors = {
                postBlock,
                filterItems: Array.from(
                    postBlock.querySelectorAll(SELECTORS.FILTER_ITEMS),
                ),
                postInnerContainer: postBlock.querySelector(
                    SELECTORS.POST_INNER_CONTAINER,
                ),
                postPagination: postBlock.querySelector(
                    SELECTORS.POST_PAGINATION,
                ),
            };

            const {
                urlFilterFlag,
                scrollToTop,
                activeFilterTab,
                enableFirstFilter,
            } = blocks[blockId]?.attributes ?? {};

            const { filterItems, postPagination } = selectors;

            let initialFilter = "*";

            if (activeFilterTab && filterItems.length && !enableFirstFilter) {
                initialFilter = activeFilterTab;
            }

            if (urlFilterFlag && filterItems.length) {
                const urlFilter = getFilterFromURL(urlFilterFlag);
                if (urlFilter && urlFilter !== "*") {
                    initialFilter = urlFilter;
                }
            }

            postsConfigs[blockId] = {
                selectors,
                ...(filterItems.length || postPagination
                    ? {
                          scrollToTop,
                      }
                    : {}),
                ...(urlFilterFlag && filterItems.length
                    ? { urlFilterFlag }
                    : {}),
                ...(filterItems.length ? { activeFilter: initialFilter } : {}),
            };
        });
    }

    /**
     * Get Posts by AJAX
     */
    function fetchPosts(
        action,
        nonce,
        blockId,
        params = {},
        preventScroll = false,
    ) {
        const { ajaxurl, blocks } = pbgPostGridAjax ?? {};
        const { selectors, scrollToTop } = postsConfigs[blockId];

        if (!ajaxurl || !nonce || !blocks[blockId] || !selectors) return;

        showPostsLoading(selectors.postInnerContainer);

        const formData = new FormData();
        formData.append("action", action);
        formData.append("nonce", nonce);
        formData.append(
            "attributes",
            JSON.stringify(blocks[blockId].attributes),
        );

        // Add additional parameters
        Object.entries(params).forEach(([key, value]) => {
            formData.append(key, value);
        });

        fetch(ajaxurl, {
            method: "POST",
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    // Server returned an error status code (like 400 or 500)
                    throw new Error(
                        `Server error: ${response.status} ${response.statusText}`,
                    );
                }
                // Attempt to parse JSON; if it fails, catch in next .catch()
                return response.json();
            })
            .then((data) => {
                if (data?.success) {
                    const {
                        posts_html: newPosts,
                        pagination_html: newPagination,
                    } = data.data ?? {};

                    requestAnimationFrame(() => {
                        selectors.postInnerContainer.innerHTML = newPosts;
                        if (selectors.postPagination) {
                            selectors.postPagination.innerHTML = newPagination;
                        }

                        // Scroll to top of posts container after loading new posts
                        if (scrollToTop && !preventScroll) {
                            setTimeout(() => {
                                selectors.postBlock?.scrollIntoView({
                                    behavior: "smooth",
                                    block: "start",
                                    inline: "nearest",
                                });
                            }, 100);
                        }
                    });
                } else {
                    // Server responded, but indicated failure in the JSON
                    console.error(
                        "Unable to load posts. Please check your connection and try again:",
                        data,
                    );
                }
            })
            .catch((error) => {
                // Network, server, or JSON parsing errors come here
                console.error(
                    "An error occurred while fetching posts:",
                    error.message ? error.message : error,
                );
            });
    }

    /**
     * Make AJAX request to filter posts
     * @param {string} filterTerm - The filter term to apply
     * @param {string} blockId - The ID of the block
     * @param {number} [page=1] - The page number to fetch
     */
    function fetchFilteredPosts(
        filterTerm,
        blockId,
        page = 1,
        preventScroll = false,
    ) {
        const { filter_nonce } = pbgPostGridAjax?.blocks[blockId] ?? {};

        if (!filter_nonce) return;

        fetchPosts(
            "pbg_filter_posts",
            filter_nonce,
            blockId,
            {
                filter_term: filterTerm,
                page: page,
            },
            preventScroll,
        );
    }

    /**
     * Make AJAX request for paginated posts
     * @param {number} pageNumber - The page number to fetch
     * @param {string} blockId - The ID of the block
     */
    function fetchPaginatedPosts(pageNumber, blockId, preventScroll) {
        const { pagination_nonce } = pbgPostGridAjax?.blocks[blockId] ?? {};

        if (!pagination_nonce) return;

        fetchPosts(
            "pbg_paginate_posts",
            pagination_nonce,
            blockId,
            {
                page: pageNumber,
            },
            preventScroll,
        );
    }

    /**
     * Handle pagination click logic
     * @param {Event} e - The click event
     * @param {string} blockId - The ID of the block
     */
    function handlePaginationClick(e, blockId) {
        if (!e.target.classList.contains("page-numbers")) return;

        e.preventDefault();

        const config = postsConfigs[blockId];
        if (!config) {
            console.error(
                `Pagination Configuration not found for block ID : ${blockId}`,
            );
            return;
        }

        const {
            selectors: { postPagination, filterItems },
            activeFilter,
        } = config;

        const clickedPage = e.target;
        const currentPage = postPagination.querySelector(
            SELECTORS.CURRENT_PAGE,
        );

        if (clickedPage === currentPage) return; // Do nothing if current page is clicked

        const currentPageNumber = currentPage
            ? parseInt(currentPage.innerHTML)
            : 1;
        let newPageNumber;

        // Handle special cases for navigation links by checking classes
        if (clickedPage.classList.contains("next")) {
            newPageNumber = currentPageNumber + 1;
        } else if (clickedPage.classList.contains("prev")) {
            newPageNumber = currentPageNumber - 1;
        } else {
            newPageNumber = parseInt(clickedPage.innerHTML.trim());
        }

        if (isNaN(newPageNumber) || newPageNumber < 1) {
            console.warn(
                `Invalid page number (${newPageNumber}) for block ID: ${blockId}`,
            );
            return;
        }

        // Fetch posts via AJAX - check if there's an active filter
        if (filterItems.length && activeFilter && activeFilter !== "*") {
            fetchFilteredPosts(activeFilter, blockId, newPageNumber);
        } else {
            fetchPaginatedPosts(newPageNumber, blockId);
        }
    }

    /**
     * Handle filter click logic
     * @param {Event} e - The click event
     * @param {string} blockId - The ID of the block
     */
    function handleFilterClick(e, blockId) {
        e.preventDefault();

        const filterItem = e.target;
        const newFilterTerm = filterItem.dataset.filter;

        if (!newFilterTerm) {
            console.error("Filter term not found on the clicked element.");
            return;
        }

        const config = postsConfigs[blockId];
        if (!config) {
            console.error(
                `Filtering Configuration not found for block ID: ${blockId}`,
            );
            return;
        }

        const {
            selectors: { filterItems },
            activeFilter,
            urlFilterFlag,
        } = config;

        if (activeFilter === newFilterTerm) {
            return;
        }

        if (urlFilterFlag) {
            updateUrlParam(urlFilterFlag, newFilterTerm);
        }

        postsConfigs[blockId].activeFilter = newFilterTerm;

        updateActiveFilter(filterItems, newFilterTerm);
        fetchFilteredPosts(newFilterTerm, blockId, 1);
    }

    /**
     * Initialize Post Grid Filter and Pagination
     */
    function initPostAjax() {
        initPostConfigs();

        if (Object.keys(postsConfigs).length === 0) return;

        Object.keys(postsConfigs).forEach((blockId) => {
            const {
                selectors: { filterItems, postPagination },
            } = postsConfigs[blockId];

            // Initialize filters if they exist
            if (filterItems.length) {
                filterItems.forEach((item) => {
                    item.addEventListener("click", (e) =>
                        handleFilterClick(e, blockId),
                    );
                });
            }

            // Initialize pagination if it exists
            if (postPagination) {
                postPagination.addEventListener("click", (e) =>
                    handlePaginationClick(e, blockId),
                );
            }
        });

        // Handle browser back/forward navigation to restore filter state.
        // This ensures that when the user navigates using the browser history,
        // the post grid updates to reflect the filter selection stored in the URL or history state.
        window.addEventListener("popstate", (event) => {
            const state = event.state;

            Object.keys(postsConfigs).forEach((blockId) => {
                const { urlFilterFlag, selectors } = postsConfigs[blockId];

                if (!urlFilterFlag || !selectors.filterItems.length) return;

                // Get filter value from state or URL
                let filterTerm = "*";
                if (state && state[urlFilterFlag]) {
                    filterTerm = state[urlFilterFlag];
                } else {
                    // Fallback to reading from current URL
                    filterTerm = getFilterFromURL(urlFilterFlag);
                }

                postsConfigs[blockId].activeFilter = filterTerm;
                updateActiveFilter(selectors.filterItems, filterTerm);
                fetchFilteredPosts(filterTerm, blockId, 1, true);
            });
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", function () {
            initPostAjax();
        });
    } else {
        initPostAjax();
    }
})();
