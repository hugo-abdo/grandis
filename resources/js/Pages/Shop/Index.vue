<template>
	<actions>
		<action-button
			v-if="can('create_product')"
			:isActive="true"
			class="bg-groadis text-white"
			tooltipMsg="Add New product"
		>
			<Link :href="route('products.create')">
			<i class="las la-plus-circle text-xl"></i>
			</Link>
		</action-button>
	</Actions>
	<div class="flex gap-x-4 items-start">
		<div class="text-gray-600 sticky top-20 hidden sm:block w-1/3 md:w-1/4">
			<card class="col-span-full flex items-center p-0 dark:text-gray-400 relative">
				<input
					class="bg-transparent w-full border-none focus:ring-0"
					placeholder="Search"
					type="text"
					name="search"
				>
				<i class="las la-search px-2 absolute right-0 pointer-events-none"></i>
			</card>
			<card class="mt-2 space-y-4">
				<filter-section title="Multi Range :">
					<div class="flex items-center ">
						<jet-checkbox id="range-all" />
						<jet-label
							for="range-all"
							class="ml-2"
						>All</jet-label>
					</div>
				</filter-section>
				<filter-section title="Categories :">
					<div class="flex items-center">
						<jet-checkbox id="range-all" />
						<jet-label
							for="range-all"
							class="ml-2"
						>All</jet-label>
					</div>
				</filter-section>
				<filter-section title="Brands :">
					<div class="flex items-center">
						<jet-checkbox id="range-all" />
						<jet-label
							for="range-all"
							class="ml-2"
						>All</jet-label>
					</div>
				</filter-section>
				<filter-section title="ratings :">
					<div class="flex items-center">
						<jet-checkbox id="range-all" />
						<jet-label
							for="range-all"
							class="ml-2"
						>All</jet-label>
					</div>
				</filter-section>
			</card>
		</div>
		<div class="grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 w-full md:w-3/4">
			<product v-for="i in 12" />
		</div>
	</div>
</template>

<script>
import ActionButton from "@/components/ActionButton.vue";
import JetCheckbox from "@/components/Checkbox.vue";
import JetInput from "@/components/Input.vue";
import JetLabel from "@/components/Label.vue";
import Actions from "@/components/Actions.vue";
import Product from "./Partials/Product.vue";
import { Link } from "@inertiajs/inertia-vue3";
import FilterSection from "./Partials/FilterSection.vue";
export default {
	components: {
		Product,
		JetLabel,
		JetInput,
		JetCheckbox,
		FilterSection,
		Actions,
		ActionButton,
		Link,
	},
};
</script>
