let slider = {
	timer: "",
	n: 0,
	slide: function() {
		let width = document.querySelector("#slider .slide").offsetWidth + 20;
		
		let count = document.querySelectorAll("#slider .slide").length;
		count = 3;

		if(slider.n >= count) slider.n = 0;
		else if(slider.n < 0) slider.n = count - 1;

		document.querySelector("#slider .slides").style.left = `-${width * slider.n}px`;

		clearTimeout(slider.timer);

		slider.timer = setTimeout(() => slider.slide(++slider.n), 3000);
	}
} slider.slide(slider.n);