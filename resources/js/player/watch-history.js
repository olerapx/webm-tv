class WatchHistory {
    static sendQueueSize = 5
    static sendIntervalMs = 5000

    constructor(website, board) {
        this.website = website;
        this.board = board;

        this.queue = [];
        this.sent = new Set();
        this.timeoutId = null;
        this.csrf = document.querySelector('meta[name="csrf-token"]').content;

        this.scheduleSend();
        this.sendBeforeExit();
    }

    scheduleSend() {
        if (this.timeoutId) {
            clearTimeout(this.timeoutId);
        }

        this.timeoutId = setTimeout(this.send.bind(this), WatchHistory.sendIntervalMs);
    }

    sendBeforeExit() {
        window.addEventListener('beforeunload', this.send.bind(this));
    }

    async push(video) {
        if (this.sent.has(video)) {
            return;
        }

        this.queue.push(video);
        this.sent.add(video);

        if (Object.keys(this.queue).length > WatchHistory.sendQueueSize) {
            await this.send();
        }
    }

    async send() {
        this.scheduleSend();

        if (!this.queue.length) {
            return;
        }

        await fetch('/api/video/add-to-history', {
            method: 'POST',
            body: JSON.stringify({
                videos: this.queue,
                website: this.website,
                board: this.board
            }),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.csrf
            },
            keepalive: true
        });

        this.queue = [];
    }
}

window.WatchHistory = WatchHistory;
