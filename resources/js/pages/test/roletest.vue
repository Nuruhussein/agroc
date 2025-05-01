
<script setup>
import { Head } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Role Test" />
  
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full">
      <h1 class="text-2xl font-bold mb-4">Role Test Component</h1>
      
      <div v-if="$page.props.auth.user" class="space-y-4">
        <div class="p-4 bg-blue-50 rounded">
          <h2 class="font-semibold">User Information</h2>
          <p>Name: {{ $page.props.auth.user.name }}</p>
          <p>Email: {{ $page.props.auth.user.email }}</p>
          <p class="font-bold">Role: {{ $page.props.auth.user.role }}</p>
        </div>
        
        <div v-if="$page.props.auth.user.role === 'admin'" class="p-4 bg-green-50 rounded">
          <p>You have <span class="font-bold">Admin</span> privileges</p>
        </div>
        
        <div v-if="$page.props.auth.user.role === 'farmer'" class="p-4 bg-yellow-50 rounded">
          <p>You have <span class="font-bold">Farmer</span> privileges</p>
        </div>
        
        <div v-if="$page.props.auth.user.role === 'buyer'" class="p-4 bg-purple-50 rounded">
          <p>You have <span class="font-bold">Buyer</span> privileges</p>
        </div>
      </div>
      
      <div v-else class="p-4 bg-red-50 rounded">
        <p>No user logged in</p>
        <p class="text-sm text-gray-600">(Try logging in to see your role)</p>
      </div>
    </div>
  </div>
</template>