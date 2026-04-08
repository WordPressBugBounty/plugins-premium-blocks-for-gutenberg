window.addEventListener("DOMContentLoaded", function (event) {
    var titleContainer = document.querySelectorAll(".premium-title-container");

    if (!titleContainer) return;
    titleContainer.forEach(function (icon) {
        var type = icon.getAttribute("data-icontype"),
            id = icon.getAttribute("id");
        if (type === "svg") {
            var svg = document.getElementById(`premium-title-svg-${id}`);
            var src = svg.getAttribute("data-src");
            svg.innerHTML = src;
            return svg.firstElementChild;
        }
    });

    titleContainer.forEach(function (icon) {
        if (icon.classList.contains("style8")) {
            let titleElement = icon.querySelector(".premium-title-text-title"),
                titleicon = icon.querySelectorAll(".premium-title-header"),
                animateDelay = titleicon[0].getAttribute("data-blur-delay"),
                animateduration = titleicon[0].getAttribute("data-shiny-dur"),
                holdTime = animateDelay * 1000,
                duration = animateduration * 1000;

            const intervalTime =
                duration > holdTime ? duration + holdTime : holdTime;

            function shinyEffect() {
                titleElement.setAttribute("data-animation", "shiny");
                setTimeout(function () {
                    titleElement.removeAttribute("data-animation");
                }, duration);
            }

            shinyEffect();

            setInterval(() => {
                shinyEffect();
            }, intervalTime);
        }
    });

    titleContainer.forEach(function (icon) {
        if (icon.classList.contains("style9")) {
            let titleElement = icon.querySelector(
                    ".premium-title-style9__wrap",
                ),
                animateDelay = titleElement.getAttribute("data-blur-delay"),
                holdTime = animateDelay * 1000;

            titleElement.setAttribute("data-animation-blur", "process");

            titleElement
                .querySelectorAll(".premium-title-style9-letter")
                .forEach(function (letter, index) {
                    index += 1;
                    let delayTime;
                    if (
                        document
                            .getElementsByTagName("BODY")[0]
                            .classList.contains(".rtl")
                    ) {
                        delayTime = 0.2 / index + "s";
                    } else {
                        delayTime = index / 20 + "s";
                    }
                    letter.style.animationDelay = delayTime;
                });
            setInterval(function () {
                titleElement.setAttribute("data-animation-blur", "done");
                setTimeout(function () {
                    titleElement.setAttribute("data-animation-blur", "process");
                }, 150);
            }, holdTime);
        }
    });
});
