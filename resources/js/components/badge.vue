<template>
	<span class="px-2 rounded-full shadow py-0.5 text-xs whitespace-nowrap">
		{{ text }}
		<slot />
	</span>
</template>

<script>
export default {
	props: {
		text: {
			type: [String, Number],
			default: "badge",
		},
	},
};
</script>
