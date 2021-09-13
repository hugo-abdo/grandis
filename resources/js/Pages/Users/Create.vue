<template>
	<app-layout title="Create user">
		<card class="max-w-2xl mx-auto">
			<h3 class="text-center mt-5 text-3xl font-semibold">Create New User</h3>
			<form @submit.prevent="createNewUser">
				<div class="py-5 px-10 grid grid-cols-8 gap-4">
					<divider class="col-span-8 mt-4 mb-2" text="User Info Section" />
					<!-- information aria -->
					<div class="col-span-8 sm:col-span-4">
						<jet-label for="name" value="Full Name" />
						<jet-input
							v-model="form.name"
							id="name"
							type="text"
							class="mt-1 block w-full"
							ref="name"
							autocomplete="name"
						/>
						<jet-input-error :message="form.errors.name" class="mt-2" />
					</div>

					<div class="col-span-8 sm:col-span-4">
						<jet-label for="email" value="email" />
						<jet-input
							v-model="form.email"
							id="email"
							type="email"
							class="mt-1 block w-full"
							ref="email"
							autocomplete="email"
						/>
						<jet-input-error :message="form.errors.email" class="mt-2" />
					</div>

					<div class="col-span-8 sm:col-span-4">
						<jet-label for="role" value="Role" />
						<input-select v-model="form.role" id="role" name="role" autocomplete="role">
							<option v-for="role in roles" :key="role.id" :value="role.id">{{role.name}}</option>
						</input-select>
						<jet-input-error :message="form.errors.role" class="mt-2" />
					</div>

					<!-- divider -->

					<divider class="col-span-8 mt-4 mb-2" text="Password Section" />
					<div class="col-span-8 sm:col-span-4">
						<jet-label for="password" value="password" />
						<jet-input
							v-model="form.password"
							id="password"
							type="password"
							class="mt-1 block w-full"
							ref="password"
							autocomplete="password"
						/>
						<jet-input-error :message="form.errors.password" class="mt-2" />
					</div>
					<div class="col-span-8 sm:col-span-4">
						<jet-label for="password_confirmation" value="password_confirmation" />
						<jet-input
							v-model="form.password_confirmation"
							id="password_confirmation"
							type="password"
							class="mt-1 block w-full"
							ref="password_confirmation"
							autocomplete="password_confirmation"
						/>
						<jet-input-error :message="form.errors.password_confirmation" class="mt-2" />
					</div>
				</div>
				<div class="my-5 flex justify-center items-center">
					<jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Create</jet-button>
					<jet-action-message
						:on="form.recentlySuccessful"
						class="ml-3 font-semibold"
					>User created Successfuly</jet-action-message>
				</div>
			</form>
		</card>
	</app-layout>
</template>

<script>
import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import ActionButton from "@/components/ActionButton.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetButton from "@/Jetstream/Button.vue";
import Divider from "@/components/divider.vue";
import InputSelect from "@components/InputSelect.vue";
export default {
	components: {
		JetLabel,
		JetInput,
		JetInputError,
		ActionButton,
		JetActionMessage,
		JetButton,
		Divider,
		InputSelect,
	},
	props: ["roles"],
	setup() {
		const form = useForm({
			name: "",
			email: "",
			password: "",
			role: 2,
			password_confirmation: "",
			terms: true,
		});
		const createNewUser = function () {
			form.post(route("users.store"), {
				onSuccess(page) {
					form.reset();
				},
			});
		};

		return { createNewUser, form };
	},
};
</script>

<style>
</style>