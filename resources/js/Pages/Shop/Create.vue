<template>
	<h1 class="text-4xl font-semibold text-gray-700 dark:text-gray-400 my-10 inline-block w-full">Add New Product To Your List</h1>
	<div class="flex flex-wrap md:flex-col mb-20">
		<form-section class="flex-1">
			<template #title>
				<h1 class="text-2xl">Step 1</h1>
			</template>
			<template #description>
				<h1 class="text-xl">In this section you need to enter all generale informations about your product</h1>
			</template>
			<template #form>
				<component is="generale-info" />
			</template>
			<template #actions>
				<jet-button
					:class="{ 'opacity-25': false }"
					:disabled="false"
				>Next</jet-button>
			</template>
		</form-section>
	</div>
</template>

<script>
import Steps from "./Partials/Steps.vue";
import GeneraleInfo from "./Partials/GeneraleInfo.vue";
import FormSection from "../../components/FormSection.vue";
import JetButton from "@/components/Button.vue";

export default {
	name: "New Product 🛍️ Page",
	components: {
		Steps,
		GeneraleInfo,
		FormSection,
		JetButton,
	},
	setup() {
		return {};
	},
};
</script>