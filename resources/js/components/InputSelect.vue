<template>
	<select
		:value="modelValue"
		@input="$emit('update:modelValue', $event.target.value)"
		ref="input-select"
		class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-gray-800 w-full"
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
