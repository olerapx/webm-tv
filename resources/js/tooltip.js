class Tooltip {
    static show(element) {
        if (!element) {
            return;
        }

        element.classList.add('show');

        setTimeout( function() {
            element.classList.remove('show');
        }, 1000);
    }
}

window.Tooltip = Tooltip;
