<template>
	<div class="fixed bottom-10 left-1 !z-[9000] scrollbar max-h-[calc(100vh-5rem)] p-2 overflow-y-scroll  space-y-1.5">
		<transition-group
			enter-active-class="transition ease-out duration-500"
			enter-from-class="transform opacity-0 scale-95 -translate-x-80"
			enter-to-class="transform opacity-100 scale-100 -translate-x-0"
			leave-active-class="transition ease-in duration-500"
			leave-from-class="transform opacity-100 scale-100 -translate-x-0"
			leave-to-class="transform opacity-0 scale-50 -translate-x-80"
		>
			<banner
				v-if="$store.state.banners.length"
				v-for="banner in $store.state.banners"
				:key="banner.id"
				:banner='banner'
				@removeFromeList='removeFromeList'
			/>
		</transition-group>
	</div>
</template>

<script>
import { usePage } from "@inertiajs/inertia-vue3";
import Banner from "./Banner.vue";
import BannerIcon from "./BannerIcon.vue";
import { ref, watch, watchEffect } from "vue";
import { useStore } from "vuex";
export default {
	components: { Banner, BannerIcon },
	setup() {
		const page = usePage();
		const { state } = useStore();
		watchEffect(() => {
			let flash = page.props.value.jetstream?.flash;
			for (const key in flash) {
				if (Object.hasOwnProperty.call(flash, key)) {
					let bannerExist = false;
					state.banners.forEach((item) => {
						if (item.id == flash[key]["id"]) {
							bannerExist = true;
						}
					});
					if (!bannerExist) {
						state.banners.push({
							...flash[key],
						});
					}
				}
			}
		});

		function removeFromeList(id) {
			state.banners = state.banners.filter((item) => item.id !== id);
			delete page.props.value.jetstream.flash[id];
		}
		return { removeFromeList };
	},
};
</script>
