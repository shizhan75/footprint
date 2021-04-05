function parseCountry(name) {
	const MAP_COUNTRY = {
		'china': 'china',
		'中国': 'china',
		'japan': 'japan',
		'日本': 'japan',
	};
	name = name.toLowerCase();
	return MAP_COUNTRY[name];
}

function onCountryChange(value) {
	let country = parseCountry(value);
	$('.div-province').hide();
	$('.input-province').val('');
	if (country === 'china') {
		$('#div-province-china').show();
	} else if (country === 'japan') {
		$('#div-province-japan').show();
	} else {
		$('#div-province-others').show();
	}
}

function setData(data) {
	$('#footprintname').val($('#keyword').val());
	$('#fullname').val(data.formatted_address);
	$('#country').val(data.country);
	onCountryChange(data.country);
	$('.input-province').val(data.province);
	$('#latitude').val(data.lat.toFixed(2));
	$('#longitude').val(data.lng.toFixed(2));

	$('#dropdown').hide();
	$('#detail').show();
	$('#time').focus();
}

function search() {
	var keyword = $('#keyword').val();
	$.getJSON('api/geocoding.php', {
		keyword: keyword
	}).done(function(data) {
		if (data.length <= 0) return;
		if (data.length === 1) {
			setData(data[0]);
		} else {
			$('#dropdown').html('');
			for (var i = 0; i < data.length; i++) {
				$('#dropdown').append('<li><a href="#">'+data[i].formatted_address+'<\/a><\/li>');
				$('#dropdown>li:last-child>a').click((function(j) {
					return (function() {
						setData(data[j]);
					})
				})(i));
			}
			$('#dropdown').show();
		}
	});
}

function insertNewData(data) {
	var tbody = $('#tableData>tbody'),
			country = data.country,
			province = data.province,
			footprint = data.footprint,
			time = data.time,
			description = data.description,
			id = data.id;

	tbody.append(`
		<tr>
			<td>${country}</td>
			<td>${province}</td>
			<td>${footprint}</td>
			<td>${time}</td>
			<td>${description}</td>
			<td>
				<button type="button" class="linkEdit btn btn-default btn-xs" aria-label="Edit" record-id="${id}">
					<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
				</button>
				<button type="button" class="linkDelete btn btn-default btn-xs" aria-label="Delete" record-id="${id}">
					<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
				</button>
			</td>
		</tr>
	`);
}

function submit() {
	let args = {
		username: $('#username').val(),
		footprint: $('#footprintname').val(),
		lat: $('#latitude').val(),
		lng: $('#longitude').val(),
		country: $('#country').val(),
		province: $('.input-province:visible').val(),
		time: $('#time').val(),
		description: $('#description').val()
	};
	if ($('#recordId').val().length > 0) {
		args.id = $('#recordId').val();
	}
	$.post('api/footprint/insert.php', args).done(function(data) {
		console.info(data);
		if (data.status === 'success') {
			$(`#tableData .linkDelete[record-id=${data.id}]`).parent().parent().remove();
			insertNewData(data);
			resetForm();
			$('#keyword').focus();
		}
	});
}

function resetForm() {
	$('form')[0].reset();
	$('#recordId').val("");
	$('#detail').hide();
}

function setForm(data) {
	$('#recordId').val(data.id);
	$('#fullname').val('');
	$('#footprintname').val(data.footprint);
	$('#latitude').val(data.lat);
	$('#longitude').val(data.lng);
	$('#country').val(data.country);
	onCountryChange(data.country);
	$('.input-province:visible').val(data.province);
	$('#time').val(data.time);
	$('#description').val(data.description);
}

$(function() {

	$('#keyword').blur(function() {
		$('#dropdown').hide();
	});

	$('#keyword').on('keypress',function(event) {
		if(event.keyCode === 13) {
			$('#keyword').blur();
      $('#btnSearch').trigger('click');
    }
	 });
	 
	$('#country').on('change',function(event) {
		onCountryChange(event.target.value);
 	});

	/*
	//for ie
	if(document.all){
    $('input[type="text"]').each(function() {
      var that = this;
      if(this.attachEvent) {
        this.attachEvent('onpropertychange', function(e) {
          if(e.propertyName != 'value') return;
          $(that).trigger('input');
        });
      }
    })
	}*/

	$('#btnSearch').click(function() {
		search();
		return false;
	});

	$('#btnSubmit').click(function() {
		submit();
		return false;
	});

	$('#btnCancel').click(function() {
		$('#divAddFootprint').show();
		$('#addFootprint').hide();
		resetForm();
		return false;
	});

	$('#btnAddFootprint').click(function() {
		$('#divAddFootprint').hide();
		$('#addFootprint').show();
		$('#keyword').focus();
    return false;
	});

	$('#tableData').on('click', '.linkEdit', function() {
		var cur = $(this);
		var row = cur.parent().parent();
		$.getJSON('api/footprint/query.php', {
			id: cur.attr('record-id')
		}).done(function(data) {
			if (data.length === 0) {
				console.info('Fetch record data failed!');
				return;
			}
			$('#divAddFootprint').hide();
			$('#addFootprint').show();
			$('#dropdown').hide();
			$('#detail').show();
			setForm(data[0]);
		});
		return false;
	});

	$('#tableData').on('click', '.linkDelete', function() {
		var cur = $(this);
		var row = cur.parent().parent();
		$.getJSON('api/footprint/delete.php', {
			username: $('#username').val(),
			id: cur.attr('record-id')
		}).done(function(data) {
			if (data.status === 'success') {
				row.remove();
			}
		});
		return false;
	});

	$('#addFootprint').hide();
	$('#detail').hide();
});