const Index = () => import("./pages/index.vue");
const Home = () => import("./pages/home.vue");
const About = () => import("./pages/about.vue");

export default [
    {
        path: "/",
        name: "Index",
        component: Index,
        meta: { isLanding: true },
        children: [
            {
                path: "/",
                name: "home",
                component: Home,
                meta: { isLanding: true },
            },
            {
                path: "/about",
                name: "about",
                component: About,
                meta: { isLanding: true },
            }
        ],
    },
];
