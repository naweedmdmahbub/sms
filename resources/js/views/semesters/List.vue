<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input
        v-model="query.keyword"
        :placeholder="$t('table.keyword')"
        style="width: 200px;"
        class="filter-item"
        @keyup.enter.native="handleFilter"
      />
      <el-button
        v-waves
        class="filter-item"
        type="primary"
        icon="el-icon-search"
        @click="handleFilter"
      >
        {{ $t('table.search') }}
      </el-button>
      <el-button
        v-permission="['add semester']"
        class="filter-item"
        style="margin-left: 10px;"
        type="primary"
        icon="el-icon-plus"
        @click="handleCreate"
      >
        {{ $t('table.add') }}
      </el-button>
    </div>

    <el-table
      v-loading="loading"
      :data="list"
      border
      fit
      highlight-current-row
    >
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column prop="name" align="center" sortable label="Name" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>


      <el-table-column prop="year" align="center" sortable label="Year">
        <template slot-scope="scope">
          <span>{{ scope.row.year }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <el-button
            v-permission="['view semester']"
            type="warning"
            size="small"
            icon="el-icon-view"
            @click="handleShow(scope.row.id);"
          >
            View
          </el-button>
          <el-button
            v-permission="['update semester']"
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="handleEdit(scope.row.id);"
          >
            Edit
          </el-button>
          <el-button
            v-permission="['manage semester']"
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.id, scope.row.name);"
          >
            Delete
          </el-button>

          
          <el-button
            v-permission="['update semester']"
            type="success"
            size="small"
            icon="el-icon-edit"
            @click="handleAssign(scope.row.id);"
          >
            Assign Students
          </el-button>
        </template>
      </el-table-column>

    </el-table>

    
    <div class="app-container">
      <el-dialog
        :title="formTitle"
        :visible.sync="dialogFormVisible"
      >
        <form-component
          :semester="currentSemester"
          :mode="mode"
          @dismissDialog="dismissDialog"
        />
      </el-dialog>

      
      <el-dialog
        :title="formTitle"
        :visible.sync="dialogAssignStudentVisible"
      >
        <assign-student-form
          :semester="currentSemester"
          :mode="mode"
          @dismissDialog="dismissDialog"
        />
      </el-dialog>
    </div>


    <pagination 
      v-show="total>0"
      :total="total"
      :page.sync="query.page"
      :limit.sync="query.limit"
      @pagination="getList"
    />
  </div>
</template>


<script>
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import waves from '@/directive/waves'; // Waves directive
import axios from 'axios';
import permission from '@/directive/permission'; // Permission directive
import Resource from '@/api/resource';
import FormComponent from './FormComponent';
import AssignStudentForm from './AssignStudentForm';
const semesterResource = new Resource('semesters');

export default {
  name: 'SemesterList',
  components: { Pagination, FormComponent, AssignStudentForm },
  directives: { waves, permission },
  data() {
    return {
      list: [],
      total: 0,
      loading: true,
      downloading: false,
      mode: 'create',
      formTitle: 'Create Semester',
      dialogFormVisible: false,
      dialogAssignStudentVisible: false,
      currentSemester: {
        name: '',
        year: '',
      },
      query: {
        page: 1,
        limit: 10,
        keyword: '',
      },
      errors: [],
    };
  },
  async mounted() {
    await this.getList();
  },
  methods: {
    dismissDialog() {
      this.dialogFormVisible = false;
      this.dialogAssignStudentVisible = false;
      this.currentSemester = {
        name: '',
        year: '',
      };
      this.getList();
    },

    async getList() {
      this.loading = true;
      const response = await semesterResource.list(this.query);
      console.log('getList:', response, response.data);
      this.list = response.data;
      this.total = response.meta.total;
      this.loading = false;
    },
    handleFilter() {
      this.query.page = 1;
      this.getList();
    },
    handleCreate(){
      this.mode = 'create';
      this.currentSemester = {
        name: '',
        year: '',
      };
      this.dialogFormVisible = true;
    },
    handleEdit(id){
      this.currentSemester = this.list.find(semester => semester.id === id);
      this.mode = 'edit';
      this.formTitle = 'Edit Semester';
      this.dialogFormVisible = true;
    },
    handleShow(id){
      this.currentSemester = this.list.find(semester => semester.id === id);
      this.mode = 'show';
      this.formTitle = 'Show Semester';
      this.dialogFormVisible = true;
    },
    async handleAssign(id){
      this.currentSemester = this.list.find(semester => semester.id === id);
      console.log('currentSemester', this.currentSemester);
      // this.mode = 'show';
      this.formTitle = 'Assign Students';
      this.dialogAssignStudentVisible = true;
    },
    

    handleDelete(id, name) {
      this.$confirm('This will permanently delete semester ' + name + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        axios
          .delete('api/semesters/'+id)
          .then(response => {
            this.$message({
              type: 'success',
              message: 'Delete completed',
            });
            this.getList();
          }).catch(error => {
            console.log(error);
          });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: 'Delete canceled',
        });
      });
    },
  },
};
</script>
