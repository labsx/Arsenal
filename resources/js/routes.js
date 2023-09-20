import Dashboard from './components/Dashboard.vue';
import ItemList from './pages/items/ItemList.vue';
import ItemForm from './pages/items/ItemForm.vue';
import IssueForm from './pages/items/IssueForm.vue';
import ItemUserList from './pages/item-issued/ItemUserList.vue';
import ItemUserUpdate from './pages/item-issued/ItemUserUpdate.vue';
import ReturnForm from './pages/item-issued/ReturnForm.vue';
import History from './pages/history/History.vue';
import UserLists from './pages/users/UsersList.vue';
import UserForm from './pages/users/UserForm.vue';
import UserProfile from './pages/users/UserProfile.vue';
import Login from './pages/auth/Login.vue';
import ItemsCount from './pages/items-count/ItemsCount.vue';

export default[
    {
        path: '/login',
        name: 'admin.login',
        component: Login,
    },
    {
        path: '/admin/dashboard',
        name: 'admin.dashboard',
        component: Dashboard,
    },
    {
        path: '/admin/items/list',
        name: 'admin.items.list',
        component: ItemList,
    },
    {
        path: '/admin/items/create',
        name: 'admin.items.create',
        component: ItemForm,
    },
    {
        path: '/admin/items/:id/edit',
        name: 'admin.items.edit',
        component: ItemForm,
    },
    {
        path: '/admin/items/:id/issue',
        name: 'admin.items.issue',
        component: IssueForm,
    },
    {
        path: '/admin/items/issue/list',
        name: 'admin.items.issue.list',
        component: ItemUserList,
    },
    {
        path: '/admin/items/:id/lists',
        name: 'admin.items.issue.lists',
        component: ItemUserUpdate,
    },
    {
        path: '/admin/items/:id/return',
        name: 'admin.items.return',
        component: ReturnForm,
    },
    {
        path: '/admin/items/history',
        name: 'admin.items.history',
        component: History,
    },
    {
        path: '/admin/users',
        name: 'admin.users',
        component: UserLists,
    },
    {
        path: '/admin/users/create',
        name: 'admin.users.create',
        component: UserForm,
    },
    {
        path: '/admin/users/update',
        name: 'admin.users.update',
        component: UserProfile,
    },
    {
        path: '/admin/list/count',
        name: 'admin.list.count',
        component: ItemsCount,
    }
]