import { debounce } from "lodash";
import { Inertia } from "@inertiajs/inertia";
export default {
    searche: debounce(({ commit, state }, p) => {
        Inertia.get(
            p.route,
            { ...p.searcheData },
            {
                preserveState: true,
                onSuccess(page) {
                    commit("INIT", page.props);
                },
            }
        );
    }, 500),
};
