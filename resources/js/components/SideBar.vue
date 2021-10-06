<template>
	<!-- Primary Navigation Menu -->
	<nav :class="[
			'fixed inset-y-0 duration-200 z-[49] overflow-hidden',
			$store.state.sideBarActive ? 'w-44': 'w-0 sm:w-12'
		]">
		<div class="pl-2 relative bg-white duration-200 shadow-md h-full dark:bg-groadis-dark">

			<div class="p-3 pl-1.5">
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
							v-tooltip.right-end="!$store.state.sideBarActive &&link.name"
							:class="[link.iconClass,{'bg-groadis px-1 text-white rounded-md shadow-groadis':route().current(link.isActive)}]"
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