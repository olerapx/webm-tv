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

        this.state = new PlayerState();
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

            this._initControls();

            if (!this.playlist.items.length) {
                this.state.setNoVideos();
            }

            this.state.setInited();
        });

        this.player.on('ended', () => {
            this.selectNext();
        });

        PlayerHotkeys.init(this);
    }

    async _loadVideos(count) {
        if (this.state.isLoading() || this.videoFetcher.noMoreVideos || this.state.isClosedBoard()) {
            return;
        }
        this.state.setLoading(true);

        try {
            const playlist = await this.videoFetcher.fetch(this.website, this.board, count, this.playlist.hashes());
            this.playlist.add(playlist);
        } catch (e) {
            console.error(e);

            if (e === PlayerErrors.CLOSED_BOARD()) {
                this.state.setLoading(false);
                this.state.setClosedBoard(true);
                return;
            }
        }

        let exceededVideos = this.playlist.items.length - this.counts().total;
        if (this.playlist.items.length > this.counts().total) {
            this.playlist.slice(exceededVideos);
        }

        this._play(this.playlist.currentIndex);
        this.state.setLoading(false);
    }

    _initControls () {
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
        if (playlistItem === null || this.player.source === playlistItem.video.sources[0].src) {
            return;
        }

        this.player.source = playlistItem.video;
        this.player.play().catch(() => {})
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
        let video = this.playlist.currentVideo();
        if (!video) {
            return;
        }

        window.open(`/download?file=${encodeURIComponent(video.sources[0].src)}`, '_blank');
    }

    share () {
        let video = this.playlist.currentVideo();
        if (!video) {
            return;
        }

        Clipboard.copy(video.sources[0].src, () => {
            Tooltip.show(this.container.querySelector('.js-plyr-share-button'), 'copied!', 1000);
        });
    }
}

window.Player = Player;
