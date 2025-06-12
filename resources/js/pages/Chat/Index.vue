<template>
  <div class="chat-container">
    <div class="conversation-list">
      <div
        v-for="conversation in conversations"
        :key="conversation.contact_id"
        @click="selectConversation(conversation.contact_id)"
        :class="['contact-item', { active: receiver && receiver.id === conversation.contact_id }]"
      >
        {{ conversation.contact.name }} ({{ conversation.contact.role }})
      </div>
    </div>

    <div class="chat-window" v-if="receiver">
      <div class="messages">
        <div
          v-for="message in messages"
          :key="message.id"
          :class="['message', message.sender_id === currentUser.id ? 'sent' : 'received']"
        >
          <div v-if="message.message" class="text">{{ message.message }}</div>
          <img
            v-if="message.image_url"
            :src="message.image_url"
            :alt="message.image_original_name"
            class="message-image"
          />
          <div class="timestamp">{{ formatTime(message.created_at) }}</div>
        </div>
      </div>

      <form @submit.prevent="sendMessage" class="message-input">
        <input
          v-model="newMessage"
          placeholder="Type your message..."
          class="message-text-input"
        />
        <input
          type="file"
          ref="fileInput"
          @change="handleImageUpload"
          accept="image/*"
          style="display: none"
        />
        <button type="button" @click="$refs.fileInput.click()">Send Image</button>
        <button type="submit">Send</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

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
</script>


<style scoped>
.chat-container {
  display: flex;
  height: 100vh;
}

.conversation-list {
  width: 300px;
  border-right: 1px solid #ccc;
  overflow-y: auto;
}

.contact-item {
  padding: 10px;
  cursor: pointer;
}

.contact-item.active {
  background-color: #e0e0e0;
}

.chat-window {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.messages {
  flex: 1;
  overflow-y: auto;
  padding: 20px;
}

.message {
  margin-bottom: 10px;
  max-width: 60%;
}

.message.sent {
  margin-left: auto;
  text-align: right;
}

.message.received {
  margin-right: auto;
}

.message-image {
  max-width: 200px;
  margin-top: 5px;
}

.message-input {
  display: flex;
  padding: 10px;
  border-top: 1px solid #ccc;
}

.message-text-input {
  flex: 1;
  margin-right: 10px;
}
</style>