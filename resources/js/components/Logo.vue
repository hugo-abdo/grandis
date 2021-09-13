<template>
	<div>
		<img v-if="!isDark" src="/assets/images/logo-dark.png" class="w-full" alt="groadis logo" />
		<img v-if="isDark" src="/assets/images/logo-light.png" class="w-full" alt="groadis logo" />
		<h2 class="hidden">groadis</h2>
	</div>
</template>
<script>
export default {
	props: ["isDark"],
};
</script>
