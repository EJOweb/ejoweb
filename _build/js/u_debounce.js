//* Wait a couple of miniseconds before action. Useful to prevent multiple triggers on resize
//* Underscore-framework functionality
u_debounce = function(func, wait, immediate) {
	var timeout, args, context, timestamp, result;

	var later = function() {
		var last = u_now() - timestamp;

		if (last < wait && last > 0) {
			timeout = setTimeout(later, wait - last);
		} else {
			timeout = null;
			if (!immediate) {
				result = func.apply(context, args);
				if (!timeout) context = args = null;
			}
		}
	};

	return function() {
		context = this;
		args = arguments;
		timestamp = u_now();
		var callNow = immediate && !timeout;
		if (!timeout) timeout = setTimeout(later, wait);
		if (callNow) {
			result = func.apply(context, args);
			context = args = null;
		}

		return result;
	};
};

//* Calculate now
//* Underscore-framework functionality
u_now = Date.now || function() {
	return new Date().getTime();
};