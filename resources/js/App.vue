<template>
    <template v-if="is_landing">
        <router-view />
    </template>
    
    <div v-else-if="!is_landing && is_logged_in">
        <h1>Logged in</h1>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">User Portal</div>
            <div class="list-group list-group-flush">
                <router-link :to="{ name: 'dashboard' }" class="list-group-item list-group-item-action list-group-item-light p-3">Dashboard</router-link>
                <router-link :to="{ name: 'users' }" class="list-group-item list-group-item-action list-group-item-light p-3">Users</router-link>
            </div>
            </div>

            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle" @click="toggleSidebar">Toggle Menu</button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ name }}</a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="javaScript:void(0);">Profile</a>
                            <div class="dropdown-divider"></div>
                            <a @click="onLogout" class="dropdown-item" href="javaScript:void(0);">Logout</a>
                            </div>
                        </li>
                        </ul>
                    </div>
                    </div>
                </nav>
                <RouterView />
            </div>
        </div>
    </div>

    <div v-else>
        <h1>Logged Out</h1>
        <RouterView />
    </div>

</template>


<script>
export default {
    name: "App",

    data() {
        return {
            is_calling_api: false,

            is_logged_in: false,
            token: sessionStorage.getItem("access-token") || null,
            name: '',
            is_landing: true,
        }
    },

    created() {
        this.token = sessionStorage.getItem("access-token");

        // for login redirect
        this.$appEvents.on('logged-in', () => {
            this.is_logged_in = true;
            this.onPopulateDataUser();
        });

        // for reload page
        if (this.token) {
            this.is_logged_in = true;
            this.onPopulateDataUser();

        } else {
            this.is_logged_in = false;
        }  
    },

    methods: {
        onPopulateDataUser() {
            this.is_calling_api = true;

            this.$query("user", {
                action_type: "display_user",
            })
                .then((res) => {
                    this.is_calling_api = false;
                    let response = res.data.data.user[0];
                    this.name = response.name;

                })
                .catch((err) => {
                    if (err.response && err.response.status === 401) {
                        sessionStorage.clear();
                        window.location.href = "/login";
                    } else {
                        this.is_calling_api = false;
                        this.$swal("Error!", this.global_error_message, "error");
                    }

                });
        },

        onLogout() {
            this.token = null;
            this.is_logged_in = false;
            sessionStorage.removeItem("access-token");
            // if not yet on login route redirect to login
            if (this.$route.name !== "login") {
                this.$router.push({ name: "login" });
            }
        },

        toggleSidebar() {
            document.body.classList.toggle("sb-sidenav-toggled");
            localStorage.setItem(
                "sb|sidebar-toggle",
                document.body.classList.contains("sb-sidenav-toggled")
            );
        
        },
    },

    watch: {
        $route(to, from) {
            if (to.meta.isLanding) {
                this.is_landing = true;
            } else {
                this.is_landing = false;
            }
        }
    }
}

</script>