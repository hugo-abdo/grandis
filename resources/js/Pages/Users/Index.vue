<template>
	<app-layout title="Users">
		<!-- add new User -->
		<Actions>
			<action-button
				v-if="can('create_user')"
				:isActive="true"
				class="bg-groadis text-white"
				tooltipMsg="Add New User"
			>
				<Link :href="route('users.create')">
					<i class="las la-plus-circle text-3xl"></i>
				</Link>
			</action-button>

			<delete-user
				v-if="can('delete_user')"
				:data="$store.state.UsersModule.selectedUsers"
				#="{activate}"
			>
				<action-button
					@click="activate"
					:isActive="$store.state.UsersModule.selectedUsers.length"
					tooltipMsg="Delete Selection"
					class="bg-white !text-red-500"
				>
					<i class="lar la-trash-alt text-3xl"></i>
				</action-button>
			</delete-user>

			<!-- this function need  time -->
			<action-button
				@click="$store.dispatch('changeAllUsersStatus')"
				v-if="can('edit_user_status')"
				:isActive="$store.state.UsersModule.selectedUsers.length"
				tooltipMsg="this Action is not ready"
				class="bg-white !text-green-500"
			>
				<i class="las la-check-circle text-3xl"></i>
			</action-button>
		</Actions>
		<!-- users table -->
		<v-table
			@selected="(data)=> $store.commit('SELECTUSERS',data)"
			@searching="(data)=> $store.dispatch('searche',{ route: route('users.index'), searcheData:data})"
			:data="$store.state.UsersModule.data"
			:fields="$store.state.UsersModule.TableFields"
			:is_loading="$store.state.UsersModule.is_loading"
		>
			<template #cell(avatar)="{row}">
				<div class="w-max">
					<span
						v-tooltip="{ content: row.role? row.role.name : 'no role' }"
						:style="`background-color: ${row.role? row.role.color : '#ccc'}`"
						class="w-2 absolute top-0 inset-y-0"
					></span>
					<img
						:class="[
					row.is_active ?'ring-green-400':'ring-red-400',
					]"
						v-tooltip="{ content: row.is_active ?'Active':'Not Active' }"
						class="w-8 h-8 ml-4 rounded-full ring-2 object-cover shadow-md"
						:src="row.profile_photo_path ? '/storage/'+ row.profile_photo_path: row.profile_photo_url"
						:alt="row.name"
					/>
				</div>
			</template>
			<!-- avatar and name -->
			<template #cell(name)="{row}">
				<span class="block">{{row.name}}</span>
				<span class="text-xs">ID: {{row.id}}</span>
			</template>

			<!-- action -->
			<template #cell(action)="{ row, actions }">
				<div class="flex items-center justify-center space-x-2 text-xl">
					<input-switch
						v-tooltip="{ content: row.is_active ? 'deactivate user':'activate user' }"
						v-if="row.id !== $page.props.user.id && can('edit_user_status')"
						:name="row.id"
						@change="changeUserStatus(row)"
						v-model="row.is_active"
					/>
					<!-- edit user -->
					<div
						v-if="can('edit_user')"
						v-tooltip="{ content: 'Edit user' }"
						class="text-gray-500 cursor-pointer bg-white rounded-md border px-1 shadow active:shadow-none"
					>
						<Link :href="route('users.edit',row.id)">
							<i class="las la-user-edit"></i>
						</Link>
					</div>
					<!-- delete user -->
					<div
						v-tooltip="{ content: 'Delete user' }"
						v-if="row.id !== $page.props.user.id && can('delete_user')"
						class="text-red-400 bg-white rounded-md border px-1 shadow active:shadow-none"
					>
						<delete-user :data="row.id" #="{activate}">
							<i class="las la-trash cursor-pointer" @click="activate"></i>
						</delete-user>
					</div>
					<!-- Change user status -->
				</div>
			</template>
		</v-table>
		<log-more-data @onObserved="$store.dispatch('getMoreUsers')" />
	</app-layout>
</template>

<script>
import { computed, defineComponent, ref } from "vue";
import VTable from "@/components/v-table.vue";
import Badge from "@/components/badge.vue";
import Actions from "@/components/Actions.vue";
import DeleteUser from "@/Pages/Users/DeleteUser.vue";
import Edit from "@/Pages/Users/Edit.vue";
import LogMoreData from "@/Pages/Users/LogMoreData.vue";
import { usePage, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { useStore } from "vuex";
import can from "@/mixins";
import InputSwitch from "@/components/InputSwitch.vue";
import ActionButton from "@/components/ActionButton.vue";

export default defineComponent({
	props: ["users"],
	components: {
		Link,
		VTable,
		Actions,
		DeleteUser,
		Edit,
		Badge,
		LogMoreData,
		InputSwitch,
		ActionButton,
	},

	setup(props) {
		const store = useStore();
		const page = usePage();

		// init the store and add the first arr of users
		store.commit("INIT", page.props.value);

		let fields = [
			{
				name: "",
				key: "avatar",
				fieldClass: "w-14 sticky left-0 z-50",
				isNotSelectable: true,
			},
			{
				name: "name",
				key: "name",
				isSearcheable: true,
			},
			{ name: "email", key: "email", isSearcheable: true },
			{ name: "", key: "action", fieldClass: "w-20" },
		];

		if (can("delete_user") || can("edit_user_status")) {
			fields.unshift({
				name: "select",
				fieldClass: "w-0",
			});
		}

		function changeUserStatus(row) {
			if (can("edit_user_status")) {
				store.dispatch("changeStatus", row);
			}
		}

		store.commit("SET_TABLE_FIELDS", fields);

		return { changeUserStatus };
	},
});
</script>
