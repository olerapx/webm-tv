class PlayerState {
    constructor() {
        this.inited = false;
        this.loading = false;
        this.noVideos = false;
        this.closedBoard = false;
    }

    isInited() {
        return this.inited && !this.noVideos && !this.closedBoard;
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

    isClosedBoard() {
        return this.closedBoard;
    }

    setClosedBoard(value) {
        this.closedBoard = value;
    }

    isNoVideos() {
        return this.noVideos && !this.closedBoard;
    }

    setNoVideos() {
        this.noVideos = true;
    }
}

window.PlayerState = PlayerState;
