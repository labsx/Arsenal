import Dashboard from './components/Dashboard.vue';
import ItemList from './pages/items/ItemList.vue';
import ItemForm from './pages/items/ItemForm.vue';
import IssueForm from './pages/items/IssueForm.vue';
import ItemUserList from './pages/item-issued/ItemUserList.vue';
import ItemUserUpdate from './pages/item-issued/ItemUserUpdate.vue';
export default[
 
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
    }
]