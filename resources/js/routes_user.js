const Login = () => import("./front/login.vue");
const Register = () => import("./front/register.vue");

const Dashboard = () => import("./user/dashboard.vue");
const Users = () => import("./user/users.vue");

export default [
    { path: "/login", name: "login", component: Login },
    { path: "/register", name: "register", component: Register },

    { path: "/dashboard", name: "dashboard", component: Dashboard, meta: { requiresAuth: true }  },
    { path: "/users", name: "users", component: Users, meta: { requiresAuth: true }  },
];
