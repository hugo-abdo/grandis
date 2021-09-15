<template>
	<app-layout title="Create New Role">
		<form @submit.prevent="updateRole" class="grid grid-cols-12 gap-2">
			<card class="col-span-12 md:col-span-6 lg:col-span-4">
				<!-- Profile Photo -->
				<div class="w-max mx-auto flex items-center flex-col">
					<!-- Profile Photo File Input -->
					<input type="file" class="hidden" ref="photo" @change="updatePhotoPreview" />

					<!-- Current Profile Photo -->
					<div class="mt-2" v-show="! photoPreview">
						<img
							:src="`/storage/roles/${role.name}.png`"
							class="rounded-full h-32 w-32 object-cover border bg-white shadow-md p-2"
						/>
					</div>

					<!-- New Profile Photo Preview -->
					<div class="mt-2" v-show="photoPreview">
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
					<jet-input-error :message="form.errors.photo" class="mt-2" />
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
						<jet-input
							id="color"
							type="color"
							class="w-12 h-10 ml-2 cursor-pointer"
							v-model="form.color"
						/>
					</div>
					<jet-input-error :message="form.errors.name" class="mt-2" />
					<jet-input-error :message="form.errors.color" class="mt-2" />
				</div>

				<!-- actions -->
				<div class="mt-5 text-center">
					<jet-action-message :on="form.recentlySuccessful" class="mr-3">Updated.</jet-action-message>

					<jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">update</jet-button>
				</div>
			</card>
			<card class="col-span-12 md:col-span-6 lg:col-span-8 text-gray-700">
				<h2 class="font-medium">Permissions :</h2>
				<ul class="grid grid-cols-12 gap-5 mt-2">
					<template v-for="permission in permissions" :key="permission.id">
						<li class="col-span-6 sm:col-span-4 md:col-span-6 flex justify-between items-center group">
							<label
								:for="`${permission.id}-checkbox`"
								class="cursor-pointer capitalize min-w-max"
							>{{permission.name.replaceAll('_',' ',) }}</label>
							<label
								:for="`${permission.id}-checkbox`"
								class="cursor-pointer border-b-4 border-dashed w-full mx-2 group-hover:border-groadis"
							></label>
							<input
								class="focus:ring-0 text-groadis"
								:id="`${permission.id}-checkbox`"
								:value="permission.id"
								v-model="form.permissions"
								type="checkbox"
							/>
						</li>
					</template>
				</ul>
				<h2 class="font-medium mt-4">User Can See this roles :</h2>
				<ul class="grid grid-cols-12 gap-5 mt-2">
					<template v-for="role in roles" :key="role.id">
						<li class="col-span-6 sm:col-span-4 md:col-span-6 flex justify-between items-center group">
							<label
								:for="`${role.id}-role-checkbox`"
								class="cursor-pointer capitalize min-w-max"
							>{{role.name.replaceAll('_',' ',) }}</label>
							<label
								:for="`${role.id}-role-checkbox`"
								class="cursor-pointer border-b-4 border-dashed w-full mx-2 group-hover:border-groadis"
							></label>
							<input
								class="focus:ring-0 text-groadis"
								:id="`${role.id}-role-checkbox`"
								:value="role.id"
								v-model="form.roles"
								type="checkbox"
							/>
						</li>
					</template>
				</ul>
			</card>
		</form>
	</app-layout>
</template>

<script>
import { defineComponent } from "vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
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
			this.form.put(route("roles.update", this.role.id), {
				onSuccess: (page) => {
					this.photoPreview = null;
					this.clearPhotoFileInput();
					this.form.reset();
				},
			});
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
