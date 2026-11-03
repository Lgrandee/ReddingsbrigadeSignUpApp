document.addEventListener('DOMContentLoaded', () => {
	const toggle = document.querySelector('#navbar-toggle');
	const menu = document.querySelector('#navbar-menu');

	if (!toggle || !menu) {
		return;
	}

	toggle.addEventListener('click', () => {
		const isExpanded = toggle.getAttribute('aria-expanded') === 'true';

		toggle.setAttribute('aria-expanded', String(!isExpanded));
		menu.classList.toggle('hidden', isExpanded);
	});
});
