var expired = false;
var validationMessages = {};

window.$ = document.querySelectorAll.bind(document);

function ready(fn) {
  if (document.readyState != 'loading'){
    fn();
  } else {
    document.addEventListener('DOMContentLoaded', fn);
  }
}

function getPlainName(name) {
	return name.split(':')[1];
}

function displayErrors() {
	Array.prototype.forEach.call($('.error, .error-char'), function(el, i) {
		el.parentNode.removeChild(el);
	});
	Object.keys(validationMessages).forEach(function(key) {
		if($('input[name='+getPlainName(key)+'],textarea[name='+getPlainName(key)+']').length == 0) {
			parentNode = $('#'+getPlainName(key))[0];
		} else {
			var parentNode = $('input[name='+getPlainName(key)+'],textarea[name='+getPlainName(key)+']')[0].parentNode;
		}
		var error = document.createElement('p');
		error.className = "error";
		error.innerHTML = validationMessages[key];
		parentNode.appendChild(error);

		parentNode.getElementsByTagName('label')[0].innerHTML += '<span class="error-char">!</span>'
	});
}

function setFormExpirationTimer() {
	setTimeout(function() { expired = true; }, 60*5*1000);
}

function bindGlobalValidation() {
	Array.prototype.forEach.call($('input, textarea'), function(el, i) {
		el.addEventListener('keyup', function() {
			var patt = new RegExp(/^[^(){}'!#“\/\\]*$/g);
			if(patt.test(this.value) == false) {
				validationMessages['forbidden:' + this.name] = "Nije dozvoljeno koristiti sljedeće znakove:  ( ) { } ' ! # “ \\ /";
			}
			else {
				delete validationMessages['forbidden:' + this.name];
			}

			if(this.value.length == 0) {
				validationMessages['missing:' + this.name] = "Potrebno je ispuniti sva polja.";
			}
			else {
				delete validationMessages['missing:' + this.name];
			}
			displayErrors();
		});
	});
}

function bindNameValidation() {
	$('input[name=product-name]')[0].addEventListener('keyup', function() {
		if(this.value.length < 5) {
			validationMessages['char:' + this.name] = "Ime mora sadržavati minimalno 5 znakova.";
		}
		else {
			delete validationMessages['char:' + this.name];
		}
		displayErrors();
	});
}

function submitValidation(event) {
	if(expired) {
		$('#refresh')[0].className = "";
	}
	Array.prototype.forEach.call($('input, textarea'), function(el, i) {
		if(expired) {
			el.disabled = true;
		}

		el.dispatchEvent(new KeyboardEvent('keyup',{'key':13}));
	});

	var patt = new RegExp(/^\d{2}.\d{2}.\d{4}$/g);
	if(patt.test($('input[name=production-date]')[0].value) == false) {
		validationMessages['date:production-date'] = "Datum mora biti pravilnog formata (dd.mm.yyyy).";
	}
	else if (new Date( $('input[name=production-date]')[0].value.replace( /(\d{2}).(\d{2}).(\d{4})/, "$2/$1/$3") ) > new Date()) {
		validationMessages['date:production-date'] = "Datum ne smije biti u budućnosti.";
	}
	else {
		delete validationMessages['date:production-date'];
	}

	var patt = new RegExp(/(\s*[A-Z]+[A-Za-z,;'"\s]+[.?!]){3,}/g);
	if(patt.test($('textarea[name=product-description]')[0].value) == false) {
		validationMessages['sentence:product-description'] = "Opis mora sadržavati minimalno 3 rečenice.";
	}
	else {
		delete validationMessages['sentence:product-description'];
	}

	if($('#product-category input[type=checkbox]:checked').length == 0) {
		validationMessages['checked:product-category'] = "Mora biti odabrana barem jedna kategorija.";
	}
	else {
		delete validationMessages['checked:product-category'];
	}



	if(Object.keys(validationMessages).length != 0) {
		displayErrors();
		event.preventDefault();
	}
}


ready(function() {
	setFormExpirationTimer();

	$('#refresh')[0].onclick = function() {
		location.reload();
	};

	bindGlobalValidation();
	bindNameValidation();
	$("form")[0].addEventListener('submit', submitValidation);
});