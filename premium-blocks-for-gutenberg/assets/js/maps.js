(() => {
    /**
     * Parse JSON styles safely.
     *
     * @param {string} mapStyle - JSON string of map styles.
     * @return {Array} Parsed styles array or empty array.
     */
    function getMapStyles(mapStyle) {
        if (!mapStyle) return [];

        try {
            return JSON.parse(mapStyle);
        } catch (e) {
            console.warn("Failed to parse map styles:", e);
            return [];
        }
    }

    /**
     * Initialize a single map instance.
     *
     * @param {string} blockId - Block ID selector.
     * @param {Object} attributes - Block attributes.
     */
    async function initMap(blockId, attributes) {
        const mapBlock = document.querySelector(`.${blockId}`);

        if (!mapBlock) {
            console.warn(`Map block not found: ${blockId}`);
            return;
        }

        const mapContainer = mapBlock.querySelector(
            ".premium-map-container > div",
        );

        if (!mapContainer) {
            console.warn(`Map container not found in: ${blockId}`);
            return;
        }

        // Extract attributes with defaults.
        const {
            mapId,
            centerLat,
            centerLng,
            zoom,
            mapType,
            mapTypeControl,
            zoomControl,
            fullscreenControl,
            streetViewControl,
            scrollwheel,
            mapStyle,
            mapMarker,
        } = attributes;

        const center = {
            lat: parseFloat(centerLat),
            lng: parseFloat(centerLng),
        };

        // Map configuration.
        const mapConfig = {
            zoom: parseInt(zoom, 10),
            center: center,
            gestureHandling: "cooperative",
            mapTypeId: mapType,
            mapTypeControl: mapTypeControl,
            zoomControl: zoomControl,
            fullscreenControl: fullscreenControl,
            streetViewControl: streetViewControl,
            scrollwheel: scrollwheel,
            cameraControl: false,
        };

        // Add mapId for advanced markers (if provided).
        if (mapId) {
            mapConfig.mapId = mapId;
        } else {
            // Only add styles if no mapId (Cloud-based styling not compatible with JSON styles).
            mapConfig.styles = getMapStyles(mapStyle);
        }

        //  Request the needed libraries.
        await Promise.all([
            google.maps.importLibrary("core"),
            google.maps.importLibrary("maps"),
            google.maps.importLibrary("marker"),
        ]);

        // Initialize the map.
        const map = new google.maps.Map(mapContainer, mapConfig);

        // Add marker if enabled.
        if (mapMarker) {
            initMarker(map, center, attributes, mapId);
        }
    }

    /**
     * Initialize marker with info window.
     *
     * @param {google.maps.Map} map - The map instance.
     * @param {Object} center - Center coordinates {lat, lng}.
     * @param {Object} attributes - Block attributes.
     * @param {string} mapId - Map ID for advanced markers.
     */
    function initMarker(map, center, attributes, mapId) {
        const {
            markerTitle,
            markerDesc,
            markerOpen,
            markerCustom,
            markerIconUrl,
            maxWidth,
        } = attributes;

        let marker;

        if (mapId) {
            // Use AdvancedMarkerElement for Cloud-based maps.
            if (
                !google.maps.marker ||
                !google.maps.marker.AdvancedMarkerElement
            ) {
                console.error(
                    "AdvancedMarkerElement not available. Ensure Map ID is correctly configured.",
                );
                return;
            }

            const markerOptions = {
                map: map,
                position: center,
            };

            // Custom marker with image for advanced markers.
            if (markerCustom && markerIconUrl) {
                const markerImg = document.createElement("img");
                markerImg.src = markerIconUrl;
                markerImg.alt = "Custom Marker";
                markerImg.width = maxWidth;
                markerImg.height = maxWidth;
                markerOptions.content = markerImg;
            }

            marker = new google.maps.marker.AdvancedMarkerElement(
                markerOptions,
            );
        } else {
            // Use standard Marker for non-Cloud maps.
            const markerOptions = {
                map: map,
                position: center,
            };

            // Custom marker icon for standard markers.
            if (markerCustom && markerIconUrl) {
                markerOptions.icon = {
                    url: markerIconUrl,
                    scaledSize: new google.maps.Size(maxWidth, maxWidth),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(maxWidth / 2, maxWidth),
                };
            }

            marker = new google.maps.Marker(markerOptions);
        }

        // Add info window if title or description exists.
        if (markerTitle || markerDesc) {
            const infoWindowContent = createInfoWindowContent(
                markerTitle,
                markerDesc,
            );
            const infoWindow = new google.maps.InfoWindow({
                content: infoWindowContent,
            });

            // Open info window on marker click.
            google.maps.event.addListener(marker, "click", () => {
                infoWindow.open({ anchor: marker, map, shouldFocus: false });
            });

            // Open info window by default if markerOpen is true.
            if (markerOpen) {
                infoWindow.open({ anchor: marker, map, shouldFocus: false });
            }
        }
    }

    /**
     * Create info window HTML content.
     *
     * @param {string} title - Marker title.
     * @param {string} desc - Marker description.
     * @return {string} HTML content.
     */
    function createInfoWindowContent(title, desc) {
        let content = "";

        if (title) {
            content += `<h3 class="premium-maps__wrap__title">${title}</h3>`;
        }

        if (desc) {
            content += `<p class="premium-maps__wrap__desc">${desc}</p>`;
        }

        return content;
    }

    /**
     * Initialize all maps blocks on the page.
     * Called by Google Maps API callback.
     */
    function initMapsBlocks() {
        const mapsSettings = window.PBG_MAPS || {};
        const { blocks } = mapsSettings;

        if (!blocks || typeof blocks !== "object") {
            console.warn("No maps blocks found to initialize.");
            return;
        }

        Object.keys(blocks).forEach((blockId) => {
            if (!blockId) return;

            const { attributes } = blocks[blockId];

            if (!attributes) {
                console.warn(`No attributes found for map: ${blockId}`);
                return;
            }

            initMap(blockId, attributes);
        });
    }

    if (window.PBG_MAPS.loadJsApi) {
        window.initMapsBlocks = initMapsBlocks;
    } else {
        // Wait for Google Maps API to be fully loaded
        let isLoaded = false;
        const checkGoogleMaps = setInterval(() => {
            if (
                typeof google !== "undefined" &&
                google.maps &&
                typeof google.maps.importLibrary === "function"
            ) {
                isLoaded = true;
                clearInterval(checkGoogleMaps);
                initMapsBlocks();
            }
        }, 100); // Check every 100ms

        // Timeout after 10 seconds to prevent infinite checking
        setTimeout(() => {
            if (!isLoaded) {
                clearInterval(checkGoogleMaps);
                console.error(
                    "Google Maps API failed to load within timeout period.",
                );
            }
        }, 10000);
    }
})();
