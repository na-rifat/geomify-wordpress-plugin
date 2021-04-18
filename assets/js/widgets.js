"use strict";
class Button extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {
                button: `.geomify-video-button`,
            },
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings(`selectors`);
        return {
            $button: this.$element.find(selectors.button),
        };
    }

    bindEvents() {
        this.elements.$button.on(
            `click`,
            this.playVideo.bind(this.elements.$button)
        );
    }

    playVideo() {
        let self = this;
        let video_source_type = self.data(`video-source-type`);
        let url = self.data(`video-url`);
        let player = ``;

        switch (video_source_type) {
            case `youtube`:
                player = `<iframe src="${url}"></iframe>"`;
                break;
            case `self_hosted`:
                player = `<video><source src="${url}" type="video/mp4"></video>`;
                break;
            default:
                break;
        }
        lightBox(`<div class="geomify-lightbox-video">${player}</div>`);
    }
}

jQuery(window).on(`elementor/frontend/init`, () => {
    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(Button, {
            $element,
        });
    };

    elementorFrontend.hooks.addAction(
        `frontend/element_ready/geomify_video_button.default`,
        addHandler
    );
});
