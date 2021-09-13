import { usePage } from "@inertiajs/inertia-vue3";
export default function (data) {
    const page = usePage();
    const user = page.props.value.user;

    return user.is_active ? user.can.includes(data) : false;
}
