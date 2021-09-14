<template>
	<app-layout title="Shop 🛒">
		<div class="grid grid-cols-12 gap-4">
			<product class="col-span-12 sm:col-span-6 md:col-span-3" v-for="i in 10" />
		</div>
	</app-layout>
</template>

<script>
import Product from "./Product.vue";
export default {
	components: {
		Product,
	},
};
</script>
