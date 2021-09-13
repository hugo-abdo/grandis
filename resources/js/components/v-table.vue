<!-- This example requires Tailwind CSS v2.0+ -->
<template>
	<div class="flex flex-col">
		<div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8" id="table">
			<div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
				<div class="overflow-hidden sm:rounded-lg">
					<table class="min-w-full whitespace-nowrap">
						<thead>
							<tr class="dark:text-white text-gray-500">
								<template v-for="(field, index) in fields" :key="index">
									<th scope="col" class="p-3 text-base font-medium tracking-wider text-left capitalize">
										<slot
											:name="`head(${field.key})`"
											:row="{
												...field,
												index,
												value: field.name,
											}"
											:toggleSelecteAll="toggleSelecteAll"
											:itemsSelected="itemsSelected"
											v-if="$slots[`head(${field.key})`]"
										/>
										<slot
											v-else-if="$slots['head()']"
											:row="{
												...field,
												index,
												value: field.name,
											}"
											:toggleSelecteAll="toggleSelecteAll"
											:itemsSelected="itemsSelected"
											:name="`head()`"
										/>
										<template v-else>
											<span v-if="field.name !== 'select'">
												<v-table-head-field v-slot="{ searchIsActive, toggleActiveSearch }">
													<div
														v-if="searchIsActive && field.isSearcheable"
														class="form-input flex items-center justify-between p-0 rounded-lg border-gray-400 focus-within:ring-0 focus-within:border-droptra max-w-[250px]"
													>
														<input
															v-model="searchForm[field.name]"
															:autofocus="true"
															type="text"
															class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm min-w-[50px] text-gray-800 pl-2 py-1 bg-transparent w-11/12"
															:placeholder="field.name + ' is ...'"
														/>
														<span
															class="px-2 cursor-pointer text-gray-800"
															@click="closeActiveSearch(field.name, toggleActiveSearch)"
														>x</span>
													</div>
													<div v-else class="flex items-center gap-x-2">
														<span>{{ field.name }}</span>
														<svg
															v-if="field.isSearcheable"
															class="h-5 w-5 cursor-pointer"
															viewBox="0 0 20 20"
															fill="currentColor"
															@click="toggleActiveSearch"
														>
															<path d="M9 9a2 2 0 114 0 2 2 0 01-4 0z" />
															<path
																fill-rule="evenodd"
																d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a4 4 0 00-3.446 6.032l-2.261 2.26a1 1 0 101.414 1.415l2.261-2.261A4 4 0 1011 5z"
																clip-rule="evenodd"
															/>
														</svg>
													</div>
												</v-table-head-field>
											</span>
											<input
												v-else
												type="checkbox"
												:checked="itemsSelected.length"
												@click="toggleSelecteAll"
												class="form-checkbox rounded text-droptra focus:ring-0"
											/>
										</template>
									</th>
								</template>
							</tr>
						</thead>
						<tbody>
							<v-table-row
								v-for="(item, index) in tableData"
								:item="item"
								:key="index + 'key'"
								:rowIndex="index"
								:fields="fields"
								@toggleSelected="toggleSelected"
							>
								<template v-for="(index, name) in $slots" v-slot:[name]="data" :key="index">
									<slot :name="name" v-bind="data" />
								</template>
							</v-table-row>
							<tr key="edit" v-if="is_loading">
								<td colspan="12">
									<div class="w-[92vw] lg:w-full overflow-auto max-h-[calc(100vh-12rem)]">
										<div class="loader p-5 flex justify-center space-x-3">
											<div class="w-5 h-5 bg-gray-800 rounded-full animate-pulse"></div>
											<div class="w-5 h-5 bg-gray-800 rounded-full animate-pulse"></div>
											<div class="w-5 h-5 bg-gray-800 rounded-full animate-pulse"></div>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import { computed, ref, watch } from "vue";
import vTableRow from "./v-table-row.vue";
import VTableHeadField from "./v-table-head-field.vue";
export default {
	components: { vTableRow, VTableHeadField },
	props: {
		data: { type: Array, default: [] },
		fields: { type: Array },
		is_loading: { default: false },
	},
	setup(props, { emit }) {
		// /////////////////////////////////////////
		let searchForm = ref({});
		watch(searchForm.value, () => {
			emit("searching", searchForm.value);
		});
		function closeActiveSearch(feald, cb) {
			delete searchForm.value[feald];
			cb();
		}
		// /////////////////////////////////////////
		let itemsSelected = ref([]);
		let tableData = computed(() => {
			return props.data.map((item, index) => {
				return {
					...item,
					selected: itemsSelected.value.includes(item?.id),
				};
			});
		});
		const toggleSelecteAll = () => {
			if (itemsSelected.value.length) {
				itemsSelected.value = [];
			} else {
				itemsSelected.value = [];
				tableData.value.map((item, index) => {
					itemsSelected.value.push(item?.id);
				});
			}
			emit("selected", itemsSelected.value);
		};
		const toggleSelected = ({ item, value }) => {
			if (value && !itemsSelected.value.includes(item?.id)) {
				itemsSelected.value.push(item?.id);
			} else {
				itemsSelected.value = itemsSelected.value.filter((id) => {
					return id !== item?.id;
				});
			}
			emit("selected", itemsSelected.value);
		};
		// /////////////////////////////////////////

		return {
			tableData,
			toggleSelected,
			toggleSelecteAll,
			itemsSelected,
			searchForm,
			closeActiveSearch,
		};
	},
};
</script>
<style>
table {
	border-collapse: separate !important;
	border-spacing: 0 1rem;
}
table {
	@apply px-5;
}
tr {
	@apply overflow-hidden rounded-lg;
}

td:first-child {
	@apply rounded-l-lg;
}
td:last-child {
	@apply rounded-r-lg;
}
th:first-child {
	@apply rounded-l-lg;
}
th:last-child {
	@apply rounded-r-lg;
}
.loader div {
	animation-duration: 0.5s;
}

.loader div:first-child {
	animation-delay: 0.1s;
}

.loader div:nth-child(2) {
	animation-delay: 0.3s;
}

.loader div:nth-child(3) {
	animation-delay: 0.6s;
}
</style>
