<template>
    <Head title="Produce" />
  
    <AppLayout :breadcrumbs="breadcrumbs">
      <div class="p-8 max-w-7xl mx-auto w-4/5">
        <h2 class="text-3xl font-bold mb-8 text-gray-900">Category Management</h2>
  
        <!-- Success Message -->
        <div v-if="$page.props.flash?.success" class="mb-6 p-4 bg-green-50 text-green-800 rounded-xl shadow-sm">
          {{ $page.props.flash?.success }}
        </div>
  
        <!-- Add Category Form -->
        <div class="mb-8 p-6 bg-white rounded-xl shadow-sm border border-gray-200">
          <h3 class="text-xl font-semibold mb-4 text-gray-900">Add New Category</h3>
          <form @submit.prevent="submit">
            <div class="flex flex-col sm:flex-row gap-4">
              <input
                v-model="form.name"
                type="text"
                placeholder="Category name"
                class="flex-1 border border-gray-200 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition duration-200 bg-gray-50 text-gray-900 placeholder-gray-500"
                :class="{ 'border-red-500': form.errors.name }"
                required
              />
              <button
                type="submit"
                class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 font-medium disabled:opacity-50"
                :disabled="form.processing"
              >
                <span v-if="!form.processing">Add Category</span>
                <span v-else class="flex items-center justify-center">
                  <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Processing...
                </span>
              </button>
            </div>
            <p v-if="form.errors.name" class="mt-2 text-sm text-red-600">{{ form.errors.name }}</p>
          </form>
        </div>
  
        <!-- Categories List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <h3 class="px-6 py-4 border-b border-gray-200 text-xl font-semibold text-gray-900">Existing Categories</h3>
          
          <ul class="divide-y divide-gray-200">
            <li v-for="category in categories" :key="category.id" class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
              <div class="flex items-center justify-between">
                <div v-if="!editingCategory || editingCategory.id !== category.id" class="text-gray-900 font-medium">
                  {{ category.name }}
                </div>
                
                <!-- Edit Form -->
                <form v-if="editingCategory && editingCategory.id === category.id" 
                      @submit.prevent="updateCategory" 
                      class="flex-1 flex gap-4">
                  <input
                    v-model="editForm.name"
                    type="text"
                    class="flex-1 border border-gray-200 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition duration-200 bg-gray-50 text-gray-900"
                    :class="{ 'border-red-500': editForm.errors.name }"
                    required
                  />
                  <div class="flex gap-3">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 font-medium">
                      Save
                    </button>
                    <button @click="cancelEdit" type="button" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200 font-medium">
                      Cancel
                    </button>
                  </div>
                  <p v-if="editForm.errors.name" class="mt-2 text-sm text-red-600">{{ editForm.errors.name }}</p>
                </form>
                
                <!-- Action Buttons -->
                <div v-if="!editingCategory || editingCategory.id !== category.id" class="flex gap-2">
                  <button 
                    @click="startEditing(category)"
                    class="p-2 text-indigo-600 hover:text-indigo-800 rounded-full hover:bg-indigo-50 transition-colors duration-200"
                    title="Edit"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>
                  <button 
                    @click="confirmDelete(category)"
                    class="p-2 text-red-600 hover:text-red-800 rounded-full hover:bg-red-50 transition-colors duration-200"
                    title="Delete"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </div>
            </li>
          </ul>
          
          <div v-if="categories.length === 0" class="px-6 py-8 text-center text-gray-500">
            No categories found. Add your first category above.
          </div>
        </div>
  
        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center p-4 z-50">
          <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Confirm Deletion</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to delete "{{ categoryToDelete?.name }}"? This action cannot be undone.</p>
            <div class="flex justify-end gap-3">
              <button @click="showDeleteModal = false" type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200 font-medium">
                Cancel
              </button>
              <button @click="deleteCategory" type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 font-medium">
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </AppLayout>
  </template>
  
  <script setup>
  import { useForm } from '@inertiajs/vue3';
  import { ref } from 'vue';
  import AppLayout from '@/layouts/AppLayout.vue';
  import { Head, router } from '@inertiajs/vue3';
  const breadcrumbs = [
  { title: 'Category', href: '/categories' },
];
  const props = defineProps({
    categories: Array,
    breadcrumbs: Array,
  });
  
  // Add Category
  const form = useForm({
    name: '',
  });
  
  const submit = () => {
    form.post(route('categories.store'), {
      preserveScroll: true,
      onSuccess: () => form.reset(),
    });
  };
  
  // Edit Category
  const editingCategory = ref(null);
  const editForm = useForm({
    name: '',
  });
  
  const startEditing = (category) => {
    editingCategory.value = category;
    editForm.name = category.name;
  };
  
  const updateCategory = () => {
    editForm.put(route('categories.update', editingCategory.value.id), {
      preserveScroll: true,
      onSuccess: () => {
        editingCategory.value = null;
        editForm.reset();
      },
    });
  };
  
  const cancelEdit = () => {
    editingCategory.value = null;
    editForm.reset();
  };
  
  // Delete Category
  const showDeleteModal = ref(false);
  const categoryToDelete = ref(null);
  
  const confirmDelete = (category) => {
    categoryToDelete.value = category;
    showDeleteModal.value = true;
  };
  
  const deleteCategory = () => {
    useForm({}).delete(route('categories.destroy', categoryToDelete.value.id), {
      preserveScroll: true,
      onSuccess: () => {
        showDeleteModal.value = false;
        categoryToDelete.value = null;
      },
    });
  };
  </script>
  
  <style>
  .animate-spin {
    animation: spin 1s linear infinite;
  }
  
  @keyframes spin {
    from {
      transform: rotate(0deg);
    }
    to {
      transform: rotate(360deg);
    }
  }
  </style>