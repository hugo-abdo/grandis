<template>
	<Link
		:href="href"
		class="inline-flex items-center font-medium focus:outline-none pl-1.5 py-1.5"
	>
	<slot />
	</Link>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
	components: { Link },
	props: ["href"],
});
</script>
