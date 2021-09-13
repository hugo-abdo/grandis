<template>
	<app-layout title="Edit user">
		<jet-form-section @submitted="updateProfileInformation">
			<template #title>Profile Information</template>

			<template #description>Update your account's profile information and email address.</template>

			<template #form>
				<!-- Profile Photo -->
				<div class="col-span-6 sm:col-span-4" v-if="$page.props.jetstream.managesProfilePhotos">
					<!-- Profile Photo File Input -->
					<input type="file" class="hidden" ref="photo" @change="updatePhotoPreview" />

					<jet-label for="photo" value="Photo" />

					<!-- Current Profile Photo -->
					<div class="mt-2" v-show="! photoPreview">
						<img
							:src="oldUser.profile_photo_url"
							:alt="oldUser.name"
							class="rounded-full h-20 w-20 object-cover"
						/>
					</div>

					<!-- New Profile Photo Preview -->
					<div class="mt-2" v-show="photoPreview">
						<span
							class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
							:style="'background-image: url(\'' + photoPreview + '\');'"
						></span>
					</div>

					<jet-secondary-button
						class="mt-2 mr-2"
						type="button"
						@click.prevent="selectNewPhoto"
					>Select A New Photo</jet-secondary-button>

					<jet-secondary-button
						type="button"
						class="mt-2"
						@click.prevent="deletePhoto"
						v-if="oldUser.profile_photo_path"
					>Remove Photo</jet-secondary-button>

					<jet-input-error :message="form.errors.photo" class="mt-2" />
				</div>
				<!-- Name -->
				<div class="col-span-6 sm:col-span-4">
					<jet-label for="name" value="Name" />
					<jet-input
						id="name"
						type="text"
						class="mt-1 block w-full"
						v-model="form.name"
						autocomplete="name"
					/>
					<jet-input-error :message="form.errors.name" class="mt-2" />
				</div>

				<!-- Email -->
				<div class="col-span-6 sm:col-span-4">
					<jet-label for="email" value="Email" />
					<jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
					<jet-input-error :message="form.errors.email" class="mt-2" />
				</div>
				<div class="col-span-8 sm:col-span-4" v-if="can('change_user_role')">
					<jet-label for="role" value="Role" />
					<select
						v-model="form.role"
						id="role"
						name="role"
						autocomplete="role"
						class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
					>
						<option v-for="role in roles" :key="role.id" :value="role.id">{{role.name}}</option>
					</select>
					<jet-input-error :message="form.errors.role" class="mt-2" />
				</div>
			</template>

			<template #actions>
				<jet-action-message :on="form.recentlySuccessful" class="mr-3">Saved.</jet-action-message>

				<jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save</jet-button>
			</template>
		</jet-form-section>
	</app-layout>
</template>

<script>
import { defineComponent } from "vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";

export default defineComponent({
	components: {
		JetFormSection,
		JetActionMessage,
		JetButton,
		JetInput,
		JetInputError,
		JetLabel,
		JetSecondaryButton,
	},

	props: ["oldUser", "roles"],

	data() {
		return {
			form: this.$inertia.form({
				_method: "PUT",
				name: this.oldUser.name,
				email: this.oldUser.email,
				role: this.oldUser.role?.id,
				photo: null,
			}),
			photoPreview: null,
		};
	},

	methods: {
		async updateProfileInformation() {
			if (this.$refs.photo) {
				this.form.photo = this.$refs.photo.files[0];
			}
			await this.$store.dispatch("updateProfileInformation", {
				form: this.form,
				userId: this.oldUser.id,
			});
			this.clearPhotoFileInput();
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

		deletePhoto() {
			this.$inertia.delete(route("user-photo.destroy", this.oldUser.id), {
				preserveScroll: true,
				onSuccess: (page) => {
					this.photoPreview = null;
					this.clearPhotoFileInput();
				},
			});
		},

		clearPhotoFileInput() {
			if (this.$refs.photo?.value) {
				this.$refs.photo.value = null;
			}
		},
	},
});
</script>
