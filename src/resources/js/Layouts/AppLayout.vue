<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();

const menuItems = [
  { label: 'Categorias', route: 'categories.index', icon: '🏷️' },
];

const isActive = (itemRoute) => {
  try {
    if (typeof route === 'function' && route().current(itemRoute)) {
      return true;
    }
  } catch (_) {
    // Ignore route helper errors and fall back to location checks.
  }

  const location = page.props?.ziggy?.location;

  try {
    if (typeof route === 'function' && typeof location === 'string') {
      const targetUrl = route(itemRoute);
      return typeof targetUrl === 'string' && location.startsWith(targetUrl);
    }
  } catch (_) {
    // Ignore route URL resolution errors.
  }

  return false;
};
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <header class="h-14 bg-green-600 shadow-sm px-6 flex items-center z-10">
      <div class="text-white font-semibold text-lg tracking-wide">Newganizze</div>
    </header>

    <div class="flex flex-1 overflow-hidden">
      <aside class="w-52 bg-gray-100 pt-6 px-3 shrink-0">
        <nav>
          <Link
            v-for="item in menuItems"
            :key="item.route"
            :href="route(item.route)"
            class="flex items-center gap-2.5 px-3 py-2 rounded mb-0.5 text-sm transition-colors"
            :class="isActive(item.route) ? 'text-green-600 font-medium' : 'text-gray-500 hover:text-gray-700'"
          >
            <span>{{ item.icon }}</span>
            <span>{{ item.label }}</span>
            <span
              class="w-2 h-2 rounded-full ml-auto"
              :class="isActive(item.route) ? 'bg-green-500' : 'bg-transparent'"
            />
          </Link>
        </nav>
      </aside>

      <main class="flex-1 overflow-y-auto bg-gray-100 p-8">
        <slot />
      </main>
    </div>
  </div>
</template>
