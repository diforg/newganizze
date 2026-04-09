import './bootstrap';
import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { createApp, h } from 'vue';

createInertiaApp({
	resolve: (name) => {
		const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
		const page = pages[`./Pages/${name}.vue`];

		if (!page) {
			throw new Error(`Unknown Inertia page: ${name}`);
		}

		return page.default;
	},
	setup({ el, App, props, plugin }) {
		createApp({ render: () => h(App, props) })
			.use(plugin)
			.mount(el);
	},
	progress: {
		color: '#111827',
	},
});
