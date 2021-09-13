<template>
	<div class="antialiased">
		<Head :title="title" />

		<jet-banner />

		<div class="min-h-screen bg-gray-100 duration-200 dark:bg-groadis-darker">
			<nav
				class="bg-white dark:bg-groadis-dark border-b shadow border-gray-100 duration-200 dark:border-groadis-dark"
			>
				<!-- Primary Navigation Menu -->
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<div class="flex justify-between items-center py-2">
						<div class="flex-shrink-0 flex items-center">
							<Link :href="route('dashboard')">
								<jet-application-mark :isDark="isDark" />
							</Link>
						</div>

						<div class="flex items-center">
							<i
								@click="toggleDark"
								:class="isDark ?'lar la-sun text-white' : 'lar la-moon text-groadis'"
								class="cursor-pointer duration-200 dark:bg-groadis-darker bg-gray-200 rounded-full leading-none p-1 shadow-inner"
							></i>

							<div class="hidden sm:flex sm:items-center">
								<!-- Settings Dropdown -->
								<div class="ml-3 relative">
									<jet-dropdown
										align="right"
										width="48"
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

											<span v-else class="inline-flex rounded-md">
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

						<!-- Hamburger -->
						<div class="-mr-2 flex items-center sm:hidden">
							<button
								@click="showingNavigationDropdown = ! showingNavigationDropdown"
								class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition"
							>
								<svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
									<path
										:class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
										stroke-linecap="round"
										stroke-linejoin="round"
										stroke-width="2"
										d="M4 6h16M4 12h16M4 18h16"
									/>
									<path
										:class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
										stroke-linecap="round"
										stroke-linejoin="round"
										stroke-width="2"
										d="M6 18L18 6M6 6l12 12"
									/>
								</svg>
							</button>
						</div>
					</div>
				</div>

				<!-- Responsive Navigation Menu -->
				<div
					:class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}"
					class="sm:hidden"
				>
					<div class="pt-2 pb-3 space-y-1">
						<jet-responsive-nav-link
							:href="route('dashboard')"
							:active="route().current('dashboard')"
						>Dashboard</jet-responsive-nav-link>
					</div>

					<!-- Responsive Settings Options -->
					<div class="pt-4 pb-1 border-t border-gray-200">
						<div class="flex items-center px-4">
							<div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3">
								<img
									class="h-10 w-10 rounded-full object-cover"
									:src="$page.props.user.profile_photo_url"
									:alt="$page.props.user.name"
								/>
							</div>

							<div>
								<div
									class="font-medium text-base text-gray-800 duration-200 dark:text-gray-200"
								>{{ $page.props.user.name }}</div>
								<div
									class="font-medium text-sm text-gray-500 duration-200 dark:text-gray-400"
								>{{ $page.props.user.email }}</div>
							</div>
						</div>

						<div class="mt-3 space-y-1">
							<jet-responsive-nav-link
								:href="route('profile.show')"
								:active="route().current('profile.show')"
							>Profile</jet-responsive-nav-link>

							<jet-responsive-nav-link
								:href="route('api-tokens.index')"
								:active="route().current('api-tokens.index')"
								v-if="$page.props.jetstream.hasApiFeatures"
							>API Tokens</jet-responsive-nav-link>

							<!-- Authentication -->
							<form method="POST" @submit.prevent="logout">
								<jet-responsive-nav-link as="button">Log Out</jet-responsive-nav-link>
							</form>

							<!-- Team Management -->
							<template v-if="$page.props.jetstream.hasTeamFeatures">
								<div class="border-t border-gray-200"></div>

								<div class="block px-4 py-2 text-xs text-gray-400">Manage Team</div>

								<!-- Team Settings -->
								<jet-responsive-nav-link
									:href="route('teams.show', $page.props.user.current_team)"
									:active="route().current('teams.show')"
								>Team Settings</jet-responsive-nav-link>

								<jet-responsive-nav-link
									:href="route('teams.create')"
									:active="route().current('teams.create')"
									v-if="$page.props.jetstream.canCreateTeams"
								>Create New Team</jet-responsive-nav-link>

								<div class="border-t border-gray-200"></div>

								<!-- Team Switcher -->
								<div class="block px-4 py-2 text-xs text-gray-400">Switch Teams</div>

								<template v-for="team in $page.props.user.all_teams" :key="team.id">
									<form @submit.prevent="switchToTeam(team)">
										<jet-responsive-nav-link as="button">
											<div class="flex items-center">
												<svg
													v-if="team.id == $page.props.user.current_team_id"
													class="mr-2 h-5 w-5 text-green-400"
													fill="none"
													stroke-linecap="round"
													stroke-linejoin="round"
													stroke-width="2"
													stroke="currentColor"
													viewBox="0 0 24 24"
												>
													<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
												</svg>
												<div>{{ team.name }}</div>
											</div>
										</jet-responsive-nav-link>
									</form>
								</template>
							</template>
						</div>
					</div>
				</div>
			</nav>
			<nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-3 hidden sm:block" v-if="links.length">
				<navbar :links="links" />
			</nav>

			<!-- Page Content -->
			<main class="py-12">
				<div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
					<slot></slot>
				</div>
			</main>
		</div>
	</div>
</template>

<script>
import { defineComponent, ref } from "vue";
import JetApplicationMark from "@/Jetstream/ApplicationMark.vue";
import JetBanner from "@/Jetstream/Banner.vue";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import JetNavLink from "@/Jetstream/NavLink.vue";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Navbar from "../components/Navbar.vue";
import { useDark, useToggle } from "@vueuse/core";
import { Inertia } from "@inertiajs/inertia";
import can from "@/mixins";

export default defineComponent({
	props: { title: String },

	components: {
		Head,
		JetApplicationMark,
		JetBanner,
		JetDropdown,
		JetDropdownLink,
		JetNavLink,
		JetResponsiveNavLink,
		Link,
		Navbar,
	},

	setup() {
		const showingNavigationDropdown = ref(false);
		const links = [
			{
				name: "dashboard",
				pathName: "dashboard",
				badge: 9,
				iconClass: "las la-home",
				condition: true,
			},
			{
				name: "users",
				pathName: "users.index",
				iconClass: "las la-users",
				condition: can("show_user"),
			},
			{
				name: "roles",
				pathName: "roles.index",
				iconClass: "las la-user-shield",
				condition: can("show_role"),
			},
		];

		function logout() {
			Inertia.post(route("logout"));
		}

		const isDark = useDark();
		const toggleDark = useToggle(isDark);

		return { logout, isDark, toggleDark, showingNavigationDropdown, links };
	},
});
</script>