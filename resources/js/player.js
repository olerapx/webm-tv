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
        this.videoFetcher = new VideoFetcher();
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

        try {
            const playlist = await this.videoFetcher.fetch(this.website, this.board, count, this.playlist.hashes());
            this.playlist.add(playlist);
        } catch (e) {
            Tooltip.show(this.container.querySelector('.plyr__controls'), e.toString(), 5000);
            console.error(e);
        }

        let exceededVideos = this.playlist.items.length - this.counts().total;
        if (this.playlist.items.length > this.counts().total) {
            this.playlist.slice(exceededVideos);
        }

        this._play(this.playlist.currentIndex);
        this.loading = false;
    }

    _initGui () {
        this.player.on('ready', () => {
            let buttons = this.container.querySelector('.js-plyr-buttons').content.cloneNode(true).querySelectorAll('button');
            let controls = this.container.querySelector('.plyr__controls');

            for (const button of buttons) {
                let reference = controls.querySelector(button.dataset.reference);
                button.dataset.position === 'before' ? reference.before(button) : reference.after(button);
            }
        });
    }

    async select(index) {
        this._play(index);
        await this._loadMore(index);
    }

    _play(index) {
        let playlistItem = this.playlist.select(index);
        if (playlistItem !== null) {
            if (this.player.source === playlistItem.video.sources[0].src) {
                return;
            }

            this.player.source = playlistItem.video;
            this.player.play().catch(() => {})
        }
    }

    async _loadMore(index) {
        const videosLeft = this.playlist.items.length - (index + 1);
        if (videosLeft < this.counts().fillUpTo) {
            await this._loadVideos(this.counts().fillUpTo - videosLeft);
        }
    }

    async selectNext() {
        await this.select(this.playlist.next());
    }

    async selectPrev() {
        await this.select(this.playlist.prev());
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
