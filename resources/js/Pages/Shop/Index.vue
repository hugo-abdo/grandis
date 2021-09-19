<template>
	<app-layout title="Shop 🛒">
		<div class="grid grid-cols-6 gap-x-4">
			<div class="md:col-span-1 hidden lg:block relative">
				<card class="sticky top-32 h-[calc(100vh-9rem)] text-gray-600">
					<h2 class>Multi Range :</h2>
					<div class="flex items-center mt-4">
						<jet-input type="checkbox" id="range-all" />
						<jet-label for="range-all" class="ml-2">All</jet-label>
					</div>
					<div class="flex items-center mt-2">
						<jet-input type="checkbox" id="range-all" />
						<jet-label for="range-all" class="ml-2">{{'<= $10'}}</jet-label>
					</div>
					<div class="flex items-center mt-2">
						<jet-input type="checkbox" id="range-all" />
						<jet-label for="range-all" class="ml-2">{{'$10 - $100'}}</jet-label>
					</div>
					<div class="flex items-center mt-2">
						<jet-input type="checkbox" id="range-all" />
						<jet-label for="range-all" class="ml-2">{{'$100 - $500'}}</jet-label>
					</div>
					<div class="flex items-center mt-2">
						<jet-input type="checkbox" id="range-all" />
						<jet-label for="range-all" class="ml-2">{{'>= $500'}}</jet-label>
					</div>
				</card>
			</div>
			<div class="col-span-6 lg:col-span-5 grid grid-cols-12 gap-6">
				<product class="col-span-12 sm:col-span-6 md:col-span-4" v-for="i in 50" />
			</div>
		</div>
	</app-layout>
</template>

<script>
import JetLabel from "../../Jetstream/Label.vue";
import JetInput from "../../Jetstream/Input.vue";
import Product from "./Product.vue";
export default {
	components: {
		Product,
		JetLabel,
		JetInput,
	},
};
</script>
