const plyrPlaylist = {
    player: null,
    container: null,

    init: function(container, player, playlist, playlistElement) {
        this.player = player;
        this.container = container;

        this.initPlaylist(playlist, playlistElement);
    },

    initPlaylist: function(playlist, playlistElement) {
        this.addControls(playlistElement);

        const template = playlistElement.querySelector('.js-plyr-playlist-item-template');
        let first = true;

        for (const item of playlist) {
            const playlistItem = template.content.cloneNode(true).querySelector('li');

            playlistItem.querySelector('img').src = item.poster;
            playlistItem.querySelector('span').textContent = item.title;
            playlistItem.video = item;

            playlistElement.appendChild(playlistItem);

            if (first) {
                this.select(playlistItem);
                first = false;
            }
        }

        this.player.on('ended', () => {
            this.next();
        });
    },

    addControls: function (playlistElement) {
        this.player.on('ready', function () {
            let play = this.container.querySelector('.plyr__controls').querySelector('[data-plyr="play"]');

            if (this.getNext()) {
                play.after(
                    playlistElement.querySelector('.js-plyr-next').content.cloneNode(true).querySelector('button')
                );
            }

            if (this.getPrev()) {
                play.before(
                    playlistElement.querySelector('.js-plyr-prev').content.cloneNode(true).querySelector('button')
                );
            }

            let settings = this.container.querySelector('.plyr__controls').querySelector('[data-plyr="settings"]');
            settings.after(
                playlistElement.querySelector('.js-plyr-download').content.cloneNode(true).querySelector('button')
            );

            settings.after(
                playlistElement.querySelector('.js-plyr-share').content.cloneNode(true).querySelector('button')
            );
        }.bind(this));
    },

    select: function (playlistItem) {
        // todo: if file is deleted, delete it from playlist and open the next one (or prev)
        let playing = this.container.querySelector('.pls-playing');
        if (playing) {
            playing.classList.remove('pls-playing');
        }

        playlistItem.classList.add('pls-playing')
        this.player.source = playlistItem.video;

        this.player.play().catch((e) => {})
    },

    next: function () {
        const next = this.getNext();

        if (next) {
            this.select(next);
        }
    },

    getNext: function () {
        let playing = this.container.querySelector('.pls-playing');

        if (!playing) {
            return null;
        }

        let next = playing.nextSibling;
        if (!next || next.nodeName === '#text') {
            return null;
        }

        return next;
    },

    prev: function () {
        const prev = this.getPrev();

        if (prev) {
            this.select(prev);
        }
    },

    getPrev: function () {
        let playing = this.container.querySelector('.pls-playing');

        if (!playing) {
            return null;
        }

        let prev = playing.previousSibling;
        if (!prev || prev.nodeName === '#text') {
            return null;
        }

        return prev;
    },

    getCurrentVideo: function () {
        let playing = this.container.querySelector('.pls-playing');

        if (!playing) {
            return null;
        }

        return playing.video;
    },
};

export default plyrPlaylist
