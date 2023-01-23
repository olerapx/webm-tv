import './bootstrap';

import Alpine from 'alpinejs';
import boardSearch from "./board-search";
import videoJs from "video.js";
import "video.js/dist/video-js.min.css"
import "videojs-playlist";
import "videojs-playlist-ui";
import "videojs-playlist-ui/dist/videojs-playlist-ui.vertical.css"
import "./player"
import "../css/player.css"

window.Alpine = Alpine;
window.boardSearch = boardSearch;
window.videojs = videoJs;

Alpine.start();
