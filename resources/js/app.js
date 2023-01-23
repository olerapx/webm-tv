import './bootstrap';

import Alpine from 'alpinejs';

import plyr from "plyr";
import "plyr/dist/plyr.css"

import boardSearch from "./board-search";
import "./player"
import plyrPlaylist from "./playlist.js";
import "../css/player.css"

window.Alpine = Alpine;
window.boardSearch = boardSearch;
window.plyr = plyr;
window.plyrPlaylist = plyrPlaylist;

Alpine.start();
