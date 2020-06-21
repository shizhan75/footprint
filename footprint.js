function setData(data) {
	$('#footprintname').val($('#keyword').val());
	$('#fullname').val(data.formatted_address);
	$('#province').val(data.province);
	$('#latitude').val(data.lat.toFixed(2));
	$('#longitude').val(data.lng.toFixed(2));

	$('#dropdown').hide();
	$('#detail').show();
	$('#time').focus();
}

function search() {
	var keyword = $('#keyword').val();
	$.getJSON('api/geocoding.php', {
	//$.getJSON('http://139.59.100.163/geocoding.php', {
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
			province = data.province,
			footprint = data.footprint,
			time = data.time,
			description = data.description,
			id = data.id;

	tbody.append('<tr><td>'+province+'<\/td><td>'+footprint+'<\/td><td>'+time+'<\/td><td>'+description+'<\/td><td><button type="button" class="linkDelete btn btn-default btn-xs" aria-label="Delete" id="'+id+'"><span class="glyphicon glyphicon-remove" aria-hidden="true"><\/span><\/button><\/td>');
}

function submit() {
	$.post('api/footprint/insert.php', {
		username: $('#username').val(),
		footprint: $('#footprintname').val(),
		lat: $('#latitude').val(),
		lng: $('#longitude').val(),
		province: $('#province').val(),
		time: $('#time').val(),
		description: $('#description').val()
	}).done(function(data) {
		if (data.status === 'success') {
			insertNewData(data);
			resetForm();
		}
	});
}

function resetForm() {
	$('form')[0].reset();
	$('#keyword').focus();
	$('#detail').hide();
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

	/*$('#keyword').on('input', function() {
		console.log($('#keyword').val());
	})
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

	$('#btnAddFootprint').click(function() {
		$('#divAddFootprint').hide();
		$('#addFootprint').show();

		$('body,html').animate({scrollTop:0}, 1000);
		$('#keyword').focus();
    return false;
	});

	$('#tableData').on('click', '.linkDelete', function() {
		var cur = $(this);
		var row = cur.parent().parent();
		$.getJSON('api/footprint/delete.php', {
			username: $('#username').val(),
			id: cur.attr('id')
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