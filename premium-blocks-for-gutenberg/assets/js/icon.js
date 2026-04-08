window.addEventListener("DOMContentLoaded", function (event) {
    var icons = document.querySelectorAll(".premium-icon");
    if (!icons) return;

    icons.forEach(function (icon) {

        var type = icon.getAttribute("data-icontype"),
            id = icon.getAttribute("id");
        if (type === "svg") {
            var svg = document.getElementById(
                `premium-icon-svg-${id}`
            )
            var src = svg.getAttribute("data-src");
            svg.innerHTML = src
            return svg.firstElementChild
        }
    })
})