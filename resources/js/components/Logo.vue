<template>
	<div>
		<Link href="/">
		<img
			:src="isDark ?'/assets/images/logo-light.png':'/assets/images/logo-dark.png'"
			class="w-full duration-200"
			alt="groadis logo"
		/>
		<h2 class="hidden">groadis</h2>
		</Link>
	</div>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3";
import { isDark } from "@/mixins/useDarkMode.js";

export default {
	components: {
		Link,
	},
	setup() {
		return { isDark };
	},
};
</script>
