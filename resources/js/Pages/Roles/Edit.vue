<template>
	<form
		@submit.prevent="updateRole"
		class="grid grid-cols-12 items-start gap-2"
	>
		<card class="col-span-12 md:col-span-6 lg:col-span-4">
			<!-- Profile Photo -->
			<div class="w-max mx-auto flex items-center flex-col">
				<!-- Profile Photo File Input -->
				<input
					type="file"
					class="hidden"
					ref="photo"
					@change="updatePhotoPreview"
				/>

				<!-- Current Profile Photo -->
				<div
					class="mt-2"
					v-show="! photoPreview"
				>
					<img
						:src="`http://grandis.test/storage/roles/${role.name}.png`"
						class="rounded-full h-32 w-32 object-cover border-4 bg-white shadow-md"
						:style="{borderColor:form.color}"
					/>
				</div>

				<!-- New Profile Photo Preview -->
				<div
					class="mt-2"
					v-show="photoPreview"
				>
					<span
						class="block rounded-full w-32 h-32 bg-cover bg-no-repeat bg-center"
						:style="'background-image: url(\'' + photoPreview + '\');'"
					></span>
				</div>

				<jet-secondary-button
					class="mt-2 mr-2"
					type="button"
					@click.prevent="selectNewPhoto"
				>Select A New Photo</jet-secondary-button>
				<jet-input-error
					:message="form.errors.photo"
					class="mt-2"
				/>
			</div>

			<!-- Name -->
			<div class="w-72 mt-5 mx-auto">
				<div class="flex items-center">
					<jet-input
						id="name"
						type="text"
						placeholder="Role Name"
						class="mt-1 block w-full"
						v-model="form.name"
						autocomplete="name"
					/>

					<input
						id="color"
						type="color"
						class="ml-2 w-6 h-6 cursor-pointer"
						v-model="form.color"
					/>

				</div>
				<jet-input-error
					:message="form.errors.name"
					class="mt-2"
				/>
				<jet-input-error
					:message="form.errors.color"
					class="mt-2"
				/>
			</div>

			<!-- actions -->
			<div class="mt-5 text-center">
				<jet-action-message
					:on="form.recentlySuccessful"
					class="mr-3"
				>Updated.</jet-action-message>

				<jet-button
					:class="{ 'opacity-25': form.processing }"
					:disabled="form.processing"
				>update</jet-button>
			</div>
		</card>
		<card class="col-span-12 md:col-span-6 lg:col-span-8 text-gray-700">
			<h2 class="font-medium text-xl"><i class="las la-unlock-alt mr-2"></i>User Have This Permissions.</h2>
			<ul class="grid grid-cols-2 md:grid-cols-1 lg:grid-cols-3 gap-5 mt-4 ml-6">
				<template
					v-for="permission in permissions"
					:key="permission.id"
				>
					<li class="flex items-center group">
						<input
							class="rounded-md border-gray-300 text-groadis shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mr-2"
							:id="`${permission.id}-checkbox`"
							:value="permission.id"
							v-model="form.permissions"
							type="checkbox"
						/>
						<label
							:for="`${permission.id}-checkbox`"
							class="cursor-pointer capitalize min-w-max"
						>{{permission.name.replaceAll('_',' ',) }}</label>
					</li>
				</template>
			</ul>
			<h2 class="font-medium text-xl mt-4"><i class="las la-user-shield mr-2"></i>User Can See this roles.</h2>
			<ul class="grid grid-cols-2 md:grid-cols-1 lg:grid-cols-3 gap-5 mt-4 ml-6">
				<template
					v-for="role in roles"
					:key="role.id"
				>
					<li class="flex items-center group">
						<input
							class="rounded-md border-gray-300 text-groadis shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mr-2"
							:id="`${role.id}-role-checkbox`"
							:value="role.id"
							v-model="form.roles"
							type="checkbox"
						/>
						<label
							:for="`${role.id}-role-checkbox`"
							class="cursor-pointer capitalize min-w-max"
						>{{role.name.replaceAll('_',' ',) }}</label>

					</li>
				</template>
			</ul>
		</card>
	</form>
</template>

<script>
import { defineComponent } from "vue";
import JetButton from "@/components/Button.vue";
import JetInput from "@/components/Input.vue";
import JetInputError from "@/components/InputError.vue";
import JetLabel from "@/components/Label.vue";
import JetSecondaryButton from "@/components/SecondaryButton.vue";
import JetActionMessage from "@/components/ActionMessage.vue";
import Badge from "../../components/badge.vue";
import InputSwitch from "../../components/InputSwitch.vue";

export default defineComponent({
	components: {
		JetActionMessage,
		JetButton,
		JetInput,
		JetInputError,
		JetLabel,
		JetSecondaryButton,
		Badge,
		InputSwitch,
	},
	props: ["role", "permissions", "roles"],
	data() {
		return {
			form: this.$inertia.form({
				name: this.role.name,
				color: this.role.color,
				photo: null,
				permissions: [],
				roles: [],
			}),
			photoPreview: null,
		};
	},
	mounted() {
		this.role.permissions.forEach((permission, index) => {
			this.form.permissions[index] = permission.id;
		});
		this.role.can_see.forEach((role, index) => {
			this.form.roles[index] = role.id;
		});
	},
	methods: {
		updateRole() {
			if (this.$refs.photo) {
				this.form.photo = this.$refs.photo.files[0];
			}
			this.form.put(
				route("roles.update", this.role.id),
				{},
				{
					preserveState: true,
					onSuccess: (page) => {
						this.photoPreview = null;
						this.clearPhotoFileInput();
						this.form.reset();
					},
				}
			);
		},

		selectNewPhoto() {
			this.$refs.photo.click();
		},

		updatePhotoPreview() {
			const photo = this.$refs.photo.files[0];

			if (!photo) return;

			const reader = new FileReader();

			reader.onload = (e) => {
				this.photoPreview = e.target.result;
			};

			reader.readAsDataURL(photo);
		},

		clearPhotoFileInput() {
			if (this.$refs.photo?.value) {
				this.$refs.photo.value = null;
			}
		},
	},
});
</script>
