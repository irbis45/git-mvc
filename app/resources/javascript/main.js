$(document).ready(function () {

	$('#datetimepicker1').datetimepicker();
	$('#datetimepicker2').datetimepicker();


	if( $('table >tbody >tr').length > 0 ) {
		$("table").tablesorter(
			{
				widgets: ['zebra']
			}
		).tablesorterPager(
			{
				container: $("#pager")
			});
	}
	$(".pagesize :last").attr("selected", "selected");


	const readImage = ( input ) => {
		if( input.files && input.files[0] ) {
			const reader = new FileReader();

			reader.onload = function ( e ) {
				$('#preview').attr('src', e.target.result);
			};

			reader.readAsDataURL(input.files[0]);
		}
	};
	$('#image').on('change', function () {
		readImage(this);
	});



	$('.js-logout').on('click', function () {

		fetch(window.location.origin + '/login/logout', {
			method     : 'post',
			headers    : {
				"Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
			},
			body       : {},
			credentials: 'same-origin'

		})
			.then(() => {
				location.reload();
			})
			.catch(error =>
				console.log('Request failed', error)
			);

		return false;
	});

	$(document).on('click', '.js-task-complete', function ( e ) {
		e.preventDefault();

		const taskId = $(this).attr('data-task-id');
		$('.js-msg-main').text('').hide('slow');

		$.ajax({
			type   : 'POST',
			url    : window.location.origin + '/dashboard/mark_completed',
			data   : {
				task_id: taskId
			},
			success: data => {

				if( data.msg ) {
					$('.js-msg-main').html(data.msg).show('slow');
					$(this).closest('tr').find(".js-status").text(data.msg);

					let noComplete = data.msg.search(/^Not\s/i);
					let reverse    = '';

					if( noComplete === 0 ) {

						reverse = data.msg.replace(/^Not\s/i, "");
					} else {
						reverse = "Not " + data.msg;
					}

					$(this).text(reverse);

				} else if( data.err ) {
					$('.js-msg-main').html(data.err).show('slow');
				} else {
					$('.js-msg-main').html('Server error').show('slow');
				}
			},
			error  : err => {
				console.log(err);
			}
		});
		return false;
	});


	$(document).on('click', '.js-task-delete', function ( e ) {
		e.preventDefault();

		const taskId = $(this).attr('data-task-id');
		$('.js-msg-main').text('').hide('slow');


		$.ajax({
			type   : 'POST',
			url    : window.location.origin + '/dashboard/delete_task',
			data   : {
				task_id: taskId
			},
			success: data => {
				if( data.msg ) {
					$('.js-msg-main').html(data.msg).show('slow');

					if( data.refresh ) {
						setTimeout(() => {
							location.reload()
						}, 1000)
					}
				} else if( data.err ) {
					$('.js-msg-main').html(data.err).show('slow');
				} else {
					$('.js-msg-main').html('Server error').show('slow');
				}
			},
			error  : err => {
				console.log(err);
			}
		});
		return false;
	});


	$(document).on('submit', '.js-form-task', function ( e ) {
		e.preventDefault();

		const form     = $(this).closest('form'),
		      formData = new FormData(this);
		let isCreate   = true;

		let action = '/dashboard/add_new_task';

		if( form.find('.js-hidden-type').val() === 'update' ) {
			action   = '/dashboard/edit_task';
			isCreate = false;
		}

		$.ajax({
			type       : 'POST',
			url        : window.location.origin + action,
			data       : formData,
			cache      : false,
			contentType: false,
			processData: false,
			success    : data => {

				if( data.msg ) {
					form.find('.js-msg').html(data.msg).show('slow');
					form[0].reset();

					if( isCreate ) {
						let html           = '';
						const status       = data.task.task_completed ? 'Completed' : 'Not completed';
						const status_ivert = !data.task.task_completed ? 'Completed' : 'Not completed';

						html += '<tr data-id="' + data.task.task_id + '">';
						html += '<td class="js-task-image task-image"><img src="' + data.task.image + '" alt=""/></td>';
						html += '<td>' + data.task.user_name + '</td><td>' + data.task.user_email + '</td>';
						html += '<td class="js-task-name">' + data.task.task_name + '</td>';
						html += '<td class="js-status">' + status + '</td>';
						html += '<td><button type="button" class="js-show-modal-task custom-a-btn" data-action="update" data-toggle="modal" data-task-id="' + data.task.task_id + '" data-target="#formTask">Edit</button><br/>';
						html += '<a href="" data-task-id="' + data.task.task_id + '" class="js-task-delete">Delete</a><br/>';
						html += '<a href="" role="button" data-task-id="' + data.task.task_id + '" class="js-task-complete">' + status_ivert + '</a></td>';
						html += '</tr>';

						$('table >tbody').append(html);

					} else {

						const row = $('tr[data-id="' + data.task.task_id + '"]');
						row.find('.js-task-name').text(data.task.task_name);
						row.find('.js-task-image > img').attr('src', data.task.image);
					}

					setTimeout(() => {
						$('#formTask').modal('hide');
					}, 2000)
				} else if( data.err ) {
					form.find('.js-msg').html(data.err).show('slow');
				} else {
					form.find('.js-msg').html('Server error').show('slow');
					return false;
				}

			},
			error      : err => {
				console.log(err);
			}
		});
		return false;
	});

	const FillForm = ( taskId, is_row = false ) => {
		$.ajax({
			type   : 'POST',
			url    : window.location.origin + '/dashboard/get_task',
			data   : {
				task_id: taskId
			},
			success: data => {

				if( data.data ) {
					if( is_row ) {

					} else {
						const form = $('#formTask');
						form.find('.js-field-name').val(data.data.task_name);
						form.find('.js-field-dsc').val(data.data.description);

						form.find('.js-field-priority :nth-child(' + (data.data.task_priority + 1) + ')').prop('selected', true);
						form.find('.js-field-deadline').val(data.data.task_deadline);
					}

				}
			},
			error  : err => {
				console.log(err);
			}
		});
	};


	$(document).on('click', '.js-show-modal-task', function () {

		$('.js-msg').hide('slow');
		$('#preview').attr('src', '');
		$('.js-msg-main').text('').hide('slow');
		$('.js-form-task')[0].reset();

		if( $(this).attr('data-action') === "update" ) {
			FillForm($(this).attr('data-task-id'));
		}

		$('.form').find('.js-hidden-type').val($(this).attr('data-action'));
		$('.form').find('.js-hidden-task-id').val($(this).attr('data-task-id'));
		return true;
	});

});
