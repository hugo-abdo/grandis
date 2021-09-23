<template>
	<jet-dropdown
		align="right"
		width="52"
		contentClasses="bg-white  duration-200 overflow-hidden dark:bg-groadis-dark mt-3"
		triggerClasses="w-5 h-5"
	>
		<template #trigger>
			<span
				v-if="$store.state.hasNotificatios"
				class="bg-red-400 w-1.5 h-1.5 absolute shadow-md top-0 right-1 rounded-full animate-bounce"
			></span>
			<i @click="readNotification" class="lar la-bell text-xl text-gray-400 mr-2 cursor-pointer"></i>
		</template>

		<template #content>
			<div class="select-none text-base max-h-52 overflow-y-auto">
				<template v-for="(notification, index) in $store.state.notifications">
					<template v-if="index < 10">
						<div class="border-t border-gray-200 dark:border-groadis-darker"></div>
						<div
							:class="[
						'block relative px-2 py-1 text-gray-400 capitalize ',
						{'bg-gray-100':!notification.read_at}
					]"
						>
							<span
								:class="[
							'bg-gray-300 w-2 h-2 absolute top-2 right-2 rounded-full',
							{'!bg-red-400':!notification.read_at}
						]"
							></span>
							<span class="block text-shadow-sm">{{notification.data.message}}</span>
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

			onMounted(() => {
				if (
					!state.Echo.connector.channels[
						`private-App.Models.User.${user.id}`
					]
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
			});

			function readNotification() {
				state.hasNotificatios = false;
				Inertia.get(
					"/read-notifications",
					{},
					{
						preserveState: true,
						onSuccess(page) {
							state.notifications = page.props.notifications;
						},
					}
				);
			}

			return { readNotification };
		}
	},
};
</script>