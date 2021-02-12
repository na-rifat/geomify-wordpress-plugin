class Button extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {
                button: `.geomify-ew-button`,
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
        this.elements.$button.on(`click`, this.showAlert.bind(this));
    }

    showAlert() {
        alert(123123);
        // alert(jQuery(this).text());
    }
}

jQuery(window).on(`elementor/frontend/init`, () => {
    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(Button, {
            $element,
        });
    };

    elementorFrontend.hooks.addAction(
        `frontend/element_ready/geomify_button.default`,
        addHandler
    );
});
