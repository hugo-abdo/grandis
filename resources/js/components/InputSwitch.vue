<template>
	<label :for="`switch-${name}`" class="flex items-center cursor-pointer">
		<!-- toggle -->
		<div class="relative">
			<!-- input -->
			<input
				type="checkbox"
				class="sr-only"
				:id="`switch-${name}`"
				:checked="modelValue"
				ref="inputeswitch"
				@change="$emit('update:modelValue', $event.target.value)"
			/>

			<!-- line -->
			<div class="line block bg-gray-100 shadow-inner w-8 h-4 rounded-full"></div>
			<!-- dot -->
			<div class="dot absolute left-1 shadow-md top-0.5 bg-white w-3 h-3 rounded-full transition"></div>
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
<style scoped>
input ~ .line {
	@apply bg-red-300;
}
input:checked ~ .line {
	@apply bg-green-300;
}
input:checked ~ .dot {
	transform: translateX(110%);
}
</style>
