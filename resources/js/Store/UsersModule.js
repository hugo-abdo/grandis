import { debounce } from "lodash";
import { Inertia } from "@inertiajs/inertia";

export default {
    state() {
        return {
            is_loading: false,
            data: [],
            links: {},
            meta: {},
            selectedUsers: [],
            TableFields: [],
        };
    },
    mutations: {
        INIT(state, { users }) {
            state.data = users.data;
            state.links = users.links;
            state.meta = users.meta;
            state.selectedUsers = [];
        },
        SET_TABLE_FIELDS(state, p) {
            state.TableFields = p;
        },
        PUSH_USERS(state, p) {
            state.data.push(...p.data);
            state.links = p.links;
            state.meta = p.meta;
        },
        SELECTUSERS(state, p) {
            state.selectedUsers = p;
        },
        DELETE_USERS(state, p) {
            state.data = state.data.filter((user) => {
                return !p.includes(user.id);
            });
        },
        UPDATE_USER(state, p) {
            state.data = state.data.map((user) => {
                if (user.id == p.id) {
                    return p;
                }
                return user;
            });
        },
        ADD_USER(state, p) {
            state.data.unshift(p);
        },
    },
    actions: {
        // get users with filter
        getUsersWithFilter: debounce(({ commit, state }, p) => {
            Inertia.get(
                route("users.index"),
                {
                    status: p.status,
                    role: p.role,
                },
                {
                    onSuccess(page) {
                        console.log(page);
                    },
                }
            );
        }, 100),
        // get pagineted users
        getMoreUsers: debounce(({ commit, state }) => {
            if (!state.links.next) {
                return;
            }
            Inertia.get(
                state.links.next,
                {},
                {
                    preserveState: true,
                    preserveScroll: true,
                    onStart() {
                        state.is_loading = true;
                    },
                    onSuccess(page) {
                        commit("PUSH_USERS", page.props.users);
                        state.is_loading = false;
                    },
                }
            );
        }, 500),

        // change user status active or not active
        changeStatus: debounce(({ commit, state }, { id }) => {
            Inertia.get(
                route("user.changeStatus", id),
                {},
                {
                    preserveState: true,
                    preserveScroll: true,
                    onSuccess(page) {
                        state.data = state.data.map((user) => {
                            return user.id == id ? page.props.newUser : user;
                        });
                    },
                }
            );
        }, 500),

        // update user information
        async updateProfileInformation({}, { form, userId }) {
            await form.post(route("users.update", userId), {
                errorBag: "updateProfileInformation",
                preserveScroll: true,
            });
        },
        // delete  user
        async deleteUser({ commit }, { form, userId }) {
            return new Promise((resolve, reject) => {
                form.delete(route("users.destroy", userId), {
                    preserveState: true,
                    preserveScroll: true,
                    onSuccess: () => {
                        form.reset();
                        commit("DELETE_USERS", [userId]);
                        resolve();
                    },
                    onError: () => reject(),
                });
            });
        },
        // delete multiple users
        async deleteMulipelUsers({ commit }, { form, usersSelected }) {
            return new Promise((resolve, reject) => {
                form.delete(route("users.deleteAll"), {
                    preserveState: true,
                    preserveScroll: true,
                    onSuccess: () => {
                        form.reset();
                        commit("DELETE_USERS", usersSelected);
                        resolve();
                    },
                    onError: () => reject(),
                });
            });
        },
        async changeAllUsersStatus({ commit, state }) {
            Inertia.put(
                route("users.changeStatus"),
                { users: state.selectedUsers },
                {
                    preserveState: true,
                    preserveScroll: true,
                    onSuccess(page) {
                        state.selectedUsers.map((id) => {
                            state.data.map((user, index) => {
                                if (user.id == id) {
                                    state.data[index].is_active =
                                        !state.data[index].is_active;
                                }
                            });
                        });
                    },
                }
            );
        },
    },
};
