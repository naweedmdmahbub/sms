<template>
  <div class="form-container">
    <el-form
      ref="departmentForm"
      :model="department"
      label-position="left"
      label-width="150px"
      style="max-width: 500px;"
    >
      <el-form-item label="Name" prop="name">
        <el-input
          v-model="department.name"
          :disabled="mode == 'show'"
        />
      </el-form-item>
      <el-form-item label="Number" prop="number">
        <el-input
          v-model="department.number"
          :disabled="mode == 'show'"
        />
      </el-form-item>
      <el-form-item label="Total Credit" prop="total_credit">
        
      <!-- <el-input-number v-model="department.total_credit" controls-position="right" @change="handleChange">

      </el-input-number> -->
        <el-input-number
          v-model="department.total_credit"
          style="width:100%;"
          :disabled="mode == 'show'"
          controls-position="right"
        />
      </el-form-item>
      <el-form-item label="Department Head" prop="department_head">
        <el-input
          v-model="department.department_head"
          :disabled="mode == 'show'"
        />
      </el-form-item>
      <el-form-item label="Email" prop="email">
        <el-input
          v-model="department.email"
          type="email"
          :disabled="mode == 'show'"
        />
      </el-form-item>
      
    </el-form>
    <div
      slot="footer"
      class="dialog-footer"
    >
      <el-button @click="dismissDialog">
        Cancel
      </el-button>
      <el-button
        v-if="mode !== 'show'"
        type="primary"
        @click="handleSubmit"
      >
        Confirm
      </el-button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  props: ['mode', 'department'],
  data() {
    return {
      loading: true,
      downloading: false,
      errors: [],
    };
  },
  methods: {
    dismissDialog() {
      this.$emit('dismissDialog');
    },
    async handleSubmit() {
      this.errors = [];
      let data = new FormData();
      await data.append('image', this.department.image);
      for (var key in this.department) {
        data.append(key, this.department[key]);
      }
      console.log('data:', data, this.department);


      var offset = 0;
      if (this.department.id !== undefined) {
        axios
          .put('api/departments/'+this.department.id, this.department)
          .then(response => {
            this.$message({
              type: 'success',
              message: 'Department info has been updated successfully',
              duration: 5 * 1000,
            });
            this.dismissDialog();
          })
          .catch(error => {
            console.log('error:', error);
            this.errors = error.response.data.errors;
            Object.entries(this.errors).forEach(([key, value]) => {
              this.$notify.error({
                title: 'Error',
                message: value[0],
                offset: offset,
              });
              offset += 60;
            });
          });
      } else {
        axios
          .post('api/departments', data)
          .then(response => {
            this.$message({
              message: 'New department ' + this.department.name + ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.dismissDialog();
          })
          .catch(error => {
            this.errors = error.response.data.errors;
            var offset = 0;
            Object.entries(this.errors).forEach(([key, value]) => {
              this.$notify.error({
                title: 'Error',
                message: value[0],
                offset: offset,
              });
              offset += 60;
            });
          });
      }
    },
    
    onFileChange(event){
        this.department.image = event.target.files[0];
        this.imageUrl = URL.createObjectURL(this.department.image);
        console.log('onFileChange: ', event.target.files);
        console.log('this.department.image: ', this.department.image);
        console.log('imageUrl: ', this.imageUrl);
        // this.imageUrl = event.target.files[0].name;
    },
  }
};
</script>
