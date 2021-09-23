<template>
	<jet-dropdown
		align="right"
		width="72"
		contentClasses="bg-white duration-200 overflow-hidden dark:bg-groadis-dark mt-5"
		triggerClasses="w-5 h-5"
	>
		<template #trigger>
			<span
				v-if="$store.state.hasNotificatios"
				class="bg-red-400 w-1.5 h-1.5 absolute shadow-md top-0 right-1 rounded-full animate-bounce"
			></span>
			<i class="lar la-bell text-xl text-gray-400 mr-2 cursor-pointer"></i>
		</template>

		<template #content>
			<div
				class="select-none text-base max-h-52 overflow-y-auto scrollbar-thin scrollbar-thumb-rounded-full scrollbar-track-rounded-full scrollbar-roun scrollbar-track-gray-200 dark:scrollbar-track-groadis-darker scrollbar-thumb-groadis dark:scrollbar-thumb-groadis-dark space-y-1 divide-y-2 p-2 pr-3"
			>
				<template v-for="(notification, index) in $store.state.notifications">
					<template v-if="index < 10">
						<div
							:class="[
								'relative p-1 px-2 text-gray-400 dark:text-gray-200 capitalize flex justify-between items-center dark:hover:bg-gray-700 hover:bg-gray-200 hover:rounded-lg',
								{'bg-gray-200 dark:bg-gray-700 rounded-lg':!notification.read_at}
							]"
						>
							<span class="text-shadow-sm">{{notification.data.message}}</span>
							<span
								@click="readNotification(notification)"
								:class="[
									'bg-gray-300 w-2 h-2 rounded-full cursor-pointer',
									{'!bg-red-400 ':!notification.read_at}
								]"
							></span>
						</div>
					</template>
				</template>
			</div>
		</template>
	</jet-dropdown>
</template>

<script>
import JetDropdown from "@/Jetstream/Dropdown.vue";
import { onMounted, ref } from "vue";
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

			state.notifications.unshift(...page.notifications);

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

			return { readNotification };
		}
	},
};
</script>