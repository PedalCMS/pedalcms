(function () {
	class ElementToggleTrigger {
		constructor(source) {
			this.trigger = source;
			this.target = document.getElementById(source.getAttribute('data-target'));

			if (this.target) {
				this.trigger.addEventListener('click', this.handleEvent);
			}
		}

		handleEvent(event) {
			event.preventDefault();

			const trigger = new ElementToggleTrigger(this);
			trigger.toggle();
		}

		toggle() {
			if (this.target.hidden) {
				this.show();
			} else {
				this.hide();
			}
		}

		show() {
			const target = this.target;

			this.trigger.setAttribute('aria-expanded', 'true');
			target.removeAttribute('hidden');
			target.style.height = 'auto';

			const height = target.clientHeight + 'px';

			target.style.height = '0px';

			window.setTimeout(function () {
				target.style.height = height;
			}, 0);
		}

		hide() {
			const target = this.target;

			this.trigger.setAttribute('aria-expanded', 'false');
			target.style.height = '0px';

			target.addEventListener(
				'transitionend',
				() => target.setAttribute('hidden', ''),
				{
					once: true,
				}
			);
		}
	}

	function nvisInit() {
		initToggles();
		initScrollSticky();
	}

	function initToggles() {
		document
			.querySelectorAll('.nvis-toggle__trigger')
			.forEach((el) => new ElementToggleTrigger(el));
	}

	function initScrollSticky() {
		const observer = new IntersectionObserver(
			([e]) => {
				const stuckClass = 'stuck';

				if (e.target.getBoundingClientRect().top === -1) {
					e.target.classList.add(stuckClass);
				} else {
					e.target.classList.remove(stuckClass);
				}
			},
			{ threshold: [1] }
		);

		document
			.querySelectorAll('.nvis-sticky')
			.forEach((el) => observer.observe(el));
	}

	window.addEventListener('load', nvisInit);
})();
