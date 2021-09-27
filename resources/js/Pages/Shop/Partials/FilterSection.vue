<template>
	<div>
		<h2 class="text-xs tracking-wider dark:text-gray-200 mb-2">{{title}}</h2>
		<slot />
	</div>
</template>

<script>
export default {
	props: ["title"],
};
</script>