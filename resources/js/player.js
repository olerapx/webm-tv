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

        const player = new window.plyr(videoElement, {});
        player.once('ready', function () {
            plyrPlaylist.init(container, player, playlist, playlistElement);
        });
    }
};

addEventListener('board-player-init', async (event) => {
    const container = event.target;

    if (typeof container.dataset.playerInited !== 'undefined') {
        return;
    }

    container.dataset.playerInited = true;
    await player.init(container);
});

addEventListener('board-playlist-select', (event) => {
    plyrPlaylist.select(event.target.closest('.playlist-item'));
});

addEventListener('board-playlist-next', () => {
    plyrPlaylist.next();
});

addEventListener('board-playlist-prev', () => {
    plyrPlaylist.prev();
});
