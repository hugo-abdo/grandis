<template>
	<transition
		enter-active-class="transition ease-out duration-200"
		enter-from-class="transform opacity-0 scale-95 translate-x-80"
		enter-to-class="transform opacity-100 scale-100 translate-x-0"
		leave-active-class="transition ease-in duration-75"
		leave-from-class="transform opacity-100 scale-100 translate-x-0"
		leave-to-class="transform opacity-0 scale-95 translate-x-80"
	>
		<button
			v-show="isActive"
			class="cursor-pointer inline-block rounded-l-full px-0.5 shadow-md active:shadow-none"
			v-tooltip="{ content: tooltipMsg }"
		>
			<slot />
		</button>
	</transition>
</template>

<script>
export default {
	props: ["tooltipMsg", "btnClass", "isActive"],
};
</script>
