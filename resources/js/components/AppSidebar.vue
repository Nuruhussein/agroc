<!-- AppSidebar.vue -->
<script setup lang="ts">
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, Home, ShoppingCart, Tag, ClipboardList,MessageCircle } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

// Access user role from Inertia props
const page = usePage<SharedData>();
const userRole = computed(() => page.props.auth.user?.role || null);

// Define all navigation items
const allNavItems: NavItem[] = [
  {
    title: 'Dashboard',
    href: route('dashboard'),
    icon: Home,
  },
  {
    title: 'Produces',
    href: route('produce.index'),
    icon: ShoppingCart,
  },
  {
    title: 'Category',
    href: route('categories.index'),
    icon: Tag,
  },
  {
    title: 'Orders',
    href: route('orders.index'),
    icon: ClipboardList,
  },
    {
    title: 'manage Users',
    href: route('admin.users'),
    icon: ClipboardList,
  },
    {
    title: 'my Orders',
    href: route('farmer.orders.index'),
    icon: ClipboardList,
  },
    {
    title: 'Chats',
    href: route('chat.index'),
    icon: MessageCircle ,
  },
  {
    title: 'Reports',
    href: route('admin.reports.index'),
    icon: BookOpen,
  },
 
];

// Filter navigation items based on user role
const mainNavItems = computed(() => {
  if (!userRole.value) {
    return []; // No user logged in
  }

  switch (userRole.value) {
    case 'buyer':
      return allNavItems.filter((item) => ['Orders', 'createOrders','Chats'].includes(item.title));
    case 'admin':
      return  allNavItems.filter((item) => item.title !== 'my Orders');
    case 'farmer':
      return allNavItems.filter((item) => item.title !== 'Category' && item.title !== 'Orders' && item.title !== 'manage Users' && item.title !== 'Reports');
    default:
      return []; // Unknown role
  }
});


</script>

<template>
  <Sidebar collapsible="icon" variant="inset">
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton size="lg" as-child>
            <Link :href="route('home')" class="flex items-center justify-center">
              <AppLogo />
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>

    <SidebarContent>
      <NavMain v-if="mainNavItems.length" :items="mainNavItems" />
      <div v-else class="p-4 text-gray-500 text-sm">
        Please log in to view navigation.
      </div>
    </SidebarContent>

    <SidebarFooter>
      <NavFooter :items="footerNavItems" />
      <NavUser />
    </SidebarFooter>
  </Sidebar>
  <slot />
</template>