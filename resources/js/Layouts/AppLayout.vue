<template>
	<Head :title="title" />

	<side-bar :links="links" v-if="links.length" />
	<!-- Page Content -->
	<main
		:class="[
				'pt-32 pb-5 duration-200 mx-4',
				$store.state.sideBarActive ? 'sm:ml-56': 'sm:ml-14'
			]"
	>
		<div class="max-w-7xl mx-auto">
			<slot></slot>
		</div>
	</main>
</template>

<script>
import { defineComponent } from "vue";
import JetApplicationMark from "@/Jetstream/ApplicationMark.vue";
import SideBar from "@/components/SideBar.vue";
import can from "@/mixins";
import { Head, Link, usePage } from "@inertiajs/inertia-vue3";

export default defineComponent({
	props: { title: String },

	components: { Head, JetApplicationMark, SideBar },

	setup() {
		const links = [
			{
				name: "users",
				pathName: "users.index",
				iconClass: "las la-users",
				condition: can("show_user"),
			},
			{
				name: "roles",
				pathName: "roles.index",
				iconClass: "las la-user-shield",
				condition: can("show_role"),
			},
			{
				name: "shop",
				pathName: "shop.index",
				iconClass: "las la-store-alt",
				condition: can("show_product"),
			},
		];
		return { links };
	},
});
</script>