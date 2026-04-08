/**
 * Premium Blocks for Gutenberg - Frontend Helper Functions
 *
 * Shared helper functions for frontend scripts.
 * These functions mirror the logic from @pbg/helpers used in the editor,
 * but are standalone for use in frontend/view scripts.
 */

(function (window) {
    "use strict";

    function getResponsiveValue(attribute, device = "Desktop") {
        if (!attribute) return "";

        let value = "";

        // Start with Desktop value as fallback
        if (attribute.Desktop !== undefined && attribute.Desktop !== "") {
            const unit = attribute?.unit?.Desktop || attribute?.unit || "";
            value = `${attribute.Desktop}${unit}`;
        }

        // Override with Tablet if available and device is Tablet or Mobile
        if (
            attribute.Tablet !== undefined &&
            attribute.Tablet !== "" &&
            (device === "Tablet" || device === "Mobile")
        ) {
            const unit = attribute?.unit?.Tablet || attribute?.unit || "";
            value = `${attribute.Tablet}${unit}`;
        }

        // Override with Mobile if available and device is Mobile
        if (
            attribute.Mobile !== undefined &&
            attribute.Mobile !== "" &&
            device === "Mobile"
        ) {
            const unit = attribute?.unit?.Mobile || attribute?.unit || "";
            value = `${attribute.Mobile}${unit}`;
        }

        return value;
    }

    // Expose helpers globally
    window.PBG_Helpers = {
        getResponsiveValue,
    };
})(window);
