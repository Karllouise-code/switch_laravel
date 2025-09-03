<template>
    <section class="vh-100 gradient-custom">
        <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">
            <div class="card bg-dark text-white" style="border-radius: 15px;">
                <div class="card-body p-5">
                <h2 class="text-uppercase text-center mb-5">Create an account</h2>

                <form>

                    <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="form3Example1cg" class="form-control form-control-lg" />
                    <label class="form-label" for="form3Example1cg">Your Name</label>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="form3Example3cg" class="form-control form-control-lg" />
                    <label class="form-label" for="form3Example3cg">Your Email</label>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="form3Example4cg" class="form-control form-control-lg" />
                    <label class="form-label" for="form3Example4cg">Password</label>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="form3Example4cdg" class="form-control form-control-lg" />
                    <label class="form-label" for="form3Example4cdg">Repeat your password</label>
                    </div>

                    <div class="form-check d-flex justify-content-center mb-5">
                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3cg" />
                    <label class="form-check-label" for="form2Example3g">
                        I agree all statements in <a href="#!" class="text-body text-white-50"><u>Terms of service</u></a>
                    </label>
                    </div>

                    <div class="d-flex justify-content-center">
                    <button  type="button" data-mdb-button-init
                        data-mdb-ripple-init class="btn btn-outline-light btn-lg w-100">Register</button>
                    </div>

                    <p class="text-center text-white-50 mt-5 mb-0">Have already an account? 
                        <router-link class="fw-bold text-body text-white-50" :to="{ name: 'login' }">Login here</router-link>
                    </p>

                </form>

                </div>
            </div>
            </div>
        </div>
        </div>
    </section>
</template>