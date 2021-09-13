<template>
	<!-- add new user -->
	<div class="fixed z-50 right-0 top-2/4 flex items-center">
		<div class="flex flex-col items-end space-y-2 bg-gray-100 border-l py-4 pl-2 rounded-l-3xl">
			<action-button
				v-if="can('create_user')"
				:isActive="true"
				class="bg-groadis text-white"
				tooltipMsg="Add New User"
			>
				<Link :href="route('users.create')">
					<i class="las la-plus-circle text-3xl"></i>
				</Link>
			</action-button>

			<delete-user v-if="can('delete_user')" :data="selection" #="{activate}">
				<action-button
					@click="activate"
					:isActive="selection.length"
					tooltipMsg="Delete Selection"
					class="bg-white !text-red-500"
				>
					<i class="lar la-trash-alt text-3xl"></i>
				</action-button>
			</delete-user>

			<!-- this function need  time -->
			<action-button
				@click="$store.dispatch('changeAllUsersStatus',selection)"
				v-if="can('edit_user_status')"
				:isActive="selection.length"
				tooltipMsg="this Action is not ready"
				class="bg-white !text-green-500"
			>
				<i class="las la-check-circle text-3xl"></i>
			</action-button>
		</div>
	</div>
</template>

<script>
import { ref } from "vue";
import ActionButton from "@/components/ActionButton.vue";
import DeleteUser from "./DeleteUser.vue";
import { Link } from "@inertiajs/inertia-vue3";
export default {
	components: {
		ActionButton,
		DeleteUser,
		Link,
	},
	props: ["selection"],
	setup() {
		return {};
	},
};
</script>
