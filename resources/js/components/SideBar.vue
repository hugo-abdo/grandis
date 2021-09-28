<template>
	<!-- Primary Navigation Menu -->
	<nav
		@mouseenter="$store.state.sideBarActive = true"
		@mouseleave="$store.state.sideBarActive = false"
		:class="[
		'fixed inset-y-0 duration-200 z-50 hidden sm:block  overflow-hidden',
		$store.state.sideBarActive ? 'w-52': 'w-12'
	]"
	>
		<div class="pl-1 relative bg-white duration-200 shadow-md h-full dark:bg-groadis-dark">
			<div class="p-3">
				<jet-application-mark />
			</div>

			<template v-for="link in links">
				<side-bar-link
					v-if="link.condition"
					:active="route().current(link.isActive)"
				>
					<jet-nav-link
						:href="route(link.pathName)"
						class="capitalize group"
					>
						<i
							:class="link.iconClass"
							class="text-xl mr-2"
						></i>
						<span class="group-hover:ml-4 ml-2 duration-200">{{link.name}}</span>
					</jet-nav-link>
				</side-bar-link>
			</template>
		</div>
	</nav>
</template>

<script>
import JetNavLink from "@/components/NavLink.vue";
import JetDropdown from "@/components/Dropdown.vue";
import JetDropdownLink from "@/components/DropdownLink.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetApplicationMark from "@/components/ApplicationMark.vue";
import { useDark } from "@vueuse/core";
import SideBarLink from "./SideBarLink.vue";

export default {
	props: ["links"],
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