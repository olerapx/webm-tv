import './bootstrap'

import Alpine from 'alpinejs'
window.Alpine = Alpine

import plyr from "plyr"
window.Plyr = plyr
import 'plyr/dist/plyr.css'

import hotkeys from 'hotkeys-js'
window.hotkeys = hotkeys

import tippy from 'tippy.js';
window.tippy = tippy;
import 'tippy.js/dist/tippy.css';

import "./board-search"

import './player'
import './player-hotkeys'
import './clipboard'
import './playlist.js'
import './playlist-item'
import '../css/player.css'

import './tooltip'

Alpine.start()
