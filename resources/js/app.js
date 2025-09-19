import './bootstrap';
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import 'boxicons';
import 'boxicons/css/boxicons.min.css';

import './patient';

window.Alpine = Alpine;

// Plugin Alpine.js
Alpine.plugin(persist);

Alpine.start();