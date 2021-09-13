<template>
	<Link :href="'/'">
		<img src="assets/images/logo-dark.png" class="w-full" alt="groadis logo" />
		<h2 class="hidden">groadis</h2>
	</Link>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
	components: {
		Link,
	},
});
</script>
