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

	class ToggleTip {
		static msgAttribute = 'data-toggletip-content';
		static activeAttribute = 'data-active';
		bubbleClass = 'toggletip__tip';
		toggle = null;
		message = '';
		liveRegion = null;

		constructor(toggle) {
			this.message = toggle.getAttribute(ToggleTip.msgAttribute);
			this.liveRegion = toggle.nextElementSibling;
			this.toggle = toggle;

			document.addEventListener('click', ToggleTip.handleEvent);
			document.addEventListener('blur', ToggleTip.handleEvent);
			document.addEventListener('keyup', ToggleTip.handleEvent);
		}

		static handleEvent(event) {
			const active = ToggleTip.getActive();

			if (
				event.type === 'click' &&
				event.target.getAttribute(ToggleTip.msgAttribute)
			) {
				const toggle = new ToggleTip(event.target);

				if (active) {
					active.hide();
				}

				toggle.show();
				event.preventDefault();
				return;
			}

			if (!active) {
				return;
			}

			if (event.type === 'keyup' && event.code === 'Escape') {
				active.hide();
				event.preventDefault();
				return;
			}

			if (event.type === 'click' || event.type === 'blur') {
				if (typeof window.toggleTipDebug === 'undefined') {
					active.hide();
					event.preventDefault();
				}
			}
		}

		static getActive() {
			const el = document.querySelector(
				`button[${ToggleTip.msgAttribute}][${ToggleTip.activeAttribute}]`
			);

			if (el) {
				return new ToggleTip(el);
			}

			return null;
		}

		setActive(isActive) {
			if (isActive) {
				this.toggle.setAttribute(ToggleTip.activeAttribute, '');
			} else {
				this.toggle.removeAttribute(ToggleTip.activeAttribute);
			}
		}

		show() {
			const contents = `<span class="${this.bubbleClass}">${this.message}</span>`;
			const r = this.liveRegion;

			this.hide();

			this.setActive(true);
			window.setTimeout(() => (r.innerHTML = contents), 100);
		}

		hide() {
			this.setActive(false);
			this.liveRegion.innerHTML = '';
		}
	}

	function nvisInit() {
		initToggles();
		initToggleTips();
		initScrollSticky();
		maybeToggleHiddenFilters();
	}

	function initToggles() {
		document
			.querySelectorAll('.nvis-toggle__trigger')
			.forEach((el) => new ElementToggleTrigger(el));
	}

	function initToggleTips() {
		document
			.querySelectorAll(`button[${ToggleTip.msgAttribute}]`)
			.forEach((el) => new ToggleTip(el));
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
