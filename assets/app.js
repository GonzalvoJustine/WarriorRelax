import './styles/app.scss';

import './bootstrap';

const $ = require('jquery');

require('bootstrap');

$('[data-toggle="popover"]');

$('#categories').lightSlider({
    item:4,
    loop:false,
    slideMove:2,
    easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
    speed:600,
    responsive : [
        {
            breakpoint:800,
            settings: {
                item:3,
                slideMove:1,
                slideMargin:6,
            }
        },
        {
            breakpoint:480,
            settings: {
                item:2,
                slideMove:1
            }
        }
    ]
});

/*$('.js-datepicker').datepicker({
    format: 'MM/dd/yyyy'
});*/

import './js/timer.js';

import './js/components/Domains.js';
