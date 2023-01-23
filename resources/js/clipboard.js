class Clipboard {
    static copy(value, success) {
        let textArea = document.createElement('textarea');

        textArea.style.position = 'fixed';
        textArea.style.top = 0;
        textArea.style.left = 0;
        textArea.style.width = '2em';
        textArea.style.height = '2em';
        textArea.style.background = 'transparent';

        textArea.value = value;

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            document.execCommand('copy');
            success();
        } catch (e) {
        }
    }
}

window.Clipboard = Clipboard;
