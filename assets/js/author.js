import '../css/author.css';
import $ from 'jquery';

// datepicker
import 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'
import 'bootstrap-datepicker/dist/js/bootstrap-datepicker.min';

$(document).ready(function () {
    $('.js-datepicker').datepicker()
})

// select2
import 'select2/dist/css/select2.min.css';
import 'select2/dist/js/select2.min';
$('select').select2()

console.log('bonjour');