<script setup>
defineProps({
    badge: {
        type: String,
        default: 'Laravel + Inertia + Vue',
    },
});
</script>

<template>
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(245,158,11,0.18),_transparent_28%),linear-gradient(180deg,_#0c0a09_0%,_#1c1917_45%,_#0c0a09_100%)]">
        <main class="mx-auto flex min-h-screen w-full max-w-6xl flex-col justify-between gap-12 px-6 py-10 lg:px-10 lg:py-16">
            <header class="flex items-center justify-between gap-4">
                <span class="inline-flex rounded-full border border-amber-400/30 bg-amber-300/10 px-3 py-1 text-xs font-medium uppercase tracking-[0.28em] text-amber-200">
                    {{ badge }}
                </span>
                <slot name="header" />
            </header>

            <slot />
        </main>
    </div>
</template>