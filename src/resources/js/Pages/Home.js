import { Head } from '@inertiajs/vue3';
import { computed, defineComponent, h } from 'vue';

const quickNotes = [
    'Laravel remains responsible for routing, validation, queues, and persistence.',
    'Inertia will drive the application shell and page transitions.',
    'The REST API layer can evolve later without rewriting the web interface.',
];

export default defineComponent({
    name: 'HomePage',
    props: {
        appName: {
            type: String,
            default: 'Newganizze',
        },
    },
    setup(props) {
        const title = computed(() => `${props.appName} | Financial clarity`);

        return () =>
            h('div', { class: 'min-h-screen bg-[radial-gradient(circle_at_top,_rgba(245,158,11,0.18),_transparent_28%),linear-gradient(180deg,_#0c0a09_0%,_#1c1917_45%,_#0c0a09_100%)]' }, [
                h(Head, { title: title.value }),
                h('main', { class: 'mx-auto flex min-h-screen w-full max-w-6xl flex-col justify-between gap-12 px-6 py-10 lg:px-10 lg:py-16' }, [
                    h('section', { class: 'grid gap-10 lg:grid-cols-[minmax(0,1.15fr)_minmax(320px,0.85fr)] lg:items-end' }, [
                        h('div', { class: 'space-y-6' }, [
                            h('span', { class: 'inline-flex rounded-full border border-amber-400/30 bg-amber-300/10 px-3 py-1 text-xs font-medium uppercase tracking-[0.28em] text-amber-200' }, 'Laravel + Inertia + Vue'),
                            h('div', { class: 'space-y-4' }, [
                                h('h1', { class: 'max-w-3xl text-4xl font-semibold tracking-tight text-stone-50 sm:text-5xl lg:text-6xl' }, [
                                    'The web app shell is now ready for',
                                    h('span', { class: 'block text-amber-300' }, 'Inertia-driven product features.'),
                                ]),
                                h('p', { class: 'max-w-2xl text-base leading-7 text-stone-300 sm:text-lg' }, 'This project is now serving the frontend through Vue components rendered by Inertia, keeping Laravel in control of backend concerns while preparing the ground for the next feature commits.'),
                            ]),
                        ]),
                        h('div', { class: 'rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-2xl shadow-amber-950/20 backdrop-blur' }, [
                            h('p', { class: 'text-sm font-medium uppercase tracking-[0.24em] text-stone-400' }, 'Current status'),
                            h('div', { class: 'mt-6 space-y-4' }, quickNotes.map((note, index) =>
                                h('div', { class: 'flex gap-4', key: `note-${index}` }, [
                                    h('span', { class: 'mt-1 inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full border border-amber-300/40 text-sm text-amber-200' }, String(index + 1).padStart(2, '0')),
                                    h('p', { class: 'text-sm leading-6 text-stone-300' }, note),
                                ])
                            )),
                        ]),
                    ]),
                    h('section', { class: 'grid gap-4 border-t border-white/10 pt-6 text-sm text-stone-400 sm:grid-cols-3' }, [
                        h('div', { class: 'rounded-2xl border border-white/10 bg-black/10 p-4' }, [
                            h('p', { class: 'font-medium text-stone-200' }, 'Server rendering entry'),
                            h('p', { class: 'mt-2 leading-6' }, 'Laravel routes now return Inertia responses instead of the default Blade welcome page.'),
                        ]),
                        h('div', { class: 'rounded-2xl border border-white/10 bg-black/10 p-4' }, [
                            h('p', { class: 'font-medium text-stone-200' }, 'Frontend runtime'),
                            h('p', { class: 'mt-2 leading-6' }, 'Vue is mounted through createInertiaApp, ready to receive real pages and layouts in the next commits.'),
                        ]),
                        h('div', { class: 'rounded-2xl border border-white/10 bg-black/10 p-4' }, [
                            h('p', { class: 'font-medium text-stone-200' }, 'Future API path'),
                            h('p', { class: 'mt-2 leading-6' }, 'The web shell can evolve independently while the mobile REST surface is introduced in dedicated backend commits.'),
                        ]),
                    ]),
                ]),
            ]);
    },
});