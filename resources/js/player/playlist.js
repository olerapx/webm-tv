class Playlist {
    constructor() {
        this.items = [];
        this.currentIndex = null;
    }

    add(playlist) {
        for (const item of playlist) {
            this.items.push(new PlaylistItem(item));
        }
    }

    select(index) {
        let playlistItem = this.items[index];
        if (typeof playlistItem === 'undefined') {
            return null;
        }

        for (let item of this.items) {
            item.playing = false;
        }

        playlistItem.playing = true;
        this.currentIndex = index;

        return playlistItem;
    }

    next() {
        if (this.currentIndex === null || this.currentIndex === this.items.length - 1) {
            return null;
        }

        return this.currentIndex + 1;
    }

    prev() {
        if (this.currentIndex === null || this.currentIndex === 0) {
            return null;
        }

        return this.currentIndex - 1;
    }

    getCurrentVideo() {
        if (!this.currentIndex) {
            return null;
        }

        return this.items[this.currentIndex].video;
    }
}

window.Playlist = Playlist;
