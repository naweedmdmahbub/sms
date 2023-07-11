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
        v-permission="['add department']"
        class="filter-item"
        style="margin-left: 10px;"
        type="primary"
        icon="el-icon-plus"
        @click="handleCreate"
      >
        {{ $t('table.add') }}
      </el-button>
      <el-button
        v-waves
        :loading="downloading"
        class="filter-item"
        type="primary"
        icon="el-icon-download"
        @click="handleDownload"
      >
        {{ $t('table.export') }}
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

      <el-table-column prop="email" align="center" sortable label="Email" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.email }}</span>
        </template>
      </el-table-column>

      <el-table-column prop="number" align="center" sortable label="Number">
        <template slot-scope="scope">
          <span>{{ scope.row.number }}</span>
        </template>
      </el-table-column>

      <el-table-column prop="total_credit" align="center" sortable label="Total Credit">
        <template slot-scope="scope">
          <span>{{ scope.row.total_credit }}</span>
        </template>
      </el-table-column>


      <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <el-button
            v-permission="['view department']"
            type="warning"
            size="small"
            icon="el-icon-view"
            @click="handleShow(scope.row.id);"
          >
            View
          </el-button>
          <el-button
            v-permission="['update department']"
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="handleEdit(scope.row.id);"
          >
            Edit
          </el-button>
          <el-button
            v-permission="['manage department']"
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.id, scope.row.name);"
          >
            Delete
          </el-button>
        </template>
      </el-table-column>

    </el-table>

    <!-- Create Modal -->
    <Create
      ref="createRef"
      :department="currentDepartment"
      @dismissDialog="dismissDialog"
    />
    <!-- Edit Modal -->
    <Edit
      ref="editRef"
      :department="currentDepartment"
      @dismissDialog="dismissDialog"
    />
    <!-- Show Modal -->
    <Show
      ref="showRef"
      :department="currentDepartment"
    />

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
import Create from './Create';
import Edit from './Edit';
import Show from './Show';
const departmentResource = new Resource('departments');

export default {
  name: 'DepartmentList',
  components: { Pagination, Create, Edit, Show },
  directives: { waves, permission },
  data() {
    return {
      list: [],
      total: 0,
      loading: true,
      downloading: false,
      formTitle: 'Create Department',
      currentDepartment: {
        name: '',
        email: '',
        number: '',
        total_credit: '',
        department_head: '',
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
      this.currentDepartment = {
        name: '',
        email: '',
        number: '',
        total_credit: '',
        department_head: '',
      };
      this.getList();
    },

    async getList() {
      this.loading = true;
      const response = await departmentResource.list(this.query);
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
      this.$refs.createRef.handleCreateModal();
    },
    handleEdit(id){
      this.currentDepartment = this.list.find(department => department.id === id);
      this.$refs.editRef.handleEditModal(id);
    },
    handleShow(id){
      this.currentDepartment = this.list.find(department => department.id === id);
      this.$refs.showRef.handleShowModal(id);
    },

    handleDelete(id, name) {
      this.$confirm('This will permanently delete department ' + name + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        axios
          .delete('api/departments/'+id)
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


    handleDownload() {
      this.downloading = true;
      import('@/vendor/Export2Excel').then(excel => {
        const tHeader = ['id', 'name', 'email', 'number', 'total_credit', 'department_head'];
        const filterVal = ['id', 'name', 'email', 'number', 'total_credit', 'department_head'];
        const data = this.formatJson(filterVal, this.list);
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: 'department-list',
        });
        this.downloading = false;
      });
    },
    formatJson(filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => v[j]));
    },
  },
};
</script>
