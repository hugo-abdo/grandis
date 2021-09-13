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
					<jet-input
						id="name"
						type="text"
						placeholder="Role Name"
						class="mt-1 block w-full"
						v-model="form.name"
						autocomplete="name"
					/>
					<jet-input-error :message="form.errors.name" class="mt-2" />
				</div>
				<!-- Color -->
				<div class="w-72 mt-2 mx-auto">
					<div class="flex items-center font-semibold">
						<label for="color">Role Color</label>
						<jet-input id="color" type="color" class="w-20 ml-2" v-model="form.color" />
					</div>
					<jet-input-error :message="form.errors.color" class="mt-2" />
				</div>

				<!-- actions -->
				<div class="mt-5 text-center">
					<jet-action-message :on="form.recentlySuccessful" class="mr-3">Updated.</jet-action-message>

					<jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">update</jet-button>
				</div>
			</card>
			<card class="col-span-12 md:col-span-6 lg:col-span-8">
				<ul class="flex flex-wrap gap-3">
					<li v-for="permission in permissions" :key="permission.id">
						<badge
							@click="()=> $refs[`${permission.name}-chekbox`].click()"
							:class="[
								'text-lg text-white font-medium cursor-pointer',
								form.permissions.includes(permission.id) ? 'bg-groadis' : 'bg-gray-400'
							]"
							:text="permission.name"
						>
							<input
								type="checkbox"
								class="hidden"
								v-model="form.permissions"
								:value="permission.id"
								:ref="`${permission.name}-chekbox`"
							/>
						</badge>
					</li>
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

export default defineComponent({
	components: {
		JetActionMessage,
		JetButton,
		JetInput,
		JetInputError,
		JetLabel,
		JetSecondaryButton,
		Badge,
	},
	props: ["role", "permissions"],
	data() {
		return {
			form: this.$inertia.form({
				name: this.role.name,
				color: this.role.color,
				photo: null,
				permissions: [],
			}),
			photoPreview: null,
		};
	},
	mounted() {
		this.role.permissions.forEach((permission, index) => {
			this.form.permissions[index] = permission.id;
		});
	},
	methods: {
		is_checked(refName) {},

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
