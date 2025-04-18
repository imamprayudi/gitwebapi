// import 'dotenv/config';
import $ from 'jquery/dist/jquery.slim.js';
// const $ = require('jquery');
import css from './style.css';
import { main } from '../assets_v2/js/nice_main.js';
import { fontawesome } from '@fortawesome/fontawesome-free/js/fontawesome.js';
// import { validate } from '../template/utama/assets/vendor/php-email-form/validate';

import { select2 } from '../node_modules/select2/dist/js/select2.full.min.js';
import { Swal } from '../node_modules/sweetalert2/dist/sweetalert2.min.js';
import '../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js';

// const apiExternal = process.env.EXTERNAL_API_URL;
// require('dotenv').config();
$(function () {

    // Filter By Selection
    let allowFilter = ['Transmission Date', 'PO No', 'Part No'];
    let filterBy = '';
    $.each(allowFilter, function (i, o) {
        let trans = o.toLowerCase().toString().replace(' ', '');
        if (o == "Transmission Date") {
            trans = "rdate";
        }
        filterBy += '<option value="' + trans + '">' + o + '</option>';
    });
    $('#filter_by')
        .find('option')
        .remove()
        .end()
        .append(filterBy);
    // End Of Filter By Selection
    // --------------------------

})
// const axios = require('axios');


