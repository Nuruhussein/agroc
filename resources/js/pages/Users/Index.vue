<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import { Pencil, Trash2, UserPlus, Eye, X } from 'lucide-vue-next';

// Define roles statically to match User model's ROLES constant
const ROLES = {
  admin: 'Admin',
  farmer: 'Farmer',
  buyer: 'Buyer',
};

const props = defineProps({
  users: Object, // Changed to Object to handle paginated data
  flash: Object,
});

const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const selectedUser = ref(null);

const createForm = useForm({
  name: '',
  email: '',
  role: '',
  phone: '',
  region: '',
  password: '',
  password_confirmation: '',
  profile_picture: null, // Added profile picture field
});

const editForm = useForm({
  name: '',
  email: '',
  role: '',
  phone: '',
  region: '',
  password: '',
  password_confirmation: '',
  profile_picture: null, // Added profile picture field
});

const openCreateModal = () => {
  createForm.reset();
  showCreateModal.value = true;
};

const openEditModal = (user) => {
  editForm.reset();
  editForm.name = user.name;
  editForm.email = user.email;
  editForm.role = user.role || '';
  editForm.phone = user.phone || '';
  editForm.region = user.region || '';
  editForm.profile_picture = null; // Reset profile picture
  selectedUser.value = user;
  showEditModal.value = true;
};

const openDeleteModal = (user) => {
  selectedUser.value = user;
  showDeleteModal.value = true;
};

const createUser = () => {
  createForm.post('/admin/users', {
    preserveScroll: true,
    onSuccess: () => {
      showCreateModal.value = false;
      createForm.reset();
    },
    onError: (errors) => {
      console.error('Create errors:', errors);
    },
  });
};

const updateUser = () => {
  editForm.post(`/admin/users/${selectedUser.value.id}`, {
    method: 'put',
    preserveScroll: true,
    onSuccess: () => {
      showEditModal.value = false;
      editForm.reset();
    },
    onError: (errors) => {
      console.error('Update errors:', errors);
    },
  });
};

const deleteUser = () => {
  router.delete(`/admin/users/${selectedUser.value.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      showDeleteModal.value = false;
      selectedUser.value = null;
    },
    onError: (errors) => {
      console.error('Delete errors:', errors);
    },
  });
};

const viewUser = (id) => router.visit(`/admin/users/${id}`);

// Pagination handler
const changePage = (url) => {
  if (url) {
    router.visit(url, {
      preserveState: true,
      preserveScroll: true,
    });
  }
};
</script>

<template>
  <AppLayout :title="'Users'" :breadcrumbs="[{ name: 'Users', href: '/admin/users' }]">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Flash Messages -->
      <div v-if="flash.success" class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl shadow-sm">
        {{ flash.success }}
      </div>
      <div v-if="flash.error" class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl shadow-sm">
        {{ flash.error }}
      </div>

      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
        <button
          @click="openCreateModal"
          class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200"
        >
          <UserPlus class="h-5 w-5 mr-2" />
          Add User
        </button>
      </div>

      <!-- Users Table -->
      <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
          <thead class="bg-indigo-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Profile</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Role</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Phone</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Region</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-100">
            <tr v-for="user in users.data" :key="user.id" class="hover:bg-indigo-50/50 transition-colors duration-200">
              <td class="px-6 py-4 whitespace-nowrap">
                <img
                  :src="user.profile_picture ? `/storage/${user.profile_picture}` : '/images/default-profile-picture.jpg'"
                  alt="Profile Picture"
                  class="w-10 h-10 rounded-full object-cover border-2 border-indigo-200"
                />
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ user.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ user.email }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 capitalize">{{ user.role }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ user.phone || 'N/A' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ user.region || 'N/A' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex space-x-4">
                  <button @click="viewUser(user.id)" class="text-indigo-600 hover:text-indigo-800">
                    <Eye class="h-5 w-5" />
                  </button>
                  <button @click="openEditModal(user)" class="text-amber-600 hover:text-amber-800">
                    <Pencil class="h-5 w-5" />
                  </button>
                  <button @click="openDeleteModal(user)" class="text-red-600 hover:text-red-800">
                    <Trash2 class="h-5 w-5" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination Controls -->
      <div class="mt-6 flex justify-between items-center">
        <div class="text-sm text-gray-600">
          Showing {{ users.from }} to {{ users.to }} of {{ users.total }} users
        </div>
        <div class="flex space-x-2">
          <button
            @click="changePage(users.prev_page_url)"
            :disabled="!users.prev_page_url"
            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            Previous
          </button>
          <button
            @click="changePage(users.next_page_url)"
            :disabled="!users.next_page_url"
            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            Next
          </button>
        </div>
      </div>

      <!-- Create Modal -->
      <div v-if="showCreateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-lg">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-900">Create User</h2>
            <button @click="showCreateModal = false" class="text-gray-500 hover:text-gray-700">
              <X class="h-6 w-6" />
            </button>
          </div>
          <form @submit.prevent="createUser" class="space-y-4" enctype="multipart/form-data">
            <div>
              <label for="create-name" class="block text-sm font-medium text-gray-700">Name *</label>
              <input
                id="create-name"
                v-model="createForm.name"
                type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': createForm.errors.name }"
                required
              />
              <p v-if="createForm.errors.name" class="mt-1 text-sm text-red-600">{{ createForm.errors.name }}</p>
            </div>
            <div>
              <label for="create-email" class="block text-sm font-medium text-gray-700">Email *</label>
              <input
                id="create-email"
                v-model="createForm.email"
                type="email"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': createForm.errors.email }"
                required
              />
              <p v-if="createForm.errors.email" class="mt-1 text-sm text-red-600">{{ createForm.errors.email }}</p>
            </div>
            <div>
              <label for="create-role" class="block text-sm font-medium text-gray-700">Role *</label>
              <select
                id="create-role"
                v-model="createForm.role"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': createForm.errors.role }"
                required
              >
                <option value="" disabled>Select role</option>
                <option v-for="(label, value) in ROLES" :value="value">{{ label }}</option>
              </select>
              <p v-if="createForm.errors.role" class="mt-1 text-sm text-red-600">{{ createForm.errors.role }}</p>
            </div>
            <div>
              <label for="create-phone" class="block text-sm font-medium text-gray-700">Phone</label>
              <input
                id="create-phone"
                v-model="createForm.phone"
                type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': createForm.errors.phone }"
              />
              <p v-if="createForm.errors.phone" class="mt-1 text-sm text-red-600">{{ createForm.errors.phone }}</p>
            </div>
            <div>
              <label for="create-region" class="block text-sm font-medium text-gray-700">Region</label>
              <input
                id="create-region"
                v-model="createForm.region"
                type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': createForm.errors.region }"
              />
              <p v-if="createForm.errors.region" class="mt-1 text-sm text-red-600">{{ createForm.errors.region }}</p>
            </div>
            <div>
              <label for="create-profile_picture" class="block text-sm font-medium text-gray-700">Profile Picture (Optional)</label>
              <input
                id="create-profile_picture"
                type="file"
                accept="image/*"
                @change="createForm.profile_picture = $event.target.files[0]"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': createForm.errors.profile_picture }"
              />
              <p v-if="createForm.errors.profile_picture" class="mt-1 text-sm text-red-600">{{ createForm.errors.profile_picture }}</p>
            </div>
            <div>
              <label for="create-password" class="block text-sm font-medium text-gray-700">Password *</label>
              <input
                id="create-password"
                v-model="createForm.password"
                type="password"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': createForm.errors.password }"
                required
              />
              <p v-if="createForm.errors.password" class="mt-1 text-sm text-red-600">{{ createForm.errors.password }}</p>
            </div>
            <div>
              <label for="create-password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password *</label>
              <input
                id="create-password_confirmation"
                v-model="createForm.password_confirmation"
                type="password"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': createForm.errors.password_confirmation }"
                required
              />
              <p v-if="createForm.errors.password_confirmation" class="mt-1 text-sm text-red-600">{{ createForm.errors.password_confirmation }}</p>
            </div>
            <div class="flex justify-end space-x-2">
              <button
                type="button"
                @click="showCreateModal = false"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors duration-200"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200"
                :disabled="createForm.processing"
                :class="{ 'opacity-50 cursor-not-allowed': createForm.processing }"
              >
                {{ createForm.processing ? 'Creating...' : 'Create User' }}
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Edit Modal -->
      <div v-if="showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-lg">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-900">Edit User</h2>
            <button @click="showEditModal = false" class="text-gray-500 hover:text-gray-700">
              <X class="h-6 w-6" />
            </button>
          </div>
          <form @submit.prevent="updateUser" class="space-y-4" enctype="multipart/form-data">
            <div>
              <label for="edit-name" class="block text-sm font-medium text-gray-700">Name *</label>
              <input
                id="edit-name"
                v-model="editForm.name"
                type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': editForm.errors.name }"
                required
              />
              <p v-if="editForm.errors.name" class="mt-1 text-sm text-red-600">{{ editForm.errors.name }}</p>
            </div>
            <div>
              <label for="edit-email" class="block text-sm font-medium text-gray-700">Email *</label>
              <input
                id="edit-email"
                v-model="editForm.email"
                type="email"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': editForm.errors.email }"
                required
              />
              <p v-if="editForm.errors.email" class="mt-1 text-sm text-red-600">{{ editForm.errors.email }}</p>
            </div>
            <div>
              <label for="edit-role" class="block text-sm font-medium text-gray-700">Role *</label>
              <select
                id="edit-role"
                v-model="editForm.role"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': editForm.errors.role }"
                required
              >
                <option value="" disabled>Select role</option>
                <option v-for="(label, value) in ROLES" :value="value">{{ label }}</option>
              </select>
              <p v-if="editForm.errors.role" class="mt-1 text-sm text-red-600">{{ editForm.errors.role }}</p>
            </div>
            <div>
              <label for="edit-phone" class="block text-sm font-medium text-gray-700">Phone</label>
              <input
                id="edit-phone"
                v-model="editForm.phone"
                type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': editForm.errors.phone }"
              />
              <p v-if="editForm.errors.phone" class="mt-1 text-sm text-red-600">{{ editForm.errors.phone }}</p>
            </div>
            <div>
              <label for="edit-region" class="block text-sm font-medium text-gray-700">Region</label>
              <input
                id="edit-region"
                v-model="editForm.region"
                type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': editForm.errors.region }"
              />
              <p v-if="editForm.errors.region" class="mt-1 text-sm text-red-600">{{ editForm.errors.region }}</p>
            </div>
            <div>
              <label for="edit-profile_picture" class="block text-sm font-medium text-gray-700">Profile Picture (Optional)</label>
              <input
                id="edit-profile_picture"
                type="file"
                accept="image/*"
                @change="editForm.profile_picture = $event.target.files[0]"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': editForm.errors.profile_picture }"
              />
              <p v-if="editForm.errors.profile_picture" class="mt-1 text-sm text-red-600">{{ editForm.errors.profile_picture }}</p>
              <div v-if="selectedUser?.profile_picture" class="mt-2">
                <img
                  :src="`/storage/${selectedUser.profile_picture}`"
                  alt="Current Profile Picture"
                  class="w-16 h-16 rounded-full object-cover border-2 border-indigo-200"
                />
              </div>
            </div>
            <div>
              <label for="edit-password" class="block text-sm font-medium text-gray-700">Password (leave blank to keep unchanged)</label>
              <input
                id="edit-password"
                v-model="editForm.password"
                type="password"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': editForm.errors.password }"
              />
              <p v-if="editForm.errors.password" class="mt-1 text-sm text-red-600">{{ editForm.errors.password }}</p>
            </div>
            <div>
              <label for="edit-password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
              <input
                id="edit-password_confirmation"
                v-model="editForm.password_confirmation"
                type="password"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                :class="{ 'border-red-500': editForm.errors.password_confirmation }"
                :required="editForm.password !== ''"
              />
              <p v-if="editForm.errors.password_confirmation" class="mt-1 text-sm text-red-600">{{ editForm.errors.password_confirmation }}</p>
            </div>
            <div class="flex justify-end space-x-2">
              <button
                type="button"
                @click="showEditModal = false"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors duration-200"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200"
                :disabled="editForm.processing"
                :class="{ 'opacity-50 cursor-not-allowed': editForm.processing }"
              >
                {{ editForm.processing ? 'Updating...' : 'Update User' }}
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Delete Modal -->
      <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-lg">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-900">Delete User</h2>
            <button @click="showDeleteModal = false" class="text-gray-500 hover:text-gray-700">
              <X class="h-6 w-6" />
            </button>
          </div>
          <p class="text-sm text-gray-600 mb-4">
            Are you sure you want to delete <span class="font-semibold">{{ selectedUser?.name }}</span>? This action cannot be undone.
          </p>
          <div class="flex justify-end space-x-2">
            <button
              type="button"
              @click="showDeleteModal = false"
              class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors duration-200"
            >
              Cancel
            </button>
            <button
              @click="deleteUser"
              class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors duration-200"
              :disabled="editForm.processing"
              :class="{ 'opacity-50 cursor-not-allowed': editForm.processing }"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
/* Modal animations */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
.rounded-2xl {
  border-radius: 1rem;
}
.shadow-lg {
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}
.transition-colors {
  transition: color 0.2s ease, background-color 0.2s ease;
}
</style>