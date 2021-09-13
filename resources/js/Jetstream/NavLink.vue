<template>
	<Link
		:href="href"
		:class="['inline-flex items-center px-2 text-sm font-medium leading-5 text-gray-500 transition focus:outline-none rounded relative ',classes]"
	>
		<slot />
	</Link>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
	components: {
		Link,
	},
	props: ["href", "active"],

	computed: {
		classes() {
			return this.active
				? "!text-white shadow-groadis active:shadow-none bg-gradient-to-r from-groadis to-indigo-300"
				: "hover:text-gray-400 dark:hover:text-gray-400 focus:text-gray-700 dark:text-white ";
		},
	},
});
</script>
