class User {
    static user = '';

    static setUser(username) {
        this.user = username;
    }

    static authorized() {
        return !!this.user.length;
    }
}

window.User = User;
