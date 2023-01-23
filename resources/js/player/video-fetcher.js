class VideoFetcher {
    static async fetch(website, board, count) {
        const videos = await axios.post('/api/video/fetch', {
            website: website,
            board: board,
            count: count
        });

        return videos.data.map(function (video) {
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
    }
}

window.VideoFetcher = VideoFetcher;
