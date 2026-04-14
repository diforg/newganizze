<script setup>
import CategoryRow from '@/Components/Categories/CategoryRow.vue'

defineProps({
  category: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <div class="mb-2">
    <div class="flex items-center justify-between py-3">
      <div class="flex items-center gap-3">
        <div
          class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
          :style="{ backgroundColor: category.color }"
        >
          <span class="text-white text-base">{{ category.icon }}</span>
        </div>
        <p class="font-semibold text-gray-800">{{ category.name }}</p>
      </div>

      <div class="flex items-center gap-5">
        <button type="button" class="text-sm text-blue-500 hover:text-blue-600 transition-colors">
          Arquivar
        </button>
        <button type="button" class="text-sm text-blue-500 hover:text-blue-600 transition-colors">
          + Sub-categoria
        </button>
      </div>
    </div>

    <div class="ml-13 border border-gray-100 rounded-lg overflow-hidden bg-white">
      <div v-if="!category.children || !category.children.length" class="py-4 px-4 text-sm text-gray-400 italic">
        Nenhuma subcategoria
      </div>

      <template v-else>
        <CategoryRow
          v-for="child in category.children"
          :key="child.id"
          :category="child"
        />
      </template>
    </div>
  </div>
</template>
