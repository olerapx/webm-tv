class VideoFetcher {
    constructor() {
        this.noMoreVideos = false;
    }

    async fetch(website, board, count, hashes) {
        if (this.noMoreVideos) {
            return [];
        }

        const videos = await axios.post('/api/video/fetch', {
            website: website,
            board: board,
            count: count,
            hashes: hashes,
            access_code: AccessCode.get(website)
        }).catch(function (e) {
            if (e && e.response && e.response.data && e.response.data.code === PlayerErrors.CLOSED_BOARD()) {
                throw e.response.data.code;
            }

            throw e;
        });

        const result = videos.data.map(function (video) {
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

        if (result.length < count) {
            this.noMoreVideos = true;
        }

        return result;
    }
}

window.VideoFetcher = VideoFetcher;
