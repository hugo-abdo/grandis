<template>
	<jet-dropdown
		align="right"
		width="72"
		contentClasses="bg-white duration-200 overflow-hidden dark:bg-groadis-dark mt-5"
		triggerClasses="w-5 h-5 cursor-pointer"
	>
		<template #trigger>
			<span
				v-if="$store.getters.hasNotificatios"
				class="bg-red-500 w-2.5 h-2.5 absolute top-0.5 animate-ping right-0.5  ring-white rounded-full"
			></span>
			<span
				v-if="$store.getters.hasNotificatios"
				class="bg-red-500 w-1.5 h-1.5 absolute top-1 right-1 ring-1 ring-white rounded-full"
			></span>
			<i class="las la-bell text-xl text-gray-400 mr-2 "></i>
		</template>

		<template #content>
			<div class="max-h-[calc(100vh/2)] overflow-y-auto select-none scrollbar-thumb-rounded-full scrollbar-thin dark:scrollbar-thumb-gray-600 scrollbar-thumb-gray-200">
				<div
					@click="readNotification(notification)"
					v-for="notification in $store.state.notifications"
					:key="notification.id"
					class="relative flex items-center p-2 border-b border-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 dark:border-gray-700"
					:class="!notification.read_at ? 'bg-groadis cursor-pointer bg-opacity-20' : ''"
				>
					<span
						:class="notification.read_at ? 'bg-gray-300' : 'bg-groadis'"
						class="absolute right-2 top-1/2 w-2 h-2 rounded-full"
					></span>
					<img
						class="flex-shrink-0 object-cover w-8 h-8 mx-1 rounded-full ring-2"
						:src="notification.user.profile_photo_url"
						alt="avatar"
					/>
					<p class="mx-2 text-sm text-gray-600 dark:text-white">
						<span class="font-bold text-groadis">{{notification.user.name}}</span>
						{{notification.message}}
						<span class="block text-xs text-gray-400">{{notification.created_at}}</span>
					</p>
				</div>
			</div>
			<a
				v-if="$store.state.notifications.length"
				href="#"
				class="block select-none py-2 font-bold text-center text-gray-700 dark:text-white bg-white dark:bg-gray-700 hover:underline"
			>See all notifications</a>
			<span
				v-else
				class="block select-none py-2 font-bold text-center text-gray-700 dark:text-white bg-white dark:bg-gray-700"
			>you don't have notification</span>
		</template>
	</jet-dropdown>
</template>

<script>
import JetDropdown from "@/components/Dropdown.vue";
import { computed, onMounted, ref } from "vue";
import { useStore } from "vuex";
import { usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default {
	components: {
		JetDropdown,
	},
	setup() {
		const page = usePage().props.value;
		const user = ref(page.user).value;
		const { state, commit } = useStore();

		state.notifications = page.notifications.data;

		!state.Echo.connector.channels[`private-App.Models.User.${user.id}`] &&
			state.Echo.private(`App.Models.User.${user.id}`).notification((n) =>
				commit("HANDEL_NOTIFICATIONS", n)
			);

		function readNotification(notification) {
			state.hasNotificatios = false;
			if (!notification.read_at) {
				Inertia.get(
					route("readNotification", notification.id),
					{},
					{
						preserveState: true,
						preserveScroll: true,
						onSuccess(page) {
							state.notifications = page.props.notifications.data;
						},
					}
				);
			}
		}

		return { readNotification };
	},
};
</script>