<!-- src/components/Chat.vue -->
<template>
  <div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <!-- Single Container -->
    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-100/50 overflow-hidden">
      <div class="flex h-[calc(100vh-3rem)]">
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
              class="w-12 h-12 rounded-full object-cover border-2 border-indigo-200 flex-shrink-0 transition-transform duration-200 hover:scale-105"
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
              class="w-12 h-12 rounded-full object-cover border-2 border-indigo-200 transition-transform duration-200 hover:scale-105"
            />
            <div class="ml-3">
              <p class="text-sm font-medium text-gray-800">{{ receiver.name }}</p>
              <p class="text-xs text-gray-500">{{ receiver.role }}</p>
            </div>
          </div>

          <!-- Messages -->
          <div class="messages flex-1 overflow-y-auto p-6 space-y-4">
            <div
              v-for="message in messages"
              :key="message.id"
              :class="[
                'message flex flex-col max-w-xs sm:max-w-md',
                message.sender_id === currentUser.id ? 'ml-auto items-end' : 'mr-auto items-start'
              ]"
            >
              <div
                :class="[
                  'p-3 rounded-2xl text-sm',
                  message.sender_id === currentUser.id
                    ? 'bg-indigo-500 text-white'
                    : 'bg-gray-200 text-gray-800'
                ]"
              >
                <div v-if="message.message" class="text">{{ message.message }}</div>
                <img
                  v-if="message.image_url"
                  :src="message.image_url"
                  :alt="message.image_original_name"
                  class="message-image mt-2 rounded-md max-w-full"
                />
              </div>
              <div class="text-xs text-gray-500 mt-1">
                {{ formatTime(message.created_at) }}
              </div>
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
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { Paperclip, Send } from 'lucide-vue-next';

// Access props from Inertia
const props = defineProps({
  conversations: Array,
  messages: Array,
  receiver: Object,
  currentUser: Object,
});

const newMessage = ref('');
const selectedImage = ref(null);
const fileInput = ref(null);

// Methods
const selectConversation = (contactId) => {
  router.visit(route('chat.index', contactId));
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