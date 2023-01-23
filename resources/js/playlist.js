class Playlist {
    constructor() {
        this.items = [];
        this.playing = null;
    }

    /**
     *
     * @param player Player
     */
    setPlayer(player) {
        this.player = player;
    }

    load(playlist) {
        let prev = this.items.length ? this.items.at(-1) : null;

        for (const item of playlist) {
            let playlistItem = new PlaylistItem(item);

            if (prev) {
                playlistItem.prev = prev;
                prev.next = playlistItem;
            }

            this.items.push(playlistItem);
            prev = playlistItem;
        }

        if (this.items.length) {
            this.select(this.items[0]);
        }
    }

    /**
     * @param playlistItem PlaylistItem
     */
    select(playlistItem) {
        for (let item of this.items) {
            item.playing = false;
        }

        playlistItem.playing = true;
        this.playing = playlistItem;

        // todo: if file is deleted, delete it from playlist and open the next one (or prev)
        this.player.player.source = playlistItem.video;
        this.player.player.play().catch((e) => {})
    }

    next() {
        if (this.getNext()) {
            this.select(this.getNext());
        }
    }

    getNext() {
        if (!this.playing || !this.playing.next) {
            return null;
        }

        return this.playing.next;
    }

    prev() {
        if (this.getPrev()) {
            this.select(this.getPrev());
        }
    }

    getPrev() {
        if (!this.playing || !this.playing.prev) {
            return null;
        }

        return this.playing.prev;
    }

    getCurrentVideo() {
        if (!this.playing) {
            return null;
        }

        return this.playing.video;
    }
}

window.Playlist = Playlist;
