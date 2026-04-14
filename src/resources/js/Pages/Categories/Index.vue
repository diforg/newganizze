<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import CategoryCard from '@/Components/Categories/CategoryCard.vue'
import CreateCategoryModal from '@/Components/Categories/CreateCategoryModal.vue'

const props = defineProps({
  categories: {
    type: Array,
    default: () => [],
  },
  parentCategories: {
    type: Array,
    default: () => [],
  },
  archivedCount: {
    type: Number,
    default: 0,
  },
  activeTab: {
    type: String,
    default: 'expense',
  },
})

const showModal = ref(false)

const newCategoryLabel = computed(() =>
  props.activeTab === 'income' ? '+ Categoria de Receita' : '+ Categoria de Despesa'
)

const switchTab = (type) => {
  if (type === props.activeTab) return
  router.get('/categories', { type }, { preserveState: true, replace: true })
}

const handleSubmit = (payload) => {
  router.post('/categories', payload, {
    preserveState: false,
    onSuccess: () => {
      showModal.value = false
    },
  })
}
</script>

<template>
  <AppLayout>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden p-8">

      <div class="flex justify-between items-center mb-6">
        <h1 class="text-[20px] font-semibold text-gray-800">Categorias</h1>
        <button
          type="button"
          class="bg-green-100 text-green-700 text-sm font-medium px-4 py-2 rounded-lg hover:bg-green-50"
          @click="showModal = true"
        >
          {{ newCategoryLabel }}
        </button>
      </div>

      <div class="flex border-b border-gray-200">
        <button
          type="button"
          class="flex-1 py-4 text-sm font-medium text-center relative transition-colors"
          :class="activeTab === 'expense' ? 'text-green-600' : 'text-gray-400 hover:text-gray-600'"
          @click="switchTab('expense')"
        >
          Despesa
          <span
            v-if="activeTab === 'expense'"
            class="absolute bottom-0 inset-x-0 h-0.5 bg-green-500"
          />
        </button>
        <button
          type="button"
          class="flex-1 py-4 text-sm font-medium text-center relative transition-colors"
          :class="activeTab === 'income' ? 'text-green-600' : 'text-gray-400 hover:text-gray-600'"
          @click="switchTab('income')"
        >
          Receita
          <span
            v-if="activeTab === 'income'"
            class="absolute bottom-0 inset-x-0 h-0.5 bg-green-500"
          />
        </button>
      </div>

      <div class="px-6 py-4">
        <a href="#" class="text-sm text-gray-400 underline hover:text-gray-600 mb-4 block">
          {{ archivedCount }} categorias arquivadas
        </a>

        <template v-if="categories.length">
          <CategoryCard
            v-for="category in categories"
            :key="category.id"
            :category="category"
          />
        </template>

        <div v-else class="flex flex-col items-center py-20 text-gray-400 text-sm">
          Nenhuma categoria cadastrada
        </div>
      </div>
    </div>

    <CreateCategoryModal
      :show="showModal"
      :active-tab="activeTab"
      :nature="activeTab === 'income' ? 'income' : 'expense'"
      :parent-categories="parentCategories"
      @close="showModal = false"
      @submit="handleSubmit"
    />
  </AppLayout>
</template>