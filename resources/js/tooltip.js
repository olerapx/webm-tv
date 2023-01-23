const tooltip = {
    show: function (element) {
        if (!element) {
            return;
        }

        element.classList.add('show');

        setTimeout( function() {
            element.classList.remove('show');
        }, 1000);
    }
}

export default tooltip;
