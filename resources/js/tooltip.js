class Tooltip {
    static show(element, content, duration) {
        if (!element) {
            return;
        }

        let instance = tippy(element, {
            content: content,
            trigger: 'manual'
        });

        instance.show();

        setTimeout(() => {
            instance.hide();
        }, duration);
    }
}

window.Tooltip = Tooltip;
