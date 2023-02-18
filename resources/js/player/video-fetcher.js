class VideoFetcher {
    constructor(website, board) {
        this.website = website;
        this.board = board;

        this.noMoreVideos = false;
    }

    async fetch(count, hashes) {
        if (this.noMoreVideos) {
            return [];
        }

        const videos = await axios.post('/api/video/fetch', {
            website: this.website,
            board: this.board,
            count: count,
            hashes: hashes,
            access_code: AccessCode.get(this.website)
        }).catch(function (e) {
            if (e && e.response && e.response.data && e.response.data.code === PlayerErrors.closedBoard) {
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
                url_hash: video.url_hash,
                duration: video.duration_seconds * 1000,
                original: video
            };
        });

        if (result.length < count) {
            this.noMoreVideos = true;
        }

        return result;
    }
}

window.VideoFetcher = VideoFetcher;
