document.addEventListener("DOMContentLoaded", function () {
    const modals = document.querySelectorAll(".premium-modal-box");

    modals.forEach((modal) => {
        const settings = modal.dataset.trigger;
        const wrapClass = modal.querySelector(".premium-popup__modal_content");
        const wrapOverlay = modal.querySelector(
            ".premium-popup__modal_wrap_overlay",
        );
        const closes = wrapClass.querySelectorAll(
            ".premium-modal-box-close-button-container",
        );
        const modalWrap = modal.querySelector(".premium-popup__modal_wrap");

        document.body.appendChild(modalWrap);

        function showModal() {
            modalWrap.style.display = "flex";
        }

        function hideModal() {
            modalWrap.style.display = "none";
        }

        closes.forEach((close) => {
            close.addEventListener("click", hideModal);
        });

        if (settings === "load") {
            const delayTime = wrapClass.dataset.delay;
            setTimeout(showModal, delayTime * 1000);
        }

        if (settings === "button") {
            const button = modal.querySelector(
                ".premium-modal-trigger-container button",
            );

            const type = button.dataset.icontype;
            const id = button.id;

            // Backward compatibility for SVG icons -- Can be removed after few updates
            if (type === "svg") {
                const svg = document.querySelector(`#premium-modal-svg-${id}`);
                const src = svg.dataset.src;

                if (src) svg.innerHTML = src;
            }

            button.addEventListener("click", showModal);
        }

        if (settings === "image") {
            const image = modal.querySelector(
                ".premium-modal-trigger-container img",
            );
            image.addEventListener("click", showModal);
        }

        if (settings === "text") {
            const textTrigger = modal.querySelector(
                ".premium-modal-trigger-container span",
            );
            textTrigger.addEventListener("click", showModal);
        }

        if (settings === "lottie") {
            const lottieTrigger = modal.querySelector(
                ".premium-modal-trigger-container .premium-lottie-animation",
            );
            lottieTrigger.addEventListener("click", showModal);
        }

        wrapOverlay.addEventListener("click", hideModal);
    });
});
