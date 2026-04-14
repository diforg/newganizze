<template>
  <!-- Backdrop -->
  <Teleport to="body">
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="show"
        class="fixed inset-0 bg-black/40 z-50 flex items-start justify-center"
        @click.self="$emit('close')"
      >
        <Transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="opacity-0 scale-95 translate-y-2"
          enter-to-class="opacity-100 scale-100 translate-y-0"
          leave-active-class="transition duration-150 ease-in"
          leave-from-class="opacity-100 scale-100 translate-y-0"
          leave-to-class="opacity-0 scale-95 translate-y-2"
        >
          <div
            v-if="show"
            class="bg-white w-full max-w-lg mx-4 mt-20 rounded-xl shadow-xl p-6 relative"
            @click.stop
          >
            <!-- Header -->
            <div class="flex items-center justify-between mb-5">
              <h2 class="text-lg font-semibold text-gray-800">
                Nova Categoria
              </h2>
              <button
                type="button"
                class="w-8 h-8 flex items-center justify-center rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors"
                @click="$emit('close')"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>

            <!-- Preview circle -->
            <div class="flex justify-center mb-6">
              <div
                class="w-16 h-16 rounded-full flex items-center justify-center text-2xl text-white transition-all duration-300"
                :style="form.icon && form.color
                  ? { backgroundColor: form.color }
                  : {}"
                :class="!(form.icon && form.color) ? 'bg-gray-200' : ''"
              >
                <span v-if="form.icon">{{ form.icon }}</span>
              </div>
            </div>

            <!-- Type toggle: main / sub -->
            <div class="flex gap-3 mb-5">
              <label
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border-2 cursor-pointer transition-all text-sm font-medium"
                :class="form.type === 'main'
                  ? 'border-green-500 bg-green-50 text-green-700'
                  : 'border-gray-200 text-gray-500 hover:border-gray-300'"
              >
                <input
                  type="radio"
                  class="sr-only"
                  value="main"
                  v-model="form.type"
                />
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M2 10a8 8 0 118 8A8 8 0 012 10zm8-4a1 1 0 00-1 1v3a1 1 0 002 0V7a1 1 0 00-1-1z" />
                </svg>
                Categoria Principal
              </label>
              <label
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border-2 cursor-pointer transition-all text-sm font-medium"
                :class="form.type === 'sub'
                  ? 'border-green-500 bg-green-50 text-green-700'
                  : 'border-gray-200 text-gray-500 hover:border-gray-300'"
              >
                <input
                  type="radio"
                  class="sr-only"
                  value="sub"
                  v-model="form.type"
                />
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                Subcategoria
              </label>
            </div>

            <!-- Parent category select (only when sub) -->
            <Transition
              enter-active-class="transition duration-200 ease-out"
              enter-from-class="opacity-0 -translate-y-1"
              enter-to-class="opacity-100 translate-y-0"
              leave-active-class="transition duration-150 ease-in"
              leave-from-class="opacity-100 translate-y-0"
              leave-to-class="opacity-0 -translate-y-1"
            >
              <div v-if="form.type === 'sub'" class="mb-4">
                <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">
                  Categoria Pai
                </label>
                <select
                  v-model="form.parent_category_id"
                  class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition"
                >
                  <option :value="null" disabled>Selecione uma categoria</option>
                  <option
                    v-for="cat in parentCategories"
                    :key="cat.id"
                    :value="cat.id"
                  >
                    {{ cat.name }}
                  </option>
                </select>
              </div>
            </Transition>

            <!-- Name -->
            <div class="mb-4">
              <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">
                Nome
              </label>
              <input
                v-model="form.name"
                type="text"
                placeholder="Ex: Alimentação"
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition"
              />
            </div>

            <!-- Icon picker panel -->
            <div class="mb-3 border border-gray-100 rounded-xl overflow-hidden">
              <button
                type="button"
                class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition-colors text-sm font-medium text-gray-700"
                @click="iconsOpen = !iconsOpen"
              >
                <div class="flex items-center gap-2">
                  <span class="text-base">{{ form.icon || '🎨' }}</span>
                  <span>{{ form.icon ? 'Ícone selecionado' : 'Escolher ícone' }}</span>
                </div>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-4 h-4 text-gray-400 transition-transform duration-200"
                  :class="iconsOpen ? 'rotate-180' : ''"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </button>

              <Transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
              >
                <div v-if="iconsOpen" class="p-3 bg-white border-t border-gray-100">
                  <div class="grid grid-cols-10 gap-1">
                    <button
                      v-for="(emoji, idx) in icons"
                      :key="idx"
                      type="button"
                      class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-lg cursor-pointer hover:bg-gray-200 transition-colors"
                      :class="form.icon === emoji ? 'ring-2 ring-green-500 bg-green-50' : ''"
                      @click="form.icon = emoji"
                    >
                      {{ emoji }}
                    </button>
                  </div>
                </div>
              </Transition>
            </div>

            <!-- Color picker panel -->
            <div class="mb-5 border border-gray-100 rounded-xl overflow-hidden">
              <button
                type="button"
                class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition-colors text-sm font-medium text-gray-700"
                @click="colorsOpen = !colorsOpen"
              >
                <div class="flex items-center gap-2">
                  <span
                    class="w-4 h-4 rounded-full border border-gray-200 inline-block"
                    :style="form.color ? { backgroundColor: form.color } : { backgroundColor: '#e5e7eb' }"
                  ></span>
                  <span>{{ form.color ? 'Cor selecionada' : 'Escolher cor' }}</span>
                </div>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-4 h-4 text-gray-400 transition-transform duration-200"
                  :class="colorsOpen ? 'rotate-180' : ''"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </button>

              <Transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
              >
                <div v-if="colorsOpen" class="p-3 bg-white border-t border-gray-100">
                  <!-- Row 1: 11 colors -->
                  <div class="grid grid-cols-11 gap-1.5 mb-1.5">
                    <button
                      v-for="hex in colors.slice(0, 11)"
                      :key="hex"
                      type="button"
                      class="w-8 h-8 rounded-full cursor-pointer transition-transform hover:scale-110"
                      :class="form.color === hex ? 'ring-2 ring-offset-1 ring-gray-400 scale-110' : ''"
                      :style="{ backgroundColor: hex }"
                      @click="form.color = hex"
                    ></button>
                  </div>
                  <!-- Row 2: 10 colors -->
                  <div class="grid grid-cols-11 gap-1.5">
                    <button
                      v-for="hex in colors.slice(11)"
                      :key="hex"
                      type="button"
                      class="w-8 h-8 rounded-full cursor-pointer transition-transform hover:scale-110"
                      :class="form.color === hex ? 'ring-2 ring-offset-1 ring-gray-400 scale-110' : ''"
                      :style="{ backgroundColor: hex }"
                      @click="form.color = hex"
                    ></button>
                  </div>
                </div>
              </Transition>
            </div>

            <!-- Actions -->
            <div class="flex gap-3">
              <button
                type="button"
                class="flex-1 px-4 py-2.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors"
                @click="$emit('close')"
              >
                Cancelar
              </button>
              <button
                type="button"
                class="flex-1 px-4 py-2.5 rounded-lg text-sm font-medium text-white transition-all"
                :class="isValid
                  ? 'bg-green-500 hover:bg-green-600 shadow-sm shadow-green-200'
                  : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                :disabled="!isValid"
                @click="handleSubmit"
              >
                Criar Categoria
              </button>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { ref, reactive, computed, watch } from 'vue'

const props = defineProps({
  show: {
    type: Boolean,
    required: true,
  },
  activeTab: {
    type: String,
    default: 'expense',
    validator: (v) => ['expense', 'income'].includes(v),
  },
  nature: {
    type: String,
    default: 'expense',
    validator: (v) => ['expense', 'income'].includes(v),
  },
  parentCategories: {
    type: Array,
    default: () => [],
  },
})

const emit = defineEmits(['close', 'submit'])

// ── Internal state ───────────────────────────────────────────────
const form = reactive({
  type: 'main',
  parent_category_id: null,
  name: '',
  icon: '',
  color: '',
})

const _iconsOpen  = ref(false)
const _colorsOpen = ref(false)

const iconsOpen  = computed({ get: () => _iconsOpen.value,  set: v => (_iconsOpen.value  = v) })
const colorsOpen = computed({ get: () => _colorsOpen.value, set: v => (_colorsOpen.value = v) })

// Reset form when modal opens
watch(() => props.show, (val) => {
  if (val) {
    form.type               = 'main'
    form.parent_category_id = null
    form.name               = ''
    form.icon               = ''
    form.color              = ''
    _iconsOpen.value        = false
    _colorsOpen.value       = false
  }
})

// Clear parent when switching back to main
watch(() => form.type, (val) => {
  if (val === 'main') form.parent_category_id = null
})

// ── Data ─────────────────────────────────────────────────────────
const icons = [
  '🍷','🧥','📋','🎓','😊','✈️','🏢','🎵','🏀','☂️',
  '📓','💼','🍽️','📷','🖥️','🎲','📈','🏆','👁️','🍎',
  '❤️','🚩','🍴','🎮','🤲','🛒','🐾','🩹','➕','🏠',
  '💡','📊','🖼️','💵','🔒','🛵','☕','📝','⋯','🎨',
  '📄','👥','👤','🐾','🛡️','⛵','⭐','🏷️','🚚','👜',
  '😊','❄️','🌱','🍲','🎨','📂','➗','🚗','🔧','🚌',
  '✈️','🏠','💼','🚌','🏄','🎯','🌍',
]

const colors = [
  '#EC4899','#9333EA','#4F46E5','#3B82F6','#9D174D',
  '#F87171','#FCA5A5','#1E3A8A','#22C55E','#FDBA74','#F472B6',
  '#166534','#F97316','#F59E0B','#B91C1C','#93C5FD',
  '#6B7280','#14B8A6','#134E4A','#6EE7B7','#DC2626',
]

// ── Computed ─────────────────────────────────────────────────────
const isValid = computed(() =>
  !!form.name.trim() && !!form.icon && !!form.color
)

// ── Handlers ─────────────────────────────────────────────────────
function handleSubmit() {
  if (!isValid.value) return
  emit('submit', {
    type:               form.type,
    parent_category_id: form.type === 'sub' ? form.parent_category_id : null,
    name:               form.name.trim(),
    icon:               form.icon,
    color:              form.color,
    nature:             props.nature,
    active_tab:         props.activeTab,
  })
}
</script>