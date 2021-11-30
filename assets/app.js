import './styles/app.scss';

import './bootstrap';

const $ = require('jquery');
global.$ = global.jQuery = $;

require('bootstrap');

$('[data-toggle="popover"]');

/*$('.js-datepicker').datepicker({
    format: 'MM/dd/yyyy'
});*/

import './js/timer.js';

//import './js/components/Domains.js';
