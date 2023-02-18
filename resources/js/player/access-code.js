class AccessCode {
    static storageKey = 'access-codes'

    constructor(form) {
        this.form = form;
    }

    submit() {
        const formData = new FormData(this.form);

        const website = formData.get('website');
        const code = formData.get('code');

        this._update(website, code);
        location.reload();
    }

    _update(website, code) {
        let codes = AccessCode._readAll();
        codes[website] = code;

        localStorage.setItem(AccessCode.storageKey, JSON.stringify(codes));
    }

    static get(website) {
        const value = AccessCode._readAll();
        if (typeof (value[website]) === 'undefined') {
            return null;
        }

        return value[website];
    }

    static _readAll() {
        let value = localStorage.getItem(AccessCode.storageKey);
        if (!value) {
            return {};
        }

        try {
            return JSON.parse(value);
        } catch (e) {
            return {};
        }
    }
}

window.AccessCode = AccessCode;
