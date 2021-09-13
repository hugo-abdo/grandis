<!-- This example requires Tailwind CSS v2.0+ -->
<template>
	<Menu as="div" class="relative inline-block text-left">
		<div>
			<MenuButton>
				<div class="flex items-center cursor-pointer">
					<div class="mr-3 font-semibold text-gray-500 capitalize dark:text-white">
						<span class="block text-sm md:text-base">hugo</span>
						<span class="float-right text-xs">admin</span>
					</div>
					<img
						class="border border-gray-600 rounded-full w-10"
						alt="avatar"
						:src="`https://ui-avatars.com/api/?name=hugo`"
					/>
				</div>
			</MenuButton>
		</div>

		<transition
			enter-active-class="transition ease-out duration-100"
			enter-from-class="transform opacity-0 scale-95"
			enter-to-class="transform opacity-100 scale-100"
			leave-active-class="transition ease-in duration-75"
			leave-from-class="transform opacity-100 scale-100"
			leave-to-class="transform opacity-0 scale-95"
		>
			<MenuItems
				class="origin-top-right absolute right-0 mt-2 whitespace-nowrap min-w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
			>
				<div class="py-1">
					<menu-item-link to="#">Account settings</menu-item-link>
				</div>
			</MenuItems>
		</transition>
	</Menu>
</template>

<script>
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/solid";
import MenuItemLink from "../components/MenuItemLink.vue";

export default {
	components: {
		Menu,
		MenuButton,
		MenuItem,
		MenuItems,
		ChevronDownIcon,
		MenuItemLink,
	},
};
</script>