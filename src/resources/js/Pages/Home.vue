<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';

import AppShell from '../Layouts/AppShell.vue';

const props = defineProps({
    appName: {
        type: String,
        default: 'Newganizze',
    },
});

const title = computed(() => `${props.appName} | Financial clarity`);

const quickNotes = [
    'Laravel remains responsible for routing, validation, queues, and persistence.',
    'Inertia drives the application shell and page transitions through Vue components.',
    'The REST API layer can keep evolving for Flutter without rewriting the web interface.',
];

const statusCards = [
    {
        title: 'Server rendering entry',
        description: 'Laravel routes now return Inertia responses instead of the default Blade welcome page.',
    },
    {
        title: 'Frontend runtime',
        description: 'Vue pages and layouts now form the web shell that future product screens can extend.',
    },
    {
        title: 'Future API path',
        description: 'The web experience can evolve independently while the mobile REST surface expands in backend commits.',
    },
];
</script>

<template>
    <AppShell>
        <Head :title="title" />

        <section class="grid gap-10 lg:grid-cols-[minmax(0,1.15fr)_minmax(320px,0.85fr)] lg:items-end">
            <div class="space-y-6">
                <div class="space-y-4">
                    <h1 class="max-w-3xl text-4xl font-semibold tracking-tight text-stone-50 sm:text-5xl lg:text-6xl">
                        The web app shell is now ready for
                        <span class="block text-amber-300">Inertia-driven product features.</span>
                    </h1>

                    <p class="max-w-2xl text-base leading-7 text-stone-300 sm:text-lg">
                        This project is now serving the frontend through Vue single-file components rendered by Inertia,
                        keeping Laravel in control of backend concerns while preparing the ground for the next feature commits.
                    </p>
                </div>
            </div>

            <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-2xl shadow-amber-950/20 backdrop-blur">
                <p class="text-sm font-medium uppercase tracking-[0.24em] text-stone-400">Current status</p>

                <div class="mt-6 space-y-4">
                    <div
                        v-for="(note, index) in quickNotes"
                        :key="`note-${index}`"
                        class="flex gap-4"
                    >
                        <span class="mt-1 inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full border border-amber-300/40 text-sm text-amber-200">
                            {{ String(index + 1).padStart(2, '0') }}
                        </span>

                        <p class="text-sm leading-6 text-stone-300">{{ note }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 border-t border-white/10 pt-6 text-sm text-stone-400 sm:grid-cols-3">
            <article
                v-for="card in statusCards"
                :key="card.title"
                class="rounded-2xl border border-white/10 bg-black/10 p-4"
            >
                <p class="font-medium text-stone-200">{{ card.title }}</p>
                <p class="mt-2 leading-6">{{ card.description }}</p>
            </article>
        </section>
    </AppShell>
</template>