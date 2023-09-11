import Dashboard from './components/Dashboard.vue';
import ItemList from './pages/items/ItemList.vue';
import ItemForm from './pages/items/ItemForm.vue';

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
    }
]