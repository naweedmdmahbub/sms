<template>
  <div class="app-container">
    <el-dialog
      :title="formTitle"
      :visible.sync="dialogFormVisible"
    >
      <form-component
        v-if="isMounted"
        :department="department"
        mode="edit"
        @dismissDialog="dismissDialog"
      />
    </el-dialog>
  </div>
</template>

<script>
import FormComponent from './FormComponent';
export default {
  components: { FormComponent },
  props: ['department'],
  data() {
    return {
      loading: true,
      downloading: false,
      formTitle: 'Edit Department',
      dialogFormVisible: false,
      isMounted: false,
    };
  },
  watch: {
    dialogFormVisible(val){
      this.isMounted = val;
      if (!val) {
        this.$emit('dismissDialog'); 
      }
    }
  },
  methods: {
    dismissDialog(){
      this.dialogFormVisible = false;
    },
    handleEditModal(){
      this.dialogFormVisible = true;
    }
  }
}
</script>