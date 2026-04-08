window.addEventListener("DOMContentLoaded", (event) => {
    const icons = document.querySelectorAll(".premium-button__wrap");
  
    if (!icons) return;
  
    icons.forEach((icon) => {
      const type = icon.getAttribute("data-icontype");
      const id = icon.getAttribute("id");
  
      if (type === "svg") {
        const svg = document.getElementById(`premium-button-svg-${id}`);
        const src = svg.getAttribute("data-src");
        svg.innerHTML = src;
        svg.firstElementChild; // No need to explicitly return in this context
      }
    });
  });
  