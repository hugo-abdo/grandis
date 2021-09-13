<template>
	<app-layout title="Roles And Permissions">
		<h1 class="text-gray-600 dark:text-gray-300 font-semibold text-3xl">Roles And Permissions</h1>
		<div class="fixed z-50 right-0 top-2/4 flex items-center">
			<div class="flex flex-col space-y-2 bg-gray-100 border-l py-4 pl-2 rounded-l-3xl">
				<action-button :isActive="true" class="bg-groadis text-white" tooltipMsg="Add New Role">
					<Link :href="route('roles.create')">
						<i class="las la-plus-circle text-3xl"></i>
					</Link>
				</action-button>
			</div>
		</div>
		<div class="w-full grid gap-2 grid-cols-12 mt-12">
			<card
				v-for="role in $store.state.RolesModule.roles"
				:key="role.id"
				class="col-span-12 sm:col-span-6 lg:col-span-3 relative"
			>
				<Link :href="route('roles.edit',role.id)">
					<i
						class="las la-pen inline-block bg-gray-200 p-1 rounded-full shadow active:shadow-none cursor-pointer"
					></i>
				</Link>
				<Link
					class="ml-2"
					method="DELETE"
					preserve-scroll
					as="button"
					:href="route('roles.destroy',role.id)"
				>
					<i
						class="lar la-trash-alt inline-block bg-red-400 text-white p-1 rounded-full shadow active:shadow-none cursor-pointer"
					></i>
				</Link>

				<div
					class="mx-auto pb-[100%] relative border-2 shadow rounded-full overflow-hidden"
					:style="`border-color:${role.color}`"
				>
					<img
						class="w-full h-full object-cover absolute top-0"
						:src="`/storage/roles/${role.name}.png`"
						alt="admin image"
					/>
					<span class="absolute bottom-0 py-3 shadow-md text-center inset-x-0 bg-gray-900 bg-opacity-70">
						<h2 class="text-center font-semibold text-2xl text-white capitalize">{{role.name}}</h2>
					</span>
				</div>
				<div class="mt-2">
					<span class="text-gray-600 dark:text-gray-300 font-medium">Permissions :</span>
					<ul class="mt-2 flex flex-wrap gap-1">
						<li
							class="min-w-max font-medium capitalize text-blue-700"
							v-for="pemission in role.permissions"
							:key="pemission.id"
						>
							<badge
								class="bg-blue-200 p-0.5 text-[11px] flex items-center"
								:text="pemission.name.replace('_',' ')"
							/>
						</li>
					</ul>
				</div>
			</card>
		</div>
	</app-layout>
</template>

<script>
import { usePage, Link } from "@inertiajs/inertia-vue3";
import { useStore } from "vuex";
import badge from "@/components/badge.vue";
import ActionButton from "@/components/ActionButton.vue";
import { Inertia } from "@inertiajs/inertia";
import { onUnmounted } from "@vue/runtime-core";
export default {
	components: { badge, Link, ActionButton },
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
