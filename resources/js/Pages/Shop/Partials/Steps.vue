<template>

	<div class="flex flex-col md:flex-row md:mx-auto flex-wrap bg-white rounded-t-lg overflow-hidden">
		<a
			v-for="i in 4"
			:key="i"
			:class="[classes, i < 2 ?'border-indigo-500 text-indigo-500 bg-gray-100':'border-gray-200 hover:text-gray-900 ' ]"
		>
			STEP {{i}}
		</a>
	</div>
</template>

<script>
import { ref } from "vue";
export default {
	setup() {
		const classes = [
			"px-4 py-3 border-b-2 title-font font-medium inline-flex items-center leading-none tracking-wider rounded-t cursor-pointer",
		];
		const step = ref(1);

		return { classes, step };
	},
};
</script>
