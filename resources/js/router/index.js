import Home from '../pages/Home'
import About from '../pages/About'
import Login from '~/pages/auth/Login'
import Main from '~/components/layout/Main'

export default {
    mode: 'history',

    routes: [
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/',
            component: Main,
            children: [
                {
                    path: '/',
                    name: 'home',
                    component: Home,
                },
                {
                    path: '/about',
                    name: 'about',
                    component: About,
                },
            ]
        }
    ]
}