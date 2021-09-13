<template>
	<div class="flex items-center">
		<span
			class="text-center text-gray-600 dark:text-white text-sm tracking-wider font-medium pr-2 flex-grow-0"
		>{{ text }}</span>
		<span class="border-gray-300 border-b-4 border-dashed flex-grow"></span>
	</div>
</template>

<script>
export default {
	props: ["text"],
};
</script>