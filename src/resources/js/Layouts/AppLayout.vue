<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import logo from '@/../../resources/images/logo_transparent.png'

const page = usePage();

const menuItems = [
  { label: 'Categorias', route: 'categories.index' },
];

const routeFallbacks = {
  'categories.index': '/categories',
};

const resolveHref = (itemRoute) => {
  try {
    if (typeof route === 'function') {
      const target = route(itemRoute);
      if (typeof target === 'string' && target.length > 0) {
        return target;
      }
    }
  } catch (_) {
    // Ignore route helper errors and use route map fallback.
  }

  return routeFallbacks[itemRoute] ?? '#';
};

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

  const currentUrl = page.url;
  const fallbackUrl = routeFallbacks[itemRoute];

  if (typeof currentUrl === 'string' && typeof fallbackUrl === 'string') {
    return currentUrl.startsWith(fallbackUrl);
  }

  return false;
};
</script>

<template>
  <div class="min-h-screen flex flex-col font-['Inter']">
    <header class="h-13 bg-[#16C64F] shadow-sm z-10">
      <div class="max-w-6xl mx-auto w-full h-full px-6 flex items-center">
        <img :src="logo" alt="Newganizze" class="h-8 w-auto" />
      </div>
    </header>

    <div class="flex flex-1 pt-5 bg-gray-100 overflow-hidden">
      <div class="flex flex-1 max-w-6xl mx-auto w-full">
        <aside class="w-50 bg-gray-100 pt-8 px-3 shrink-0">
          <nav>
            <Link
              v-for="item in menuItems"
              :key="item.route"
              :href="resolveHref(item.route)"
              class="flex items-center gap-2.5 px-3 py-2 rounded mb-0.5 text-[15px] transition-colors"
              :class="isActive(item.route) ? 'text-[#16C64F] font-medium' : 'text-gray-500 hover:text-gray-700'"
            >
              <span
                class="w-2 h-2 rounded-full"
                :class="isActive(item.route) ? 'bg-[#16C64F]' : 'bg-transparent'"
              />
              <span>{{ item.label }}</span>
            </Link>
          </nav>
        </aside>

        <main class="flex-1 overflow-y-auto bg-gray-100 p-8">
          <slot />
        </main>
      </div>
    </div>
  </div>
</template>