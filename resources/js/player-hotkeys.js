class PlayerHotkeys {
    /**
     * @param player Player
     */
    static init(player) {
        const actions = {
            'w': () => {
                player.share();
            },
            'a': () => {
                player.playlist.prev()
            },
            's': () => {
                player.download()
            },
            'd': () => {
                player.playlist.next()
            },
            'f': () => {
                player.player.fullscreen.toggle()
            },
            'space': () => {
                player.player.togglePlay()
            },
            'up': () => {
                player.player.increaseVolume(.05)
            },
            'left': () => {
                player.player.rewind()
            },
            'down': () => {
                player.player.decreaseVolume(.05)
            },
            'right': () => {
                player.player.forward()
            },
        };

        for (let i of [...Array(10).keys()]) {
            i++;

            actions[i] = () => {
                player.player.currentTime = player.player.duration / 10 * i;
            }
        }

        for (const [key, callback] of Object.entries(actions)) {
            hotkeys(key, (event) => {
                event.preventDefault();
                callback();
            })
        }
    }
}

window.PlayerHotkeys = PlayerHotkeys;
