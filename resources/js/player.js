import plyrPlaylist from "./playlist";

const player = {
    counts: {
        initial: 20,
        total: 200,
        fillUpTo: 10
    },

    videoElement: null,
    playlistElement: null,

    init: async function (container) {
        this.videoElement = container.querySelector('.js-plyr-video');
        this.playlistElement = container.querySelector('.js-plyr-playlist');

        const videos = await axios.post('/api/video/fetch', {
            website: this.videoElement.dataset.website,
            board: this.videoElement.dataset.board,
            count: this.counts.initial
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

        const player = new window.plyr(this.videoElement, {
            keyboard: {focused: false, global: false}
        });

        player.once('ready', function () {
            plyrPlaylist.init(container, player, playlist, this.playlistElement);
        }.bind(this));

        this.initGui(container, player);
        this.initEvents();
        this.initKeyboard(player);
    },

    initGui: function(container, player) {
        player.on('ready', function () {
            let play = container.querySelector('.plyr__controls').querySelector('[data-plyr="play"]');

            if (plyrPlaylist.getNext()) {
                play.after(
                    this.playlistElement.querySelector('.js-plyr-next').content.cloneNode(true).querySelector('button')
                );
            }

            if (plyrPlaylist.getPrev()) {
                play.before(
                    this.playlistElement.querySelector('.js-plyr-prev').content.cloneNode(true).querySelector('button')
                );
            }

            let settings = container.querySelector('.plyr__controls').querySelector('[data-plyr="settings"]');
            settings.after(
                this.playlistElement.querySelector('.js-plyr-download').content.cloneNode(true).querySelector('button')
            );

            settings.after(
                this.playlistElement.querySelector('.js-plyr-share').content.cloneNode(true).querySelector('button')
            );
        }.bind(this));
    },

    initEvents: function () {
        addEventListener('board-playlist-select', (event) => {
            plyrPlaylist.select(event.target.closest('.playlist-item'));
        });

        addEventListener('board-playlist-next', () => {
            plyrPlaylist.next();
        });

        addEventListener('board-playlist-prev', () => {
            plyrPlaylist.prev();
        });

        addEventListener('board-playlist-download', () => {
            this.download();
        });

        addEventListener('board-playlist-share', () => {

        });
    },

    initKeyboard: function (player) {
        const actions = {
            'd': () => {
                plyrPlaylist.next()
            },
            'a': () => {
                plyrPlaylist.prev()
            },
            's': () => {
                this.download()
            },
            'f': () => {
                player.fullscreen.toggle()
            },
            'space': () => {
                player.togglePlay()
            },
            'right': () => {
                player.forward()
            },
            'left': () => {
                player.rewind()
            },
            'up': () => {
                player.increaseVolume(.05)
            },
            'down': () => {
                player.decreaseVolume(.05)
            }
        };

        for (let i of [...Array(10).keys()]) {
            i++;

            actions[i] = () => {
                player.currentTime = player.duration / 10 * i;
            }
        }

        for (const [key, callback] of Object.entries(actions)) {
            hotkeys(key, (event) => {
                event.preventDefault();
                callback();
            })
        }
    },

    download: function() {
        let video = plyrPlaylist.getCurrentVideo();
        if (!video) {
            return;
        }

        window.open(`/download?file=${encodeURIComponent(video.sources[0].src)}`, '_blank');
    }
};

addEventListener('board-player-init', async (event) => {
    const container = event.target;

    if (typeof container.playerInited !== 'undefined') {
        return;
    }

    container.playerInited = true;
    await player.init(container);

    container.scrollIntoView({behavior: 'smooth'});
});
