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
    {
      path: 'students',
      component: () => import('@/views/students/List'),
      name: 'StudentList',
      meta: { title: 'students', noCache: true, icon: 'list', permissions: ['view student list'] },
    },
    /** Semester managements */
    {
      path: 'semesters',
      component: () => import('@/views/semesters/List'),
      name: 'SemesterList',
      meta: { title: 'semesters', noCache: true, icon: 'list', permissions: ['view semester list'] },
    },

  ],
};

export default adminRoutes;
