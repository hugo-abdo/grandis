<template>
	<div class="h-5 w-full" ref="observerDiv"></div>
</template>

<script>
export default {
	props: ["loding"],
	mounted() {
		const observer = new IntersectionObserver((entries, observer) => {
			if (entries[0].isIntersecting) {
				this.$emit("onObserved");
			}
		});
		observer.observe(this.$refs.observerDiv);
	},
};
</script>