<template>
	<!-- add new user -->
	<div class="fixed z-50 right-0 top-2/4 flex items-center">
		<div
			class="flex flex-col items-end space-y-2 bg-gray-100 dark:bg-groadis-darker dark:border-groadis-dark border-l py-4 pl-2 rounded-l-3xl"
		>
			<slot />
		</div>
	</div>
</template>

<script>
import { ref } from "vue";
import ActionButton from "@/components/ActionButton.vue";
import DeleteUser from "../Pages/Users/DeleteUser.vue";
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
