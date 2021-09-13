<template>
	<div class="bg-white w-full p-2 shadow">
		<div class="flex justify-between items-center container mx-auto">
			<!-- app logo -->
			<div>
				<logo class="w-32" />
			</div>
			<!-- user info -->
			<user-dropdown />
		</div>
	</div>
	<navbar />
</template>
<script>
import { ref } from "vue";
import Logo from "../components/Logo.vue";
import Navbar from "../components/Navbar.vue";
import UserDropdown from "../components/layout./../Layouts/userDropdown.vue";
export default {
	components: {
		Logo,
		Navbar,
		UserDropdown,
	},
	setup() {
		const showUserDropdown = ref(false);
		return { showUserDropdown };
	},
};
</script>
