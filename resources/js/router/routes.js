import Login from '~/pages/auth/Login';
import NotFound from '~/pages/errors/NotFound';
import Main from '~/components/layout/Main';
import JobList from '~/pages/job/JobList';
import JobShow from '~/pages/job/JobShow';
import JobEdit from '~/pages/job/JobEdit';
import UserList from '~/pages/user/UserList';
import UserShow from '~/pages/user/UserShow';
import UserEdit from '~/pages/user/UserEdit';

export default [
    {
        path: '/login',
        name: 'login',
        component: Login,
    },
    {
        path: '/dashboard',
        component: Main,
        children: [
            {
                path: '/users',
                name: 'users.list',
                component: UserList,
            },
            {
                path: '/users/:userId',
                name: 'users.show',
                component: UserShow,
            },
            {
                path: '/users/:userId/edit',
                name: 'users.edit',
                component: UserEdit,
            },
            {
                path: '/jobs',
                name: 'jobs.list',
                component: JobList,
            },
            {
                path: '/jobs/:jobId',
                name: 'jobs.show',
                component: JobShow,
            },
            {
                path: '/jobs/:jobId/edit',
                name: 'jobs.edit',
                component: JobEdit,
            },
        ],
    },
    {
        path: '*',
        name: 'notfound',
        component: NotFound,
    },
];
