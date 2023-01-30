class HotkeyTooltip {
    static add(element) {
        tippy(element, {
            content: this.hint(),
            allowHTML: true,
            appendTo: 'parent'
        })
    }

    static hint() {
        return `
            <b>A / D</b> - Prev / Next<br>
            <b>W</b> - Copy URL<br>
            <b>S</b> - Download<br>
            <b>F</b> - Fullscreen<br>
            <b>Space</b> - Pause<br>
            <b>&uarr; / &darr;</b> - Volume<br>
            <b>&larr; / &rarr;</b> - Rewind / Forward<br>
            <b>1 - 9</b> - Rewind to 10% - 90%<br>
        `;
    }
}

window.HotkeyTooltip = HotkeyTooltip;
