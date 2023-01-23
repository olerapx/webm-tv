import './bootstrap'

import Alpine from 'alpinejs'
window.Alpine = Alpine

import plyr from "plyr"
window.plyr = plyr
import 'plyr/dist/plyr.css'

import hotkeys from 'hotkeys-js'
window.hotkeys = hotkeys

import "./board-search"

import './player'
import './player-hotkeys'
import './clipboard'
import './playlist.js'
import './playlist-item'
import '../css/player.css'

import './tooltip'

Alpine.start()
