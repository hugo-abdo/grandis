<template>
	<Link :href="'/'">
	<logo class="w-3/4 mx-auto" />
	<h2 class="hidden">groadis</h2>
	</Link>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import Logo from "./Logo.vue";

export default defineComponent({
	components: {
		Link,
		Logo,
	},
});
</script>
