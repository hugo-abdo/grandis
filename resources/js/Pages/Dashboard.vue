<template>
	<app-layout title="Dashboard">
		<h1>Dashboard</h1>
	</app-layout>
</template>

<script>
import { defineComponent } from "vue";

import Welcome from "@/Jetstream/Welcome.vue";

export default defineComponent({
	components: {
		Welcome,
	},
});
</script>
