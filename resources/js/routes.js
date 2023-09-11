import Dashboard from './components/Dashboard.vue';
import ItemList from './pages/items/ItemList.vue';

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
    }
]