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
        this.loaded = false;

        this.playlist = new Playlist();
    }

    async load() {
        const playlist = await VideoFetcher.fetch(this.website, this.board, this.counts().initial);

        this.player = new Plyr(this.container.querySelector('.js-plyr-video'), {
            keyboard: {focused: false, global: false}
        });

        this.player.once('ready', function () {
            this.playlist.add(playlist);
            this.select(0);

            this._initGui();

            this.loaded = true;
        }.bind(this));

        this.player.on('ended', () => {
            this.selectNext();
        });

        PlayerHotkeys.init(this);
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

    select(index) {
        let playlistItem = this.playlist.select(index);
        if (playlistItem !== null) {

            // todo: if file is deleted, delete it from playlist and open the next one (or prev)
            this.player.source = playlistItem.video;
            this.player.play().catch((e) => {})
        }
    }

    selectNext() {
        if (this.playlist.next() !== null) {
            this.select(this.playlist.next());
        }
    }

    selectPrev() {
        if (this.playlist.prev() !== null) {
            this.select(this.playlist.prev());
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
