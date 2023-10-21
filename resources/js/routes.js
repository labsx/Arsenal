import Dashboard from './components/Dashboard.vue';
import ItemList from './pages/items/ItemList.vue';
import EditItems from './pages/items/EditItem.vue';
import ItemDetails from './pages/items/ItemDetails.vue';
import IssueForm from './pages/items/IssueForm.vue';
import ItemUserUpdate from './pages/item-issued/ItemUserUpdate.vue';
import ReturnForm from './pages/item-issued/ReturnForm.vue';
import UserLists from './pages/users/UsersList.vue';
import UserForm from './pages/users/UserForm.vue';
import UserProfile from './pages/users/UserProfile.vue';
import Login from './pages/auth/Login.vue';
import FieldGroupList from './pages/field/FieldGroupList.vue';
import EditFieldGroups from './pages/field/EditFieldGroups.vue';
import AddField from './pages/field/field-data/FieldList.vue';
import EditFields from './pages/field/field-data/EditFields.vue';
import AddItem from './pages/items/AddItem.vue';
import CategoryList from './pages/category/CategoryList.vue';
import EditCategory from './pages/category/EditCategory.vue';
import EmployeeDetails from './pages/employee/EmployeeDetails.vue';
import EditEmployee from './pages/employee/EditEmployee.vue';

export default [
    {
        path: '/login',
        name: 'admin.login',
        component: Login,
    },
    {
        path: '/admin/employee',
        name: 'admin.employee',
        component: EmployeeDetails,
    },
    {
        path: '/admin/employee/:id/edit',
        name: 'admin.employee.edit',
        component: EditEmployee,
    },
    {
        path: '/admin/field_groups/list',
        name: 'admin.field_groups.list',
        component: FieldGroupList,
    },
    {
        path: '/admin/fields/:id/add',
        name: 'admin.fields/add',
        component: AddField,
    },
    {
        path: '/admin/edit/:id/fields',
        name: 'admin.edit.fields',
        component: EditFields,
    },
    {
        path: '/admin/edit/:id/field_groups',
        name: 'admin.edit.fild.groups',
        component: EditFieldGroups,
    },
    {
        path: '/admin/add/item',
        name: 'admin.add.item',
        component: AddItem,
    },
    {
        path: '/admin/items/:id/edit',
        name: 'admin.items.edit',
        component: EditItems,
    },
    {
        path: '/admin/items/:id/details',
        name: 'admin.items.details',
        component: ItemDetails,
    },
    {
        path: '/admin/category/list',
        name: 'admin.category.list',
        component: CategoryList,
    },
    {
        path: '/admin/category/:id/edit',
        name: 'admin.category.edit',
        component: EditCategory,
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
        path: '/admin/items/:id/issue',
        name: 'admin.items.issue',
        component: IssueForm,
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
    }
]