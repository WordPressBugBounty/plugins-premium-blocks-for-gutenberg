window.addEventListener("DOMContentLoaded", function (event) {
    var icons = document.querySelectorAll(".premium-bullet-list__content-wrap");
    if (!icons) return;

    icons.forEach(function (icon) {

        var type = icon.getAttribute("data-icontype"),
            id = icon.getAttribute("id");
        if (type === "svg") {
            var svg = document.getElementById(
                `premium-list-item-svg-${id}`
            )
            var src = svg.getAttribute("data-src");
            svg.innerHTML = src
            return svg.firstElementChild
        }
    })
})