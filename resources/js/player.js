class Player {
    counts() {
        return {
            initial: 20,
            total: 200,
            fillUpTo: 10
        }
    }

    constructor(container, website, board) {
        this.container = container;
        this.website = website;
        this.board = board;
        this.inited = false;
        this.loading = false;

        this.playlist = new Playlist();
    }

    async init() {
        this.player = new Plyr(this.container.querySelector('.js-plyr-video'), {
            keyboard: {focused: false, global: false}
        });

        this.player.once('ready', async() => {
            await this._loadVideos(this.counts().initial);
            await this.select(0);

            this._initGui();

            this.inited = true;
        });

        this.player.on('ended', () => {
            this.selectNext();
        });

        PlayerHotkeys.init(this);
    }

    async _loadVideos(count) {
        if (this.loading) {
            return;
        }

        this.loading = true;

        let hashes = [];
        for (const video of this.playlist.items) {
            if (video.video.hash) {
                hashes.push(video.video.hash);
            }

            hashes.push(video.video.url_hash);
        }

        const playlist = await VideoFetcher.fetch(this.website, this.board, count, hashes);
        this.playlist.add(playlist);

        let switchToFirst = false;
        if (this.playlist.currentIndex !== null
            && this.playlist.currentIndex < (this.playlist.items.length - this.counts().total - 1)) {
            switchToFirst = true;
        }

        if (this.playlist.items.length > this.counts().total) {
            this.playlist.items = this.playlist.items
                .slice(this.playlist.items.length - this.counts().total)
                .filter((c) => c);
        }

        if (switchToFirst) {
            this._doSelect(0);
        }

        this.loading = false;
    }

    _initGui () {
        this.player.on('ready', () => {
            let play = this.container.querySelector('.plyr__controls').querySelector('[data-plyr="play"]');

            if (this.playlist.next() !== null) {
                play.after(this.container.querySelector('.js-plyr-next').content.cloneNode(true));
            }

            if (this.playlist.prev() !== null) {
                play.before(this.container.querySelector('.js-plyr-prev').content.cloneNode(true));
            }

            let settings = this.container.querySelector('.plyr__controls').querySelector('[data-plyr="settings"]');

            settings.after(this.container.querySelector('.js-plyr-download').content.cloneNode(true));
            settings.after(this.container.querySelector('.js-plyr-share').content.cloneNode(true));
        });
    }

    async select(index) {
        this._doSelect(index);

        const totalCount = this.playlist.items.length;
        if (totalCount - (index + 1) < this.counts().fillUpTo) {
            const fillUpTo = this.counts().fillUpTo - (totalCount - (index + 1));
            await this._loadVideos(fillUpTo);
        }
    }

    _doSelect(index) {
        let playlistItem = this.playlist.select(index);
        if (playlistItem !== null) {
            this.player.source = playlistItem.video;
            this.player.play().catch((e) => {})
        }
    }

    async selectNext() {
        if (this.playlist.next() !== null) {
            await this.select(this.playlist.next());
        }
    }

    async selectPrev() {
        if (this.playlist.prev() !== null) {
            await this.select(this.playlist.prev());
        }
    }

    download () {
        let video = this.playlist.getCurrentVideo();
        if (!video) {
            return;
        }

        window.open(`/download?file=${encodeURIComponent(video.sources[0].src)}`, '_blank');
    }

    share () {
        let video = this.playlist.getCurrentVideo();
        if (!video) {
            return;
        }

        Clipboard.copy(video.sources[0].src, () => {
            Tooltip.show(this.container.querySelector('.js-plyr-share-button'), 'copied!', 1000);
        })
    }
}

window.Player = Player;
