<template>
  <div
    id="app"
    class="wrapper"
  >
    <sidebar-component v-if="AuthUser" />

    <div class="main">
      <topbar-component v-if="AuthUser" />

      <main class="content">
        <slot />
      </main>

      <footer-component />
    </div>
  </div>
</template>
<script>
import SidebarComponent from './SidebarComponent.vue';
import TopbarComponent from './TopbarComponent.vue';
import FooterComponent from './FooterComponent.vue';
import { usePage } from '@inertiajs/inertia-vue3';

export default {
	components: { SidebarComponent, TopbarComponent, FooterComponent },
	computed: {
		AuthUser() {
			return usePage().props.value.AuthUser;
		}
	}
};
</script>
