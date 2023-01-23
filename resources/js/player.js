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

        this.playlist = new Playlist();
    }

    async load() {
        this.playlist.setPlayer(this);

        const videos = await axios.post('/api/video/fetch', {
            website: this.website,
            board: this.board,
            count: this.counts().initial
        });

        const playlist = videos.data.map(function (video) {
            return {
                type: 'video',
                title: video.name,
                sources: [{
                    src: video.url,
                    type: video.mime
                }],
                poster: video.thumbnail,
            };
        });

        this.player = new Plyr(this.container.querySelector('.js-plyr-video'), {
            keyboard: {focused: false, global: false}
        });

        this.player.once('ready', function () {
            this.playlist.load(playlist);
            this._initGui();
        }.bind(this));

        this.player.on('ended', () => {
            this.playlist.next();
        });

        PlayerHotkeys.init(this);
    }

    _initGui () {
        this.player.on('ready', () => {
            let play = this.container.querySelector('.plyr__controls').querySelector('[data-plyr="play"]');

            if (this.playlist.getNext()) {
                play.after(
                    this.container.querySelector('.js-plyr-next').content.cloneNode(true).querySelector('button')
                );
            }

            if (this.playlist.getPrev()) {
                play.before(
                    this.container.querySelector('.js-plyr-prev').content.cloneNode(true).querySelector('button')
                );
            }

            let settings = this.container.querySelector('.plyr__controls').querySelector('[data-plyr="settings"]');
            settings.after(
                this.container.querySelector('.js-plyr-download').content.cloneNode(true).querySelector('button')
            );

            settings.after(
                this.container.querySelector('.js-plyr-share').content.cloneNode(true).querySelector('button')
            );
        });
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
