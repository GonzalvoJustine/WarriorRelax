/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import App from './js/App';

ReactDOM.render(<Router><App /></Router>, document.getElementById('root'));

/*import Swiper, { Navigation, Pagination } from 'swiper';

new Swiper('.my-swiper', {
    // pass modules here
    modules: [Navigation, Pagination],
    // ...
});*/
