document.addEventListener("DOMContentLoaded", function () {
    const containers = document.querySelectorAll(".premium-mask-yes");
    containers.forEach(container => {
        let target = container.querySelector(".premium-dheading-block__title");
        target.querySelectorAll("span").forEach(span => {
            var html = "";
            span.textContent.split(" ").forEach(item => {
                if (item.trim() !== "") {
                    html += ' <span class="premium-mask-span">' + item + "</span>";
                }
            });
            span.innerHTML = html;
        });
        new Waypoint({
            element: container,
            handler: function () {
                container.classList.add("premium-mask-active");
            },
            offset: "50%", // Adjust the offset as needed
        });
    });
});
