<template>
    <div v-if="is_logged_in">
        <h1>Logged in</h1>
        <RouterView />
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
        }
    },

    created() {
        this.token = sessionStorage.getItem("access-token");

        // for login redirect
        this.$appEvents.on('logged-in', () => {
            console.log('calling onPopulateDataUser...');
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
            console.log('Checking session...');
            
            this.is_calling_api = true;

            this.$query("user", {
                action_type: "display_user",
            })
                .then((res) => {
                    this.is_calling_api = false;
                    let response = res.data.data.user[0];
                    console.log('response: ', response);

                })
                .catch(() => {
                    this.is_calling_api = false;
                    this.$swal("Error!", this.global_error_message, "error");
                });
        },
    },
}

</script>