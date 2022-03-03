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
			if (!this.target) {
				return false;
			}

			if (this.target.hidden) {
				return this.show();
			}
			return this.hide();
		}

		show() {
			if (!this.target) {
				return false;
			}

			const target = this.target;

			this.trigger.setAttribute('aria-expanded', 'true');
			target.removeAttribute('hidden');
			target.style.height = 'auto';

			const height = target.clientHeight + 'px';

			target.style.height = '0px';

			window.setTimeout(() => (target.style.height = height), 0);

			target.addEventListener(
				'transitionend',
				() => (target.style.overflow = 'visible'),
				{
					once: true,
				}
			);
		}

		hide() {
			if (!this.target) {
				return false;
			}

			const target = this.target;

			this.trigger.setAttribute('aria-expanded', 'false');
			target.style.height = '0px';
			target.style.overflow = 'hidden';

			target.addEventListener(
				'transitionend',
				() => target.setAttribute('hidden', ''),
				{
					once: true,
				}
			);

			return true;
		}
	}

	function nvisInit() {
		initToggles();
		initScrollSticky();
		maybeToggleHiddenFilters();
	}

	function initToggles() {
		document
			.querySelectorAll('.nvis-toggle__trigger')
			.forEach((el) => new ElementToggleTrigger(el));
	}

	function initScrollSticky() {
		const stickySelector = '.nvis-sticky';

		updateStickyElements();

		const observer = new IntersectionObserver(updateStickyElements, {
			threshold: [1],
		});

		document
			.querySelectorAll(stickySelector)
			.forEach((el) => observer.observe(el));
	}

	function updateStickyElements() {
		const stickySelector = '.nvis-sticky',
			stuckClass = 'stuck';

		document.querySelectorAll(stickySelector).forEach((el) => {
			if (el.getBoundingClientRect().top < 0) {
				el.classList.add(stuckClass);
			} else {
				el.classList.remove(stuckClass);
			}
		});
	}

	function maybeToggleHiddenFilters() {
		const id = 'more-filters';
		const triggerSelector = `.nvis-toggle__trigger[data-target="${id}"]`;
		const moreFilters = document.getElementById(id);

		if (!moreFilters) {
			return false;
		}

		const filters = [
			...moreFilters.querySelectorAll('select'),
			...moreFilters.querySelectorAll('input'),
		];
		const toggleButton = document.querySelector(triggerSelector);

		if (!(toggleButton && filters.length)) {
			return false;
		}

		const params = new URLSearchParams(window.location.search);

		filters.forEach((f) => {
			if (params.get(f.name)) {
				const trigger = new ElementToggleTrigger(toggleButton);
				return trigger.show();
			}
		});

		return false;
	}

	window.addEventListener('load', nvisInit);
})();
