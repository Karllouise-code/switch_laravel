<template>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <form @submit.prevent="onSubmit" class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4 pb-5">

                        <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                        <p class="text-white-50 mb-5">Please enter your login and password!</p>

                        <div data-mdb-input-init class="form-outline form-white mb-4">
                            <input v-model="email" type="email" id="typeEmailX" class="form-control form-control-lg" />
                            <label class="form-label" for="typeEmailX">Email</label>
                            <p class="text-danger text-small">{{ email_error }}</p>
                        </div>

                        <div data-mdb-input-init class="form-outline form-white mb-4">
                            <input v-model="password" type="password" id="typePasswordX" class="form-control form-control-lg" />
                            <label class="form-label" for="typePasswordX">Password</label>
                            <p class="text-danger text-small">{{ password_error }}</p>
                        </div>

                        <button :disabled="is_calling_api" type="submit" data-mdb-button-init
                            data-mdb-ripple-init class="btn btn-outline-light btn-lg w-100">
                            <span v-if="is_calling_api" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Login
                        </button>

                        <div class="d-flex justify-content-center text-center mt-4 pt-1">
                            <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                            <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                            <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                        </div>

                        </div>

                        <div>
                        <p class="mb-0">Don't have an account? 
                            <router-link class="text-white-50 fw-bold" :to="{ name: 'register' }">Sign Up</router-link>
                        </p>
                        </div>

                    </div>
                </form>
            </div>
            </div>
        </div>
    </section>
</template>

<script>
import CryptoJS from 'crypto-js';

export default {
    metaInfo: {
        title: 'Switch Laravel - Login',
    },
    
    data() {
        return {
            email: '',
            password: '',

            // errors
            email_error: '',
            password_error: '',

            is_calling_api: false,
        }
    },
    
    methods: {
        onSubmit() {
            this.onClearErrors();
            
            this.is_calling_api = true;

            this.$query("action_user", {
                user: {
                    action_type: "login",
                    email: this.email,
                    password: this.password,
                },
            })
                .then((res) => {
                    this.is_calling_api = false;

                    if (res.data.errors) {
                        let errors = Object.values(res.data.errors[0].extensions.validation).flat();
                        let errors_keys = Object.keys(res.data.errors[0].extensions.validation).flat();

                        this.email_error = errors_keys.some((q) => q == "user.email") ? errors[errors_keys.indexOf("user.email")] : "";
                        this.password_error = errors_keys.some((q) => q == "user.password") ? errors[errors_keys.indexOf("user.password")] : "";
                    } else {

                        // this.onClearFields();

                        let response = res.data.data.user;
                        if (response.error) {
                            this.$swal("Error!", response.message, "error");
                        } else {
                            let secret_passphrase = process.env.MIX_SECRET_PASSPHRASE;
                            
                            const encryptedToken = CryptoJS.AES.encrypt(response.access_token, secret_passphrase).toString();


                            sessionStorage.setItem("access-token", encryptedToken);
                            this.$root.token = encryptedToken;
                            this.$appEvents.emit('logged-in', response.user);
                            this.$router.push({ name: "dashboard" });

                        }

                    }
                    })
                .catch(() => {
                    this.is_calling_api = false;
                    this.$swal("Error!", this.global_error_message, "error");
                });
        },

        onClearErrors() {
            this.email_error = '';
            this.password_error = '';
        },

        onClearFields() {
            this.email = '';
            this.password = '';
        }
    },

}
</script>