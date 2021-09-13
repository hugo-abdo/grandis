<template>
	<logo class="w-32" :isDark="isDark" />
</template>
<script>
import Logo from "../components/Logo.vue";
export default {
	props: ["isDark"],
	components: { Logo },
};
</script>
