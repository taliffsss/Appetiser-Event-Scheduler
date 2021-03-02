require('./bootstrap');

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';

function calendarView() {
	let calendarEl = document.querySelector('#calendar');

	let calendar = new Calendar(calendarEl, {
		plugins: [ dayGridPlugin, timeGridPlugin, listPlugin ],
		initialView: 'dayGridMonth',
		headerToolbar: {
			right: 'prev,next today',
		},
		eventSources: [
	        {
	            url: '/event/list',
	            success: function() {
	                
	            },
	            failure: function() {
	                console.log('there was an error while fetching events!');
	            }
	        }
	    ],
	});

	calendar.render();
}

let defaultValue = moment().format('MM/DD/Y') + ' - ' + moment().format('MM/DD/Y');

document.addEventListener('DOMContentLoaded', function() {

	calendarView();

	// Date Range Picker
	$('input[name="daterangepicker"]').daterangepicker();

	let days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

	let html = '';

	for (const v of days) {
	    html += '<div class="form-check form-check-inline">';
	    html += '<input class="form-check-input" type="checkbox" name="days[]" value="'+v+'" id="'+v+'">';
	    html += '<label class="form-check-label mr-2" for="'+v+'">'+v+'</label>';
	    html += '</div>';
	}

	document.querySelector('.days-section').innerHTML = html;
});

let toasts = document.querySelector('.toast');
let toaster = new bootstrap.Toast(toasts);//inizialize it

$(document).on('submit','.event-form', (e) => {
	e.preventDefault();
	_formAjaxAsync('.event-form');
})

function _formAjaxAsync(attr) {
    
    var f = $(attr);
    var b = f.find('button[type=submit]');
    var t = b.text();

    var formData = new FormData(f[0]);

    $.ajax({
        type: f.attr('method'),
        url: f.attr('action'),
        data: formData,
        dataType: 'json',
        async: true,
        cache: false,
        contentType:false,
        processData:false,
        beforeSend: function() {

        	f.find('span.error-text').text('');

            b.attr('disabled', true);

            b.text('loading...');

            toaster.hide();
        },
        success: function(res) {

        	$('.toast-header').addClass(res.bgClass);
        	$('.toast-title').html(res.toastHeader);
        	$('.text-msg').html(res.message);

            if (res.success == true) {
            	calendarView();

                f[0].reset();

                $('#daterangepicker').val(defaultValue);
                
                toaster.show();
            } else {
                $.each(res.error, function(k, v) {
                	f.find('span.'+k+'-error').text(v[0]);
                })
            }

            $('input[name="_token"]').val(res.csrf_token)
        },
        complete: function(res) {
            b.removeAttr('disabled').text(t);
        }
    });

    return false;
}