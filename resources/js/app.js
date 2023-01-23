import './bootstrap';

import Alpine from 'alpinejs';

import plyr from "plyr";
import "plyr/dist/plyr.css"

import hotkeys from 'hotkeys-js';

import boardSearch from "./board-search";
import "./player"
import plyrPlaylist from "./playlist.js";
import "../css/player.css"

window.Alpine = Alpine;
window.plyr = plyr;
window.hotkeys = hotkeys;

window.boardSearch = boardSearch;
window.plyrPlaylist = plyrPlaylist;

Alpine.start();
