<template>
	<div class="col-span-6 px-2">
		<jet-label
			class="text-lg tracking-wide ml-1"
			value='Title'
			for='title'
		/>
		<jet-input
			id="title"
			type='text'
			placeholder="Product Title"
		/>
	</div>
	<div class="col-span-6 px-2">
		<jet-label
			class="text-lg tracking-wide ml-1"
			value='Summary'
			for='summary'
		/>
		<jet-textarea
			id="summary"
			placeholder="Type Something About Your Product"
		/>
	</div>
	<div class="col-span-6 px-2">
		<jet-label
			class="text-lg tracking-wide ml-1"
			value='Description'
			for='description'
		/>
		<jet-textarea
			id="description"
			rows='6'
			placeholder="Type Something About Your Product"
		/>
	</div>
	<div class="col-span-6 px-2">
		<jet-label
			class="text-lg tracking-wide ml-1"
			value='Dondition'
			for='condition'
		/>
		<jet-input-select
			class="w-full"
			id="condition"
			v-model="form.conditions"
		>
			<option
				v-for="condition in $page.props.conditions"
				:key="condition"
				:value="condition"
			>{{condition}}</option>
		</jet-input-select>
	</div>
</template>

<script>
import JetLabel from "@/components/Label.vue";
import JetInput from "@/components/Input.vue";
import JetTextarea from "@/components/Textarea.vue";
import JetInputSelect from "@/components/InputSelect.vue";
import { useForm } from "@inertiajs/inertia-vue3";
export default {
	name: "New Product 🛍️ Page",
	components: {
		JetInput,
		JetLabel,
		JetTextarea,
		JetInputSelect,
	},
	props: ["conditions"],
	setup() {
		const form = useForm({
			conditions: "default",
		});

		return { form };
	},
};
</script>