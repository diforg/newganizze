<script setup>
defineProps({
  category: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <div class="flex items-center justify-between py-3 px-4 border-b border-gray-100 last:border-b-0 group">
    <p class="text-sm text-gray-500 select-none">{{ category.name }}</p>

    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-150 flex items-center gap-3">
      <button type="button" class="text-xs font-medium text-green-600 hover:text-green-700 transition-colors">
        Editar
      </button>
      <button type="button" class="text-xs font-medium text-red-500 hover:text-red-600 transition-colors">
        Excluir
      </button>
    </div>
  </div>
</template>
