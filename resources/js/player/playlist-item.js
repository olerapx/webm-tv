class PlaylistItem {
    constructor(video) {
        this.video = video;
        this.playing = false;
    }

    duration() {
        return formatDuration(this.video.duration, {leading: true})
    }
}

window.PlaylistItem = PlaylistItem;
