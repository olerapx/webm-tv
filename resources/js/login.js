class Login {
    constructor(form) {
        this.form = form;
        this.errors = [];
    }

    async submit() {
        this.errors = [];

        const formData = new FormData(this.form);

        try {
            await axios.post('/api/login', formData);
            window.location.reload();
        } catch (e) {
            if (e.response) {
                this.errors = Object.values(e.response.data.errors);
            } else {
                this.errors.push('Server error')
            }
        }
    }
}

window.Login = Login;
