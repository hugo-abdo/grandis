<template>
	<label :for="`switch-${name}`" class="flex items-center cursor-pointer">
		<!-- toggle -->
		<div class="relative">
			<!-- input -->
			<input
				type="checkbox"
				:id="`switch-${name}`"
				class="sr-only"
				:checked="modelValue"
				@change="$emit('update:modelValue', $event.target.value)"
			/>
			<!-- line -->
			<div class="line block bg-gray-300 shadow-inner w-9 h-6 rounded-full"></div>
			<!-- dot -->
			<div class="dot absolute left-1 shadow-md top-1 bg-white w-4 h-4 rounded-full transition"></div>
		</div>
	</label>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
	props: ["modelValue", "name"],
	emits: ["update:modelValue"],
	methods: {
		focus() {
			this.$refs.input.focus();
		},
	},
});
</script>
