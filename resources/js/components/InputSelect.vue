<template>
	<select
		:value="modelValue"
		@input="$emit('update:modelValue', $event.target.value)"
		ref="input-select"
		class="text-gray-700 bg-white border rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-groadis  focus:outline-none"
	>
		<slot />
	</select>
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
