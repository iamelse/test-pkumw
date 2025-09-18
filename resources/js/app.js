import './bootstrap';
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist'
import 'boxicons';
import 'boxicons/css/boxicons.min.css';
import { initFlowbite } from 'flowbite';

window.Alpine = Alpine;

Alpine.plugin(persist);
Alpine.start();

window.addEventListener('load', initFlowbite);