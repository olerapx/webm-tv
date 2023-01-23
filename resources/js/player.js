var player = {
    init: async function (element) {
        var videojs = window.videojs(element);

        let videos = await axios.post('/api/video/fetch', {
            website: element.dataset.website,
            board: element.dataset.board,
            count: 50
        });

        // videojs.playlist([{
        //     sources: [{
        //         src: 'http://media.w3.org/2010/05/sintel/trailer.mp4',
        //         type: 'video/mp4'
        //     }],
        //     thumbnail: 'http://media.w3.org/2010/05/sintel/poster.png',
        //     poster: 'http://media.w3.org/2010/05/sintel/poster.png',
        //     name: 'asadsa.webm'
        // }, {
        //     sources: [{
        //         src: 'http://media.w3.org/2010/05/bunny/trailer.mp4',
        //         type: 'video/mp4'
        //     }],
        //     poster: 'http://media.w3.org/2010/05/bunny/poster.png'
        // }, {
        //     sources: [{
        //         src: 'http://vjs.zencdn.net/v/oceans.mp4',
        //         type: 'video/mp4'
        //     }],
        //     poster: 'http://www.videojs.com/img/poster.jpg'
        // }, {
        //     sources: [{
        //         src: 'http://media.w3.org/2010/05/bunny/movie.mp4',
        //         type: 'video/mp4'
        //     }],
        //     poster: 'http://media.w3.org/2010/05/bunny/poster.png'
        // }, {
        //     sources: [{
        //         src: 'http://media.w3.org/2010/05/video/movie_300.mp4',
        //         type: 'video/mp4'
        //     }],
        //     poster: 'http://media.w3.org/2010/05/video/poster.png'
        // }]);

        videojs.playlistUi({
            playOnSelect: true,
            nextButton: true
        });
    }
};

addEventListener('board-player-init', async (event) => {
    const element = event.target;
    await player.init(element);
});
