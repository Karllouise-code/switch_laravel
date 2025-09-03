const Index = () => import("./pages/index.vue");
const Home = () => import("./pages/home.vue");
const About = () => import("./pages/about.vue");
const Login = () => import("./front/login.vue");
const Register = () => import("./front/register.vue");

export default [
    {
        path: "/",
        name: "Index",
        component: Index,
        children: [
            {
                path: "/",
                name: "home",
                component: Home,
            },
            {
                path: "/about",
                name: "about",
                component: About,
            },
        ],
    },

    { path: "/login", name: "login", component: Login },
    { path: "/register", name: "register", component: Register },
];
