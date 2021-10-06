<template>

	<Head :title="title" />
	<banners />
	<div class="pt-1">
		<nav
			v-if="$page.props.user"
			:class="[
				'fixed inset-x-0 sm:right-4 top-0 rounded-b-lg z-50 bg-white dark:bg-groadis-dark border-b shadow border-gray-100 duration-200 dark:border-groadis-dark',
				$store.state.sideBarActive ? 'left-[11.5rem]': 'sm:left-14'
				]"
		>
			<!-- Primary Navigation Menu -->
			<div class="px-4 sm:px-6 lg:px-8">
				<div class="flex justify-between items-center py-2.5">
					<button
						@click="$store.state.sideBarActive = !$store.state.sideBarActive"
						class="text-gray-400 focus:outline-none"
					>
						<svg
							class="h-6 w-6"
							stroke="currentColor"
							fill="none"
							viewBox="0 0 24 24"
						>
							<path
								:class="{'hidden': $store.state.sideBarActive, 'inline-flex': ! $store.state.sideBarActive }"
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="M4 6h16M4 12h16M4 18h16"
							/>
							<path
								:class="{'hidden': ! $store.state.sideBarActive, 'inline-flex': $store.state.sideBarActive }"
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="M6 18L18 6M6 6l12 12"
							/>
						</svg>
					</button>

					<div class="flex items-center space-x-3">
						<notifications />
						<i
							@click="toggleDark"
							:class="isDark ?'las la-sun ' : 'las la-moon'"
							class="text-xl text-gray-400 pt-1 cursor-pointer duration-200"
						></i>

						<div class="sm:flex sm:items-center">
							<!-- Settings Dropdown -->
							<div class="relative">
								<jet-dropdown
									align="right"
									width="56"
									contentClasses="bg-white duration-200 dark:bg-groadis-dark mt-2"
								>
									<template #trigger>
										<button
											v-if="$page.props.jetstream.managesProfilePhotos"
											class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition"
										>
											<img
												class="h-8 w-8 rounded-full object-cover"
												:src="$page.props.user.profile_photo_url"
												:alt="$page.props.user.name"
											/>
										</button>

										<span
											v-else
											class="inline-flex rounded-md"
										>
											<button
												type="button"
												class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition"
											>
												{{ $page.props.user.name }}
												<svg
													class="ml-2 -mr-0.5 h-4 w-4"
													xmlns="http://www.w3.org/2000/svg"
													viewBox="0 0 20 20"
													fill="currentColor"
												>
													<path
														fill-rule="evenodd"
														d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
														clip-rule="evenodd"
													/>
												</svg>
											</button>
										</span>
									</template>

									<template #content>
										<div class="block px-4 py-2 text-xs text-gray-400 capitalize">
											<span class="block mb-1">signed in as:</span>
											<span class="text-gray-500 font-semibold">{{$page.props.user.name}}</span>
										</div>
										<div class="border-t border-gray-100"></div>
										<!-- Account Management -->
										<div class="block px-4 py-2 text-xs text-gray-400">Manage Account</div>

										<jet-dropdown-link :href="route('profile.show')">Profile</jet-dropdown-link>

										<jet-dropdown-link
											:href="route('api-tokens.index')"
											v-if="$page.props.jetstream.hasApiFeatures"
										>API Tokens</jet-dropdown-link>

										<div class="border-t border-gray-100"></div>

										<!-- Authentication -->
										<form @submit.prevent="logout">
											<jet-dropdown-link as="button">Log Out</jet-dropdown-link>
										</form>
									</template>
								</jet-dropdown>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>

		<side-bar
			:links="links"
			v-if="links.length && $page.props.user"
			:key="route().current()"
		/>
		<!-- Page Content -->
		<main :class="[
				'mt-20 px-5 sm:pr-4 duration-200 max-w-7xl mx-auto',
				$store.state.sideBarActive ? 'pl-[11.5rem] max-w-full': 'sm:pl-14'
			]">
			<slot></slot>
		</main>
	</div>
</template>

<script>
import { computed, defineComponent, onUnmounted, ref } from "vue";
import JetApplicationMark from "@/components/ApplicationMark.vue";
import JetDropdown from "@/components/Dropdown.vue";
import JetDropdownLink from "@/components/DropdownLink.vue";
import JetNavLink from "@/components/NavLink.vue";
import JetResponsiveNavLink from "@/components/ResponsiveNavLink.vue";
import { Head, Link, usePage } from "@inertiajs/inertia-vue3";
import { isDark, toggleDark } from "@/mixins/useDarkMode.js";
import { Inertia } from "@inertiajs/inertia";
import can from "@/mixins";
import SideBar from "@/components/SideBar.vue";
import { useStore } from "vuex";
import Notifications from "../components/Notifications.vue";
import Banners from "../components/Banners.vue";

export default defineComponent({
	props: { title: String },
	inheritAttrs: false,
	components: {
		Head,
		JetApplicationMark,
		JetDropdown,
		JetDropdownLink,
		JetNavLink,
		JetResponsiveNavLink,
		Link,
		SideBar,
		Notifications,
		Banners,
	},

	setup() {
		const { state } = useStore();
		state.isDark = isDark;

		const showingNavigationDropdown = ref(true);
		const links = [
			{
				name: "dashboard",
				pathName: "dashboard",
				iconClass: "las la-tachometer-alt",
				condition: true,
				isActive: "dashboard",
			},
			{
				name: "users",
				pathName: "users.index",
				iconClass: "las la-user-friends",
				condition: true,
				isActive: "users.*",
			},
			{
				name: "products",
				pathName: "products.index",
				iconClass: "las la-shopping-bag",
				condition: true,
				isActive: "products.*",
			},
			{
				name: "roles",
				pathName: "roles.index",
				iconClass: "las la-user-shield",
				condition: true,
				isActive: "roles.*",
			},
			{
				name: "shop",
				pathName: "shop.index",
				iconClass: "las la-store-alt",
				condition: true,
				isActive: "shop.*",
			},
		];

		function logout() {
			Inertia.post(route("logout"));
		}
		return { logout, isDark, toggleDark, showingNavigationDropdown, links };
	},
});
</script>