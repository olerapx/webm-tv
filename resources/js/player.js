var player = {
    counts: {
        initial: 20,
        total: 200,
        fillUpTo: 10
    },

    init: async function (element) {
        var videojs = window.videojs(element);

        const videos = await axios.post('/api/video/fetch', {
            website: element.dataset.website,
            board: element.dataset.board,
            count: this.counts.initial
        });

        const playlist = videos.data.map(function (video) {
            return {
                sources: [{
                    src: video.url,
                    type: video.mime
                }],
                thumbnail: video.thumbnail,
                poster: video.thumbnail,
                name: video.name
            };
        });

        videojs.playlist(playlist);

        //TODO: NEXT/PREV BUTTON, MORE STYLING, FONTS

        videojs.playlistUi({
            playOnSelect: true,
            nextButton: true
        });
    }
};

addEventListener('board-player-init', async (event) => {
    const element = event.target;

    if (typeof element.dataset.playerInited !== 'undefined') {
        return;
    }

    element.dataset.playerInited = true;
    await player.init(element);
});
