window.addEventListener("DOMContentLoaded", function (event) {
    var icons = document.querySelectorAll(".premium-star-ratings");
    if (!icons) return;

    icons.forEach(function (icon) {

        var type = icon.getAttribute("data-ratingIcon"),
            id = icon.getAttribute("id");
        if (type === "svg") {
            var svgs = icon.querySelectorAll(`.premium-star-ratings-svg-class-${id}`);
            svgs.forEach(function (svg) {
                var src = svg.getAttribute("data-src");
                if (src) {
                    svg.innerHTML = src
                    return svg.firstElementChild
                }
            });
        }
    })
})