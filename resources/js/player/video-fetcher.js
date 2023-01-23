class VideoFetcher {
    static async fetch(website, board, count, hashes) {
        const videos = await axios.post('/api/video/fetch', {
            website: website,
            board: board,
            count: count,
            hashes: hashes
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
                hash: video.hash,
                url_hash: video.url_hash
            };
        });
    }
}

window.VideoFetcher = VideoFetcher;
