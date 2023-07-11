/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const excelRoutes = {
  path: '/inventory',
  component: Layout,
  redirect: '/inventory/departments',
  name: 'Inventory',
  meta: { title: 'inventory', icon: 'nested', permissions: ['view department list'], },
  children: [
    /** Department */
    {
      path: 'departments',
      component: () => import('@/views/departments/List'),
      name: 'DepartmentList',
      meta: { title: 'departments', icon: 'list', permissions: ['view department list'] },
    },
  ],
};

export default excelRoutes;
