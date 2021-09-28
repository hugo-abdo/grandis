<template>
	<div
		class="text-gray-700 duration-200 dark:text-white dark:hover:bg-gray-500 hover:bg-gray-200 dark:focus-within:bg-gray-500 focus-within:bg-gray-200"
	>
		<button
			type="submit"
			class="block w-full px-4 py-2 text-sm leading-5 text-left focus:outline-none transition"
			v-if="as == 'button'"
		>
			<slot></slot>
		</button>

		<a
			:href="href"
			class="block px-4 py-2 text-sm leading-5 focus:outline-none transition"
			v-else-if="as =='a'"
		>
			<slot></slot>
		</a>

		<Link :href="href" class="block px-4 py-2 text-sm leading-5 focus:outline-none transition" v-else>
			<slot></slot>
		</Link>
	</div>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
	components: {
		Link,
	},
	props: ["href", "as"],
});
</script>
