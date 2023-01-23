import './bootstrap'

import Alpine from 'alpinejs'
window.Alpine = Alpine

import plyr from "plyr"
window.Plyr = plyr
import 'plyr/dist/plyr.css'

import hotkeys from 'hotkeys-js'
window.hotkeys = hotkeys

import tippy from 'tippy.js'
window.tippy = tippy
import 'tippy.js/dist/tippy.css'

import './board-search'

import './player'
import './player/player-hotkeys'
import './player/playlist'
import './player/playlist-item'
import './player/video-fetcher'
import './player/hotkey-tooltip'
import '../css/player.css'
import './clipboard'
import './tooltip'

import './login'
import '../css/modal.css'

Alpine.start()
