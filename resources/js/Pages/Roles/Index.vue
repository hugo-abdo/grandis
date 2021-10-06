<template>
	<h1 class="text-gray-600 duration-200 dark:text-gray-300 font-semibold text-3xl">Roles And Permissions</h1>
	<actions>
		<action-button
			:isActive="true"
			class="bg-groadis text-white"
			tooltipMsg="Add New Role"
		>
			<Link :href="route('roles.create')">
			<i class="las la-plus-circle text-xl"></i>
			</Link>
		</action-button>
	</actions>
	<div class="w-full grid gap-2 grid-cols-12 mt-12">
		<card
			v-for="role in $store.state.RolesModule.roles"
			:key="role.id"
			class="col-span-12 sm:col-span-6 relative"
		>
			<div class="absolute right-2">
				<Link :href="route('roles.edit',role.id)">
				<i class="lar la-edit inline-block bg-gray-200 text-gray-800 p-1 rounded-full shadow active:shadow-none cursor-pointer"></i>
				</Link>
				<Link
					class="ml-2"
					method="DELETE"
					preserve-scroll
					as="button"
					:href="route('roles.destroy',role.id)"
				>
				<i class="lar la-trash-alt inline-block bg-red-400 text-white p-1 rounded-full shadow active:shadow-none cursor-pointer"></i>
				</Link>
			</div>
			<div class="grid grid-cols-3 gap-x-4">
				<div class="col-span-3 lg:col-span-1">
					<div
						class="mx-auto w-32 h-32 relative border-2 shadow rounded-full overflow-hidden"
						:style="`border-color:${role.color}`"
					>
						<img
							class="w-full h-full object-cover"
							:src="`http://grandis.test/storage/roles/${role.name}.png`"
							alt="admin image"
						/>
						<span class="absolute bottom-0 py-1 shadow-md text-center inset-x-0 bg-gray-900 bg-opacity-50">
							<h2 class="text-center font-semibold text-white capitalize">{{role.name}}</h2>
						</span>
					</div>
				</div>
				<div class="col-span-3 lg:col-span-2">
					<span class="text-gray-600 duration-200 dark:text-gray-300 font-medium">Permissions :</span>
					<ul class="mt-2 flex flex-wrap gap-2">
						<li
							class="min-w-max font-medium capitalize text-blue-700"
							v-for="pemission in role.permissions"
							:key="pemission.id"
						>
							<badge
								class="bg-blue-200 p-0.5 text-[11px] flex items-center"
								:text="pemission.name.replaceAll('_',' ')"
							/>
						</li>
					</ul>
				</div>
			</div>
		</card>
	</div>
</template>

<script>
import { usePage, Link } from "@inertiajs/inertia-vue3";
import { useStore } from "vuex";
import badge from "@/components/badge.vue";
import ActionButton from "@/components/ActionButton.vue";
import { Inertia } from "@inertiajs/inertia";
import { onUnmounted } from "@vue/runtime-core";
import Actions from "@/components/Actions.vue";
export default {
	components: { badge, Link, ActionButton, Actions },
	setup() {
		const store = useStore();
		const page = usePage();

		onUnmounted(
			Inertia.on("before", (event) => {
				if (event.detail.visit.method == "delete") {
					Inertia.on("success", (event) => {
						store.commit("RolesModule/INIT", event.detail.page.props);
					});
					return confirm("Are you sure you want to delete this role?");
				}
			})
		);

		// init the store and add the first arr of users
		store.commit("RolesModule/INIT", page.props.value);
	},
};
</script>
