var validationErrors = {};

function renderErrors() {
	$('.errors').html('');
	$('.input-error').removeClass('input-error');
	if(Object.keys(validationErrors).length == 0) {
		$('.errors').hide();
		$('input[type=submit]').prop('disabled', false);
	}
	else {
		$.each(validationErrors, function(i, val) {
			$('.errors').append(val + '<br>');
			$('#' + i).addClass('input-error');
		});
		$('.errors').show();
		$('input[type=submit]').prop('disabled', true);
	}
}

$(document).ready(function() {

	$('.datatable').DataTable();

	$('img').mouseover(function() {
		var size = $(this).get(0).naturalWidth + "x" + $(this).get(0).naturalHeight;
		var alt = $(this).attr('alt');
		$(this).attr('title', size + " - " + alt);
	});

	$.get('xml_json/drzave.json', function(data) {
		$('#drzava').autocomplete({
			source: data
		});
	});

	$('#pozivni-broj-ucitaj').click(function() {
		$.get('xml_json/drzave-brojevi.json', function(data) {
			$.each(data, function(i, val) {
				if(i == $('#drzava').val()) {
					$('#pozivni-broj').append('<option selected value="' + val + '">'+val+' - '+i+'</option>');
				}
				else {
					$('#pozivni-broj').append('<option value="' + val + '">'+val+' - '+i+'</option>');
				}
			});
			$('#pozivni-broj').show();
			$('#pozivni-broj-ucitaj').hide();
		});
	});


	$('form').submit(function(event) {
		$('input, textarea').each(function(i,el) {
			el.dispatchEvent(new KeyboardEvent('keyup',{'key':13}));
			renderErrors();
		});
		if(Object.keys(validationErrors).length != 0) {
			event.preventDefault();
		}
	});

	$('#ime, #prezime').keyup(function() {
		if($('#ime').val() != "" && $('#prezime').val() != "") {
			$("#korisnicko-ime-registracija").prop('disabled', false);
		}
		else {
			$("#korisnicko-ime-registracija").prop('disabled', true);
		}

		var patt = new RegExp(/^[A-Z]+.*/g);
		if(patt.test($(this).val()) == false) {
			validationErrors[$(this).attr('id')] = 'Vaše ' + $(this).attr('id') + ' mora početi velikim početnim slovom.';
		}
		else {
			delete validationErrors[$(this).attr('id')];
		}
		renderErrors();
	});

	$('#lozinka-registracija').keyup(function() {
		if($(this).val() == "") {
			$("#lozinka-potvrda").prop('disabled', true);
		}
		else {
			$("#lozinka-potvrda").prop('disabled', false);
		}

		var patt = new RegExp(/^(?=(?:.*[a-z]){2,})(?=(?:.*[A-Z]){2,})(?=(?:.*[0-9]){1,})\S{5,15}$/);
		if(patt.test($(this).val()) == false) {
			validationErrors[$(this).attr('id')] = 'Vaša zaporka mora sadržavati minimalno 2 velika, 2 mala slova i 1 broj te mora biti duljine od 5 do 15 znakova.';
		}
		else {
			delete validationErrors[$(this).attr('id')];
		}
		renderErrors();
	});

	$('#lozinka-potvrda').keyup(function() {
		if($(this).val() != $('#lozinka-registracija').val()) {
			validationErrors['lozinka-potvrda'] = 'Vaša potvrda lozinke ne odgovara orginalnoj lozinki.';
		}
		else {
			delete validationErrors['lozinka-potvrda'];
		}
		renderErrors();
	});


	$('#korisnicko-ime-registracija').blur(function() {
		$.get('http://barka.foi.hr/WebDiP/2016/materijali/zadace/dz3/korisnikImePrezime.php', {
			ime: $('#ime').val(),
			prezime: $('#prezime').val()
		}, function(data) {
			var username = $(data).find('korisnicko_ime').text();
			if(username != 0) {
				$("#korisnicko-ime-registracija").val(username);
			}
		});
	});

});