<!-- src/components/Chat.vue -->
<template>
  <Navbar />
  <div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <!-- Single Container -->
    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-100/50 overflow-hidden">
      <!-- Searchable Farmer Dropdown -->
      <div class="p-4 border-b border-gray-200 bg-gray-50">
        <div class="relative w-full max-w-md mx-auto">
          <input
            v-model="farmerSearch"
            @input="filterFarmers"
            placeholder="Search farmers..."
            class="w-full p-3 rounded-md border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm bg-white"
          />
          <div v-if="farmerSearch && filteredFarmers.length" class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
            <div
              v-for="farmer in filteredFarmers"
              :key="farmer.id"
              @click="selectConversation(farmer.id)"
              class="p-3 hover:bg-indigo-50 cursor-pointer flex items-center"
            >
              <img
                :src="farmer.profile_picture ? `/storage/${farmer.profile_picture}` : '/images/default-profile-picture.jpg'"
                :alt="`${farmer.name}'s Profile Picture`"
                class="w-8 h-8 rounded-full object-cover mr-2"
              />
              <span>{{ farmer.name }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="flex h-[calc(100vh-8rem)]">
        <!-- Conversation List -->
        <div class="conversation-list w-80 bg-gray-50 border-r border-gray-100/50 overflow-y-auto">
          <div class="p-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Conversations</h2>
            <!-- Back Button -->
            <button
              @click="goBack"
              class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors"
              title="Back to Previous Page"
            >
              <svg
                class="h-5 w-5 mr-1"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 19l-7-7 7-7"
                />
              </svg>
              Back
            </button>
          </div>
          <div
            v-for="conversation in conversations"
            :key="conversation.contact_id"
            @click="selectConversation(conversation.contact_id)"
            :class="[
              'contact-item flex items-center p-4 cursor-pointer transition-colors duration-200',
              receiver && receiver.id === conversation.contact_id
                ? 'bg-indigo-50 border-l-4 border-indigo-500'
                : 'hover:bg-gray-100'
            ]"
          >
            <img
              :src="conversation.contact?.profile_picture ? `/storage/${conversation.contact.profile_picture}` : '/images/default-profile-picture.jpg'"
              :alt="`${conversation.contact.name}'s Profile Picture`"
              class="w-12 h-12 rounded-full object-cover border-2 border-indigo-200 flex-shrink-0"
            />
            <div class="ml-3 flex-1">
              <p class="text-sm font-medium text-gray-800">{{ conversation.contact.name }}</p>
              <p class="text-xs text-gray-500">{{ conversation.contact.role }}</p>
            </div>
            <div class="text-xs text-gray-400">
              {{ formatTime(conversation.last_message_time) }}
            </div>
          </div>
        </div>

        <!-- Chat Window -->
        <div v-if="receiver" class="chat-window flex-1 flex flex-col">
          <!-- Chat Header -->
          <div class="p-4 border-b border-gray-100 flex items-center bg-gray-50">
            <img
              :src="receiver?.profile_picture ? `/storage/${receiver.profile_picture}` : '/images/default-profile-picture.jpg'"
              :alt="`${receiver.name}'s Profile Picture`"
              class="w-12 h-12 rounded-full object-cover border-2 border-indigo-200"
            />
            <div class="ml-3">
              <p class="text-sm font-medium text-gray-800">{{ receiver.name }}</p>
              <p class="text-xs text-gray-500">{{ receiver.role }}</p>
            </div>
          </div>

          <!-- Messages -->
          <div class="messages flex-1 overflow-y-auto p-6 space-y-4 relative" ref="messagesContainer">
            <div
              v-for="message in messages"
              :key="message.id"
              @contextmenu.prevent="showContextMenu($event, message)"
              :class="[
                'message flex flex-col max-w-xs sm:max-w-md',
                message.sender_id === currentUser.id ? 'ml-auto items-end' : 'mr-auto items-start'
              ]"
            >
              <div
                v-if="editingMessage?.id === message.id"
                class="w-full"
              >
                <form @submit.prevent="updateMessage(message)">
                  <div class="flex items-center gap-2">
                    <input
                      v-model="editingMessage.message"
                      placeholder="Edit your message..."
                      class="flex-1 p-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm bg-white"
                    />
                    <button
                      type="button"
                      @click="$refs.editFileInput.click()"
                      class="p-2 rounded-full bg-white hover:bg-gray-100 border border-gray-200"
                    >
                      <Paperclip class="w-4 h-4 text-gray-600" />
                    </button>
                    <input
                      type="file"
                      ref="editFileInput"
                      @change="handleEditImageUpload"
                      accept="image/*"
                      class="hidden"
                    />
                    <button
                      type="submit"
                      class="p-2 rounded-full bg-indigo-500 hover:bg-indigo-600 text-white"
                    >
                      <Send class="w-4 h-4" />
                    </button>
                    <button
                      type="button"
                      @click="cancelEdit"
                      class="p-2 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-600"
                    >
                      Cancel
                    </button>
                  </div>
                </form>
              </div>
              <div
                v-else
                :class="[
                  'p-3 rounded-2xl text-sm',
                  message.sender_id === currentUser.id
                    ? 'bg-indigo-500 text-white'
                    : 'bg-gray-200 text-gray-800'
                ]"
              >
                <div v-if="message.message" class="text">{{ message.message }}</div>
                <img
                  v-if="message.image_path"
                  :src="`/storage/${message.image_path}`"
                  :alt="message.image_original_name"
                  class="message-image mt-2 rounded-md max-w-full"
                />
              </div>
              <div class="text-xs text-gray-500 mt-1">
                {{ formatTime(message.created_at) }}
                <span v-if="message.updated_at !== message.created_at"> (Edited)</span>
              </div>
            </div>

            <!-- Context Menu -->
            <div
              v-if="contextMenu.visible"
              :style="{ top: contextMenu.y + 'px', left: contextMenu.x + 'px' }"
              class="absolute z-20 bg-white border border-gray-200 rounded-lg shadow-lg py-2 w-32"
            >
              <button
                @click="editMessage(contextMenu.message)"
                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50"
              >
                Edit
              </button>
              <button
                @click="confirmDelete(contextMenu.message)"
                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"
              >
                Delete
              </button>
            </div>
          </div>

          <!-- Message Input -->
          <form
            @submit.prevent="sendMessage"
            class="message-input p-4 bg-gray-50 border-t border-gray-100 flex items-center gap-3"
          >
            <input
              v-model="newMessage"
              placeholder="Type your message..."
              class="message-text-input flex-1 p-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm bg-white"
            />
            <button
              type="button"
              @click="$refs.fileInput.click()"
              class="p-2.5 rounded-full bg-white hover:bg-gray-100 transition-colors border border-gray-200"
              title="Send Image"
            >
              <Paperclip class="w-5 h-5 text-gray-600" />
            </button>
            <input
              type="file"
              ref="fileInput"
              @change="handleImageUpload"
              accept="image/*"
              class="hidden"
            />
            <button
              type="submit"
              class="p-2.5 rounded-full bg-indigo-500 hover:bg-indigo-600 transition-colors"
              title="Send Message"
            >
              <Send class="w-5 h-5 text-white" style="transform: rotate(45deg);" />
            </button>
          </form>
        </div>
        <div v-else class="flex-1 flex items-center justify-center bg-white">
          <p class="text-gray-500 text-sm">Select a conversation to start chatting</p>
        </div>
      </div>
    </div>
  </div>
  <Footerr />
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import { Paperclip, Send } from 'lucide-vue-next';
import Navbar from '@/components/Navbar.vue';
import Footerr from '@/components/home/footer.vue';
import MainLayout from '@/layouts/MainLayout.vue';

defineOptions({
  layout: MainLayout,
});

// Access props from Inertia
const props = defineProps({
  conversations: Array,
  messages: Array,
  receiver: Object,
  currentUser: Object,
  farmers: Array,
});

const newMessage = ref('');
const selectedImage = ref(null);
const fileInput = ref(null);
const farmerSearch = ref('');
const contextMenu = ref({ visible: false, x: 0, y: 0, message: null });
const editingMessage = ref(null);
const editFileInput = ref(null);
const messagesContainer = ref(null);

// Filter farmers based on search input
const filteredFarmers = computed(() => {
  if (!farmerSearch.value) return props.farmers;
  return props.farmers.filter(farmer =>
    farmer.name.toLowerCase().includes(farmerSearch.value.toLowerCase())
  );
});

// Methods
const selectConversation = (contactId) => {
  if (contactId) {
    router.visit(route('chat.index', contactId));
    farmerSearch.value = ''; // Reset search input
  }
};

const sendMessage = () => {
  if (!newMessage.value && !selectedImage.value) return;

  const formData = new FormData();
  formData.append('receiver_id', props.receiver.id);
  if (newMessage.value) formData.append('message', newMessage.value);
  if (selectedImage.value) formData.append('image', selectedImage.value);

  router.post(route('chat.store'), formData, {
    onSuccess: () => {
      newMessage.value = '';
      selectedImage.value = null;
      fileInput.value.value = '';
    },
  });
};

const handleImageUpload = (event) => {
  selectedImage.value = event.target.files[0];
  sendMessage();
};

const formatTime = (time) => {
  return new Date(time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
};

// Context Menu Logic
const showContextMenu = (event, message) => {
  if (message.sender_id !== props.currentUser.id) return; // Only show for own messages
  contextMenu.value = {
    visible: true,
    x: event.clientX,
    y: event.clientY,
    message,
  };
};

const hideContextMenu = () => {
  contextMenu.value = { visible: false, x: 0, y: 0, message: null };
};

const editMessage = (message) => {
  editingMessage.value = { id: message.id, message: message.message };
  hideContextMenu();
};

const handleEditImageUpload = (event) => {
  editingMessage.value.image = event.target.files[0];
};

const updateMessage = (message) => {
  if (!editingMessage.value.message && !editingMessage.value.image) return;

  const formData = new FormData();
  formData.append('_method', 'PUT');
  formData.append('message', editingMessage.value.message || '');
  if (editingMessage.value.image) formData.append('image', editingMessage.value.image);

  router.post(route('chat.update', message.id), formData, {
    onSuccess: () => {
      editingMessage.value = null;
      editFileInput.value.value = '';
    },
  });
};

const confirmDelete = (message) => {
  if (confirm('Are you sure you want to delete this message?')) {
    router.delete(route('chat.destroy', message.id));
  }
  hideContextMenu();
};

const cancelEdit = () => {
  editingMessage.value = null;
  editFileInput.value.value = '';
};

// Handle clicks outside context menu to close it
const handleClickOutside = (event) => {
  if (contextMenu.value.visible && !event.target.closest('.context-menu')) {
    hideContextMenu();
  }
};

// Lifecycle hooks
onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});

// Back button handler
const goBack = () => {
  window.history.back();
};
</script>

<style scoped>
.rounded-2xl {
  border-radius: 1rem;
}

.shadow-xl {
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.border-gray-100 {
  border-color: rgba(243, 244, 246, 0.5);
}

.transition-colors {
  transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
}

.transition-transform {
  transition: transform 0.3s ease;
}

.message-image {
  max-width: 100%;
  height: auto;
}

.messages {
  scroll-behavior: smooth;
}
</style>