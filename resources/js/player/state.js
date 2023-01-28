class PlayerState {
    constructor() {
        this.inited = false;
        this.loading = false;
        this.noVideos = false;
    }

    isInited() {
        return this.inited && !this.noVideos;
    }

    setInited() {
        this.inited = true;
    }

    isLoading() {
        return this.loading;
    }

    setLoading(loading) {
        this.loading = loading;
    }

    isNoVideos() {
        return this.noVideos;
    }

    setNoVideos() {
        this.noVideos = true;
    }
}

window.PlayerState = PlayerState;
