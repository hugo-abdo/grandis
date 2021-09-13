<template>
	<transition
		enter-active-class="transition ease-out duration-500"
		enter-from-class="transform opacity-0 scale-95 translate-x-80"
		enter-to-class="transform opacity-100 scale-100 translate-x-0"
		leave-active-class="transition ease-in duration-100"
		leave-from-class="transform opacity-100 scale-100 translate-y-0"
		leave-to-class="transform opacity-0 scale-95 -translate-y-80"
	>
		<div
			class="shadow-md fixed rounded-lg overflow-hidden right-5 top-14 z-50"
			v-if="show && message"
		>
			<div :class="{ 'bg-green-300': style == 'success', 'bg-red-500': style == 'danger' }">
				<div class="py-2 px-3 sm:px-6 lg:px-8">
					<div class="flex items-center justify-between flex-wrap">
						<div class="flex-1 flex items-center">
							<span
								class="flex p-2 rounded-lg"
								:class="{ 'bg-green-400': style == 'success', 'bg-red-600': style == 'danger' }"
							>
								<svg
									class="h-5 w-5 text-white"
									xmlns="http://www.w3.org/2000/svg"
									fill="none"
									viewBox="0 0 24 24"
									stroke="currentColor"
									v-if="style == 'success'"
								>
									<path
										stroke-linecap="round"
										stroke-linejoin="round"
										stroke-width="2"
										d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
									/>
								</svg>

								<svg
									class="h-5 w-5 text-white"
									xmlns="http://www.w3.org/2000/svg"
									fill="none"
									viewBox="0 0 24 24"
									stroke="currentColor"
									v-if="style == 'danger'"
								>
									<path
										stroke-linecap="round"
										stroke-linejoin="round"
										stroke-width="2"
										d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
									/>
								</svg>
							</span>

							<p
								:class="{ 'text-green-700': style == 'success', 'text-white': style == 'danger' }"
								class="ml-3 font-medium text-sm max-w-xs"
							>{{ message }}</p>
						</div>

						<div class="flex-shrink-0 sm:ml-3">
							<button
								type="button"
								class="-mr-1 flex p-2 rounded-md focus:outline-none sm:-mr-2 transition"
								:class="{ 'hover:bg-green-400 focus:bg-green-400': style == 'success', 'hover:bg-red-600 focus:bg-red-600': style == 'danger' }"
								aria-label="Dismiss"
								@click.prevent="show = false"
							>
								<svg
									class="h-5 w-5 text-white"
									xmlns="http://www.w3.org/2000/svg"
									fill="none"
									viewBox="0 0 24 24"
									stroke="currentColor"
								>
									<path
										stroke-linecap="round"
										stroke-linejoin="round"
										stroke-width="2"
										d="M6 18L18 6M6 6l12 12"
									/>
								</svg>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</transition>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
	data() {
		return {
			show: false,
		};
	},

	computed: {
		style() {
			return this.$page.props.jetstream.flash?.bannerStyle || "success";
		},

		message() {
			return this.$page.props.jetstream.flash?.banner || "";
		},
	},

	watch: {
		message() {
			if (!this.show) {
				this.show = true;
				let closeNotification = setTimeout(() => {
					this.show = false;
					this.$page.props.jetstream.flash.banner = null;
					clearTimeout(closeNotification);
				}, 2000);
			}
		},
	},
});
</script>
