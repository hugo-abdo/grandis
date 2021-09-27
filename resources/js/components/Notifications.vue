<template>
	<jet-dropdown
		align="right"
		width="72"
		contentClasses="bg-white duration-200 overflow-hidden dark:bg-groadis-dark mt-5"
		triggerClasses="w-5 h-5 cursor-pointer"
		@click="$store.state.hasNotificatios = false"
	>
		<template #trigger>
			<span
				v-if="$store.state.hasNotificatios"
				class="bg-red-50 text-red-400 border border-red-400 leading-none text-[0.6rem] p-0.5 pb-1 absolute shadow-md -top-1.5 -right-1.5 rounded-full"
			>{{notificationsCount > 9 ? '9+': notificationsCount}}</span>
			<i class="lar la-bell text-xl text-gray-400 mr-2 "></i>
		</template>

		<template #content>
			<div class="select-none max-h-[calc(100vh/2)] overflow-y-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-track-rounded-full scrollbar-roun scrollbar-track-gray-200 dark:scrollbar-track-groadis-darker scrollbar-thumb-groadis dark:scrollbar-thumb-groadis-dark space-y-2 p-2 pr-3">
				<template v-for="(notification, index) in $store.state.notifications">
					<div :class="[
								'relative p-1 px-2 text-gray-400 dark:text-gray-200 capitalize flex justify-between items-center duration-200 hover:shadow-md dark:hover:bg-gray-700 hover:bg-gray-200 hover:rounded-lg border-l-4',
								{'bg-gray-200 dark:bg-gray-700 rounded-lg border-red-400':!notification.read_at}
							]">
						<span class="text-sm">{{notification.data.message}}</span>
						<span
							@click="readNotification(notification)"
							:class="[
									'bg-gray-300 w-2 h-2 rounded-full cursor-pointer',
									{'!bg-red-400 ':!notification.read_at}
								]"
						></span>
					</div>
				</template>
			</div>
		</template>
	</jet-dropdown>
</template>

<script>
import JetDropdown from "@/Jetstream/Dropdown.vue";
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

		if (user) {
			const { state } = useStore();

			state.notifications = page.notifications;

			const notificationsCount = computed(() => {
				return state.notifications.filter((n) => !n.read_at).length;
			});

			Array.from(state.notifications).map((n) => {
				// check if ther is new notifications to see
				if (!n.read_at) {
					state.hasNotificatios = true;
				}
			});

			if (
				!state.Echo.connector.channels[`private-App.Models.User.${user.id}`]
			) {
				state.Echo.private(`App.Models.User.${user.id}`).notification(
					(n) => {
						state.hasNotificatios = true;
						let notification = {
							data: {
								message: n.message,
								user: n.user,
							},
							id: n.id,
							read_at: null,
						};
						state.notifications.unshift(notification);
					}
				);
			}

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
								state.notifications = page.props.notifications;
							},
						}
					);
				}
			}

			return { readNotification, notificationsCount };
		}
	},
};
</script>