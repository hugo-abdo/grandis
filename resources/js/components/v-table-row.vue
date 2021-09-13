<template>
	<tr
		class="duration-200 transform hover:-translate-y-1 hover:shadow-lg shadow-md"
		:class=" [item.showDetails || item.selected || item.showEdit ? ' !shadow-groadis' : '']"
	>
		<template v-for="(field, index) in fields" :key="field.name">
			<td
				class="p-3 font-medium tracking-wider text-left text-sm capitalize dark:bg-groadis-dark duration-200 dark:text-white"
				:class=" [field.fieldClass ,item.showDetails || item.selected || item.showEdit ? '!bg-groadis !text-white' : 'bg-white']"
			>
				<label
					:for="field.name !== 'action' && field.key !== 'action' && !field.isNotSelectable ? rowIndex + '-checkbox' : ''"
				>
					<slot
						:name="`cell(${field.key})`"
						:row="{
							...item,
							rowIndex,
							value: item[field.key],
						}"
						:actions="{
							isEditActive: showEdit,
							isDeatailsActive: showDeatails,
							toggleShowEdit,
							toggleShowDetails,
							toggleSelected,
						}"
						v-if="$slots[`cell(${field.key})`]"
					/>
					<slot
						v-else-if="$slots['cell()']"
						:actions="{
							isEditActive: showEdit,
							isDeatailsActive: showDeatails,
							toggleShowEdit,
							toggleShowDetails,
							toggleSelected,
						}"
						:row="{
							rowIndex,
							...item,
							value: item[field.key],
						}"
						:name="`cell()`"
					/>
					<div v-else class="flex items-center truncate">
						<template v-if="field.subKey">{{ item[field.key][field.subKey] }}</template>
						<template v-else>{{ item[field.key] }}</template>
					</div>
				</label>
				<div class="flex items-center gap-x-3">
					<input
						v-if="field.name == 'select'"
						:id="rowIndex + '-checkbox'"
						type="checkbox"
						v-model="item.selected"
						@click="toggleSelected"
						class="form-checkbox rounded text-red-300 focus:ring-0"
					/>
				</div>
			</td>
		</template>
	</tr>

	<transition-group
		enter-active-class="transition ease-out  duration-100"
		enter-from-class="transform opacity-0  scale-y-0 -translate-y-36"
		enter-to-class="transform opacity-100  scale-y-100 -translate-y-0"
		leave-active-class="transition ease-in  duration-100"
		leave-from-class="transform opacity-100  scale-y-100 -translate-y-0"
		leave-to-class="transform opacity-0  scale-y-0 -translate-y-36"
	>
		<tr key="details" v-if="showDeatails">
			<td colspan="12">
				<div
					class="shadow rounded-lg text-gray-500 bg-white shadow-lg duration-200 dark:bg-groadis-dark dark:text-white w-[92vw] md:w-[93vw] lg:w-[90vw] overflow-auto max-h-[calc(100vh-12rem)]"
				>
					<slot
						name="details"
						:row="{ item }"
						:actions="{
							isEditActive: showEdit,
							isDeatailsActive: showDeatails,
							toggleShowEdit,
							toggleShowDetails,
							toggleSelected,
						}"
					/>
				</div>
			</td>
		</tr>
		<tr key="edit" v-if="showEdit">
			<td colspan="12">
				<div
					class="shadow rounded-lg text-gray-500 bg-white shadow-lg duration-200 dark:bg-groadis-dark dark:text-white w-[92vw] md:w-[93vw] lg:w-[90vw] overflow-auto max-h-[calc(100vh-12rem)]"
				>
					<slot
						name="edit"
						:row="{ item }"
						:actions="{
							isEditActive: showEdit,
							isDeatailsActive: showDeatails,
							toggleShowEdit,
							toggleShowDetails,
							toggleSelected,
						}"
					/>
				</div>
			</td>
		</tr>
	</transition-group>
</template>

<script>
import { computed, ref } from "vue";

export default {
	props: {
		fields: Array,
		item: Object,
		rowIndex: {
			type: Number,
			default: 0,
		},
	},
	emits: ["toggleSelected"],
	setup(props, { emit }) {
		let showDeatails = ref(false);
		let showEdit = ref(false);
		function toggleShowDetails() {
			showEdit.value = false;
			showDeatails.value = !showDeatails.value;
			scrollToLeft(showDeatails.value);
		}
		function toggleShowEdit() {
			showDeatails.value = false;
			showEdit.value = !showEdit.value;
			scrollToLeft(showEdit.value);
		}

		function scrollToLeft(condition) {
			if (condition) {
				document.getElementById("table").scrollTo(0, 0);
			}
		}

		function toggleSelected(e) {
			emit("toggleSelected", {
				item: props.item,
				value: e.target.checked,
			});
		}

		return {
			toggleShowDetails,
			toggleSelected,
			toggleShowEdit,
			showEdit,
			showDeatails,
		};
	},
};
</script>
