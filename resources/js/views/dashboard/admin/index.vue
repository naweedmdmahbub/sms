<template>
  <div class="dashboard-editor-container">
    <github-corner style="position: absolute; top: 0px; border: 0; right: 0;" />

    <panel-group :departments="departments" :students="students" />

    <el-row :gutter="8">
      <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 24}" :xl="{span: 24}" style="padding-right:8px;margin-bottom:30px;">
        <transaction-table :department_students="department_students" />
      </el-col>
      <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 24}" :xl="{span: 24}" style="padding-right:8px;margin-bottom:30px;">
        <semester-student-table :semester_students="semester_students" />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import GithubCorner from '@/components/GithubCorner';
import PanelGroup from './components/PanelGroup';
import TransactionTable from './components/TransactionTable';
import SemesterStudentTable from './components/SemesterStudentTable';
import axios from 'axios';

export default {
  name: 'DashboardAdmin',
  components: {
    GithubCorner,
    PanelGroup,
    TransactionTable,
    SemesterStudentTable,
  },
  data(){
    return {
      departments: null,
      students: null,
      department_students: null,
      semester_students: null,
    };
  },
  async mounted(){
    await axios.get('/api/get-dashboard-data').then((res) => {
      console.log('mounted', this.departments, res);
      this.departments = res.data.departments;
      this.students = res.data.students;
      this.department_students = res.data.department_students;
      this.semester_students = res.data.semester_students;
    });
  },
  methods: {
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.dashboard-editor-container {
  padding: 32px;
  background-color: rgb(240, 242, 245);
  .chart-wrapper {
    background: #fff;
    padding: 16px 16px 0;
    margin-bottom: 32px;
  }
}
</style>
