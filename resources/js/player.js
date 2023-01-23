const player = {
    counts: {
        initial: 20,
        total: 200,
        fillUpTo: 10
    },

    init: async function (container) {
        const videoElement = container.querySelector('.js-plyr-video');
        const playlistElement = container.querySelector('.js-plyr-playlist');

        const videos = await axios.post('/api/video/fetch', {
            website: videoElement.dataset.website,
            board: videoElement.dataset.board,
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

        const player = new window.plyr(videoElement, {
            keyboard: {focused: false, global: false}
        });

        player.once('ready', function () {
            plyrPlaylist.init(container, player, playlist, playlistElement);
        });

        this.initEvents();
        this.initKeyboard(player);
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
        // fileSaver.saveAs(video.sources[0].src, video.title);
    }
};

addEventListener('board-player-init', async (event) => {
    const container = event.target;

    if (typeof container.dataset.playerInited !== 'undefined') {
        return;
    }

    container.dataset.playerInited = true;
    await player.init(container);

    container.scrollIntoView({behavior: 'smooth'});
});
