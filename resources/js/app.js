import './bootstrap'

import Alpine from 'alpinejs'
window.Alpine = Alpine

import plyr from "plyr"
window.Plyr = plyr
import 'plyr/dist/plyr.css'

import hotkeys from 'hotkeys-js'
window.hotkeys = hotkeys

import formatDuration from 'format-duration/format-duration'
window.formatDuration = formatDuration;

import tippy from 'tippy.js'
window.tippy = tippy
import 'tippy.js/dist/tippy.css'

import './user'

import './board-search'

import '../css/vars.css'
import './player'
import './player/player-state'
import './player/access-code'
import './player/player-errors'
import './player/player-hotkeys'
import './player/playlist'
import './player/playlist-item'
import './player/video-fetcher'
import './player/hotkey-tooltip'
import './player/watch-history'
import '../css/player.css'
import './clipboard'
import './tooltip'

import './login'
import '../css/modal.css'

Alpine.start()
