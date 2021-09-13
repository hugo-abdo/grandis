<template>
	<!-- Primary Navigation Menu -->
	<div class="shadow rounded-md bg-white" ref="container">
		<div class="inline-flex items-center py-2 px-4 space-x-4 w-full">
			<template v-for="(link,index) in links" :key="index">
				<template v-if="index+1 < showCount">
					<jet-nav-link
						v-if="link.condition"
						:href="route(link.pathName)"
						:active="route().current(link.pathName)"
						:class="['capitalize' ,link.iconClass ? '':'py-1' ]"
					>
						<i v-if="link.iconClass" :class="[link.iconClass,'text-xl mr-1']"></i>
						{{link.name}}
					</jet-nav-link>
				</template>
			</template>

			<jet-dropdown align="right" width="48" v-if="showMore">
				<template #trigger>
					<i class="las la-ellipsis-v text-lg cursor-pointer"></i>
				</template>

				<template #content>
					<template v-for="(link,index) in links" :key="index">
						<template v-if="index+1 > showCount">
							<jet-dropdown-link :href="route(link.pathName)">{{link.name}}</jet-dropdown-link>
						</template>
					</template>
				</template>
			</jet-dropdown>
		</div>
	</div>
</template>

<script>
import JetNavLink from "@/Jetstream/NavLink.vue";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
export default {
	props: { links: Array },
	components: { JetNavLink, JetDropdown, JetDropdownLink },
	data() {
		return {
			containerWith: 0,
		};
	},
	computed: {
		showCount() {
			return this.containerWith / 130;
		},
		showMore() {
			return this.showCount < this.links?.length;
		},
	},

	mounted() {
		this.containerWith = this.$refs.container.offsetWidth;

		window.onresize = () => {
			this.containerWith = this.$refs.container.offsetWidth;
		};
	},
};
</script>