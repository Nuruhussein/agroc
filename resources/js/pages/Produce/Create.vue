

<script>
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

export default {
  components: {
    Head,
    AppLayout,
  },
  
  props: {
    categories: {
      type: Array,
      required: true,
      default: () => []
    }
  },
  
  mounted() {
    console.log('Categories:', this.categories);
  },
  
  data() {
    return {
      breadcrumbs: [
        { title: 'Dashboard', href: '/dashboard' },
        { title: 'Produce', href: '/produce' },
        { title: 'Add Produce', href: '' },
      ],
      form: useForm({
        name: '',
        category_id: '',
        location: '',
        farm_name: '',
        description: '',
        price: '',
        original_price: '',
        discount: '',
        organic: false,
        quantity: '',
        image: null,
      })
    }
  },
  
  methods: {
    handleImageUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.image = file;
      }
    },
    submit() {
      console.log('Form data:', this.form.data());
      const formData = new FormData();
      Object.keys(this.form.data()).forEach(key => {
        if (key === 'image' && this.form.image) {
          formData.append(key, this.form.image);
        } else if (key === 'organic') {
          formData.append(key, this.form.organic ? '1' : '0'); // Convert boolean to 1/0
        } else if (this.form[key] !== null && this.form[key] !== '') {
          formData.append(key, this.form[key]);
        }
      });

      this.form
        .transform(() => formData)
        .post(this.route('produce.store'), {
          preserveScroll: true,
          onSuccess: () => this.form.reset(),
          forceFormData: true,
        });
    }
  }
}
</script>
<template>
  <Head title="Add Produce" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div class="sm:flex-auto">
          <h1 class="text-2xl font-bold text-gray-900">Add New Produce</h1>
          <p class="mt-2 text-sm text-gray-600">Fill in the details of your farm produce</p>
        </div>
      </div>

      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6 sm:p-8">
          <form @submit.prevent="submit" class="space-y-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
              <!-- Name Field -->
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  placeholder="Organic Tomatoes"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm py-2 px-3 border"
                  :class="{ 'border-red-500': form.errors.name }"
                  required
                />
                <p v-if="form.errors.name" class="mt-2 text-sm text-red-600">{{ form.errors.name }}</p>
              </div>

              <!-- Category Field -->
              <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                <select
                  id="category_id"
                  v-model="form.category_id"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm py-2 px-3 border"
                  required
                >
                  <option value="" disabled>Select category</option>
                  <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.name }}
                  </option>
                </select>
                <p v-if="form.errors.category_id" class="mt-2 text-sm text-red-600">{{ form.errors.category_id }}</p>
              </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
              <!-- Location Field -->
              <div>
                <label for="locationme/location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                <input
                  id="location"
                  v-model="form.location"
                  type="text"
                  placeholder="e.g., Kisumu, Kenya"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm py-2 px-3 border"
                  :class="{ 'border-red-500': form.errors.location }"
                />
                <p v-if="form.errors.location" class="mt-2 text-sm text-red-600">{{ form.errors.location }}</p>
              </div>

              <!-- Farm Name Field -->
              <div>
                <label for="farm_name" class="block text-sm font-medium text-gray-700 mb-1">Farm Name</label>
                <input
                  id="farm_name"
                  v-model="form.farm_name"
                  type="text"
                  placeholder="e.g., Green Valley Farm"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm py-2 px-3 border"
                  :class="{ 'border-red-500': form.errors.farm_name }"
                />
                <p v-if="form.errors.farm_name" class="mt-2 text-sm text-red-600">{{ form.errors.farm_name }}</p>
              </div>
            </div>

            <!-- Description Field -->
            <div>
              <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
              <textarea
                id="description"
                v-model="form.description"
                rows="4"
                placeholder="Describe your produce..."
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm py-2 px-3 border"
                :class="{ 'border-red-500': form.errors.description }"
              ></textarea>
              <p v-if="form.errors.description" class="mt-2 text-sm text-red-600">{{ form.errors.description }}</p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
              <!-- Price Field -->
              <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price *</label>
                <div class="relative rounded-md shadow-sm">
                  <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <span class="text-gray-500 sm:text-sm">$</span>
                  </div>
                  <input
                    id="price"
                    v-model="form.price"
                    type="number"
                    step="0.01"
                    min="0"
                    placeholder="0.00"
                    class="block w-full rounded-md border-gray-300 pl-7 pr-12 focus:border-green-500 focus:ring-green-500 sm:text-sm py-2 px-3 border"
                    :class="{ 'border-red-500': form.errors.price }"
                    required
                  />
                </div>
                <p v-if="form.errors.price" class="mt-2 text-sm text-red-600">{{ form.errors.price }}</p>
              </div>

              <!-- Original Price Field -->
              <div>
                <label for="original_price" class="block text-sm font-medium text-gray-700 mb-1">Original Price</label>
                <div class="relative rounded-md shadow-sm">
                  <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <span class="text-gray-500 sm:text-sm">$</span>
                  </div>
                  <input
                    id="original_price"
                    v-model="form.original_price"
                    type="number"
                    step="0.01"
                    min="0"
                    placeholder="0.00"
                    class="block w-full rounded-md border-gray-300 pl-7 pr-12 focus:border-green-500 focus:ring-green-500 sm:text-sm py-2 px-3 border"
                    :class="{ 'border-red-500': form.errors.original_price }"
                  />
                </div>
                <p v-if="form.errors.original_price" class="mt-2 text-sm text-red-600">{{ form.errors.original_price }}</p>
              </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
              <!-- Discount Field -->
              <div>
                <label for="discount" class="block text-sm font-medium text-gray-700 mb-1">Discount (%)</label>
                <input
                  id="discount"
                  v-model="form.discount"
                  type="number"
                  min="0"
                  max="100"
                  placeholder="e.g., 10"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm py-2 px-3 border"
                  :class="{ 'border-red-500': form.errors.discount }"
                />
                <p v-if="form.errors.discount" class="mt-2 text-sm text-red-600">{{ form.errors.discount }}</p>
              </div>

              <!-- Quantity Field -->
              <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                <input
                  id="quantity"
                  v-model="form.quantity"
                  type="number"
                  min="1"
                  placeholder="e.g., 100"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm py-2 px-3 border"
                  :class="{ 'border-red-500': form.errors.quantity }"
                  required
                />
                <p v-if="form.errors.quantity" class="mt-2 text-sm text-red-600">{{ form.errors.quantity }}</p>
              </div>
            </div>

            <!-- Organic Field -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Organic</label>
              <div class="flex items-center">
                <input
                  id="organic"
                  v-model="form.organic"
                  type="checkbox"
                  class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                />
                <label for="organic" class="ml-2 block text-sm text-gray-900">
                  This produce is organic
                </label>
              </div>
              <p v-if="form.errors.organic" class="mt-2 text-sm text-red-600">{{ form.errors.organic }}</p>
            </div>

            <!-- Image Upload Field -->
            <div>
              <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
              <input
                id="image"
                type="file"
                accept="image/*"
                @change="handleImageUpload"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
              />
              <p v-if="form.errors.image_path" class="mt-2 text-sm text-red-600">{{ form.errors.image_path }}</p>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-x-4 pt-6 border-t border-gray-200">
              <a
                :href="route('produce.index')"
                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
              >
                Cancel
              </a>
              <button
                type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                :disabled="form.processing"
                :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
              >
                <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ form.processing ? 'Saving...' : 'Save Produce' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>