class WatchHistory {
    sendQueue = 5


    // title
    // url
    // mime
    // hash
    // url_hash
    // duration

    // TODO: store and then asynchronously send, without awaiting
    // TODO: detect already sent and do not send twice
}

window.WatchHistory = WatchHistory;
