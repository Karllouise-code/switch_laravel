const Login = () => import("./front/login.vue");
const Register = () => import("./front/register.vue");

const Dashboard = () => import("./user/dashboard.vue");

export default [
    { path: "/login", name: "login", component: Login },
    { path: "/register", name: "register", component: Register },

    { path: "/dashboard", name: "dashboard", component: Dashboard, meta: { requiresAuth: true }  },
];
