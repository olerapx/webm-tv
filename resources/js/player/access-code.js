class AccessCode {
    constructor(form) {
        this.form = form;
    }

    async submit() {
        const formData = new FormData(this.form);
        let code = formData.get('code');

        // todo: localstorage
    }
}

window.AccessCode = AccessCode;
