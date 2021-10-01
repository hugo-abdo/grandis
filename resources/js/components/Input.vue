<template>
	<input
		class="block w-full px-4 py-1 text-gray-700 bg-white border border-gray-300  dark:border-gray-600 focus:border-groadis rounded-md dark:bg-gray-800 dark:text-gray-300 focus:outline-none ring-groadis "
		:value="modelValue"
		@input="$emit('update:modelValue', $event.target.value)"
		ref="input"
	/>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
	props: ["modelValue"],

	emits: ["update:modelValue"],

	methods: {
		focus() {
			this.$refs.input.focus();
		},
	},
});
</script>
