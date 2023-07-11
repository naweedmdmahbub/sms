/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const adminRoutes = {
  path: '/administrator',
  component: Layout,
  redirect: '/administrator/users',
  name: 'Administrator',
  alwaysShow: true,
  meta: {
    title: 'administrator',
    icon: 'admin',
    permissions: ['view menu administrator'],
  },
  children: [
    /** User managements */
    {
      path: 'users/edit/:id(\\d+)',
      component: () => import('@/views/users/UserProfile'),
      name: 'UserProfile',
      meta: { title: 'userProfile', noCache: true, permissions: ['manage user'] },
      hidden: true,
    },
    {
      path: 'users',
      component: () => import('@/views/users/List'),
      name: 'UserList',
      meta: { title: 'users', icon: 'user', permissions: ['manage user'] },
    },
    /** Role and permission */
    {
      path: 'roles',
      component: () => import('@/views/role-permission/List'),
      name: 'RoleList',
      meta: { title: 'rolePermission', icon: 'role', permissions: ['manage permission'] },
    },
    /** Department */
    {
      path: 'departments',
      component: () => import('@/views/departments/List'),
      name: 'DepartmentList',
      meta: { title: 'departments', icon: 'list', permissions: ['view department list'] },
    },
    
    /** Student managements */
    // {
    //   path: 'students/view/:id',
    //   component: () => import('@/views/students/View'),
    //   name: 'ViewStudent',
    //   meta: { title: 'viewStudent', permissions: ['view student'] },
    //   hidden: true,
    // },
    // {
    //   path: 'students/edit/:id',
    //   component: () => import('@/views/students/Edit'),
    //   name: 'EditStudent',
    //   meta: { title: 'editStudent', permissions: ['update student'] },
    //   hidden: true,
    // },
    // {
    //   path: 'students/create',
    //   component: () => import('@/views/students/Create'),
    //   name: 'CreateStudent',
    //   meta: { title: 'createStudent', permissions: ['add student'] },
    //   hidden: true,
    // },
    {
      path: 'students',
      component: () => import('@/views/students/List'),
      name: 'StudentList',
      meta: { title: 'students', noCache: true, icon: 'list', permissions: ['view student list'] },
    },

  ],
};

export default adminRoutes;
