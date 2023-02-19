class WatchHistory {
    sendQueueSize = 5

    async push(video) {
        console.log(video);

        // TODO: store and then asynchronously send, without awaiting
        // TODO: detect already sent and do not send twice
        // TODO: send any leftover videos onbeforeunload
    }
}

window.WatchHistory = WatchHistory;
