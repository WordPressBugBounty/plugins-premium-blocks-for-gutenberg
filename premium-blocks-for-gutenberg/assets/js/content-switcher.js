const contentSwitchers = document.querySelectorAll(".premium-content-switcher");

contentSwitchers.forEach((contentSwitcher) => {
    const content = contentSwitcher.querySelector(
        ".premium-content-switcher-two-content"
    );
    content.children[1].style.display = "none";
    content.children[0].style.display = "block";
    content.style.display = "block";

    const toggleBox = contentSwitcher.querySelector(
        ".premium-content-switcher-toggle-switch-label input"
    );

    if (toggleBox) {
        const firstLabel = contentSwitcher.querySelector(".premium-content-switcher-first-label");
        const secondLabel = contentSwitcher.querySelector(".premium-content-switcher-second-label");

        toggleBox.addEventListener("change", (event) => {
            if (event.target.checked) {
                content.children[1].style.display = "block";
                content.children[0].style.display = "none";
                if (firstLabel) firstLabel.classList.remove("premium-content-switcher-first-label-active");
                if (secondLabel) secondLabel.classList.add("premium-content-switcher-second-label-active");
            } else {
                content.children[0].style.display = "block";
                content.children[1].style.display = "none";
                if (firstLabel) firstLabel.classList.add("premium-content-switcher-first-label-active");
                if (secondLabel) secondLabel.classList.remove("premium-content-switcher-second-label-active");
            }
        });
    }

    // Handle button type switcher
    const toggleButtons = contentSwitcher.querySelectorAll(
        ".premium-content-switcher-toggle-btn"
    );
    toggleButtons.forEach((button, index) => {
        button.addEventListener("click", () => {
            if (index === 0) {
                // First button clicked - show first content
                content.children[0].style.display = "block";
                content.children[1].style.display = "none";
                // Update active state
                toggleButtons[0].classList.add(
                    "premium-content-switcher-toggle-btn-active"
                );
                toggleButtons[1].classList.remove(
                    "premium-content-switcher-toggle-btn-active"
                );
            } else {
                // Second button clicked - show second content
                content.children[1].style.display = "block";
                content.children[0].style.display = "none";
                // Update active state
                toggleButtons[1].classList.add(
                    "premium-content-switcher-toggle-btn-active"
                );
                toggleButtons[0].classList.remove(
                    "premium-content-switcher-toggle-btn-active"
                );
            }
        });
    });


    // Handle Switcher Icon
    var firstType = contentSwitcher.getAttribute("data-icontypefirst"),
        secondType = contentSwitcher.getAttribute("data-icontypesecond"),
        id = contentSwitcher.getAttribute("id");
    if (firstType === "svg") {
        var svg = document.getElementById(`premium-content-switcher-svg-first-${id}`);
        var src = svg.getAttribute("data-src");
        svg.innerHTML = src;
        return svg.firstElementChild;
    }

    if (secondType === "svg") {
        var svg = document.getElementById(`premium-content-switcher-svg-second-${id}`);
        var src = svg.getAttribute("data-src");
        svg.innerHTML = src;
        return svg.firstElementChild;
    }
});
