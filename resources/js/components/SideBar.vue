<template>
	<!-- Primary Navigation Menu -->
	<nav
		@mouseenter="$store.state.sideBarActive = true"
		@mouseleave="$store.state.sideBarActive = false"
		:class="[
		'fixed inset-y-0 top-14 duration-200 overflow-hidden z-50 hidden sm:block',
		$store.state.sideBarActive ? 'w-52': 'w-12'
	]"
	>
		<div class="pl-2 bg-white duration-200 h-full shadow-md dark:bg-groadis-dark" ref="container">
			<template v-for="link in links" :key="link.name">
				<side-bar-link v-if="link.condition" :active="route().current(link.pathName)">
					<jet-nav-link :href="route(link.pathName)" class="capitalize group">
						<i :class="link.iconClass" class="text-xl mr-2"></i>
						<span class="group-hover:ml-2 duration-200">{{link.name}}</span>
					</jet-nav-link>
				</side-bar-link>
			</template>
		</div>
	</nav>
</template>

<script>
import JetNavLink from "@/Jetstream/NavLink.vue";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetApplicationMark from "@/Jetstream/ApplicationMark.vue";
import { useDark } from "@vueuse/core";
import SideBarLink from "./SideBarLink.vue";

export default {
	props: { links: Array },
	components: {
		JetNavLink,
		JetDropdown,
		JetDropdownLink,
		Link,
		JetApplicationMark,
		SideBarLink,
	},
};
</script>