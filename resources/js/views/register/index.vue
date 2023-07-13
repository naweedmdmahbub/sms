<template>
  <div class="register-container">
    <el-form ref="registerForm" class="register-form" label-position="left">
      <h3 class="title">
        Register
      </h3>
      <lang-select class="set-language" />
      <el-form-item prop="name">
        <span class="svg-container"><svg-icon icon-class="user" /></span>
        <el-input v-model="registerForm.name" name="name" type="text" placeholder="Name" />
      </el-form-item>

      <el-form-item prop="email">
        <span class="svg-container"><svg-icon icon-class="user" /></span>
        <el-input v-model="registerForm.email" name="email" type="text" placeholder="Email" />
      </el-form-item>

      <el-form-item prop="password">
        <span class="svg-container"><svg-icon icon-class="password" /></span>
        <el-input
          v-model="registerForm.password"
          :type="pwdType"
          name="password"
          placeholder="Password"
          @keyup.enter.native="handleRegister"
        />
        <span class="show-pwd" @click="showPwd">
          <svg-icon icon-class="eye" />
        </span>
      </el-form-item>

      <el-form-item prop="password_confirmation">
        <span class="svg-container"><svg-icon icon-class="password" /></span>
        <el-input
          v-model="registerForm.password_confirmation"
          :type="pwdType"
          name="password_confirmation"
          placeholder="Confirm Password"
          @keyup.enter.native="handleRegister"
        />
        <span class="show-pwd" @click="showPwd">
          <svg-icon icon-class="eye" />
        </span>
      </el-form-item>

      <el-form-item>
        <el-button :loading="loading" type="primary" style="width:100%;" @click.native.prevent="handleRegister">
          Register
        </el-button>
      </el-form-item>
    </el-form>
  </div>
</template>


<script>
import LangSelect from '@/components/LangSelect';
import axios from 'axios';
import { showErrors } from '@/utils/helper.js'
// import { validEmail } from '@/utils/validate';
// import { csrf } from '@/api/auth';

export default {
  name: 'StudentRegistration',
  components: { LangSelect },
  data() {
    // const validateEmail = (rule, value, callback) => {
    //   if (!validEmail(value)) {
    //     callback(new Error('Please enter the correct email'));
    //   } else {
    //     callback();
    //   }
    // };
    // const validatePass = (rule, value, callback) => {
    //   if (value.length < 4) {
    //     callback(new Error('Password cannot be less than 4 digits'));
    //   } else {
    //     callback();
    //   }
    // };
    return {
      registerForm: {
        email: '',
        name: '',
        password: '',
        password_confirmation: '',
      },
      loading: false,
      pwdType: 'password',
      redirect: undefined,
      otherQuery: {},
    };
  },
  // watch: {
  //   $route: {
  //     handler: function(route) {
  //       const query = route.query;
  //       if (query) {
  //         this.redirect = query.redirect;
  //         this.otherQuery = this.getOtherQuery(query);
  //       }
  //     },
  //     immediate: true,
  //   },
  // },
  mounted(){
    console.log('mounted register');
  },
  methods: {
    showPwd() {
      if (this.pwdType === 'password') {
        this.pwdType = '';
      } else {
        this.pwdType = 'password';
      }
    },
    handleRegister() {
      axios
        .post('api/student-register', this.registerForm)
        .then(response => {
          this.$message({
            message: 'Student ' + this.student.name + ' has been registered successfully.',
            type: 'success',
            duration: 5 * 1000,
          });
          this.dismissDialog();
        })
        .catch(error => {
          showErrors(error);
        });
    },
    // getOtherQuery(query) {
    //   return Object.keys(query).reduce((acc, cur) => {
    //     if (cur !== 'redirect') {
    //       acc[cur] = query[cur];
    //     }
    //     return acc;
    //   }, {});
    // },
  },
};
</script>

<style rel="stylesheet/scss" lang="scss">
$bg:#2d3a4b;
$light_gray:#eee;

/* reset element-ui css */
.register-container {
  .el-input {
    display: inline-block;
    height: 47px;
    width: 85%;
    input {
      background: transparent;
      border: 0px;
      -webkit-appearance: none;
      border-radius: 0px;
      padding: 12px 5px 12px 15px;
      color: $light_gray;
      height: 47px;
      &:-webkit-autofill {
        -webkit-box-shadow: 0 0 0px 1000px $bg inset !important;
        -webkit-text-fill-color: #fff !important;
      }
    }
  }
  .el-form-item {
    border: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    color: #454545;
  }
}

</style>

<style rel="stylesheet/scss" lang="scss" scoped>
$bg:#2d3a4b;
$dark_gray:#889aa4;
$light_gray:#eee;
.register-container {
  position: fixed;
  height: 100%;
  width: 100%;
  background-color: $bg;
  .register-form {
    position: absolute;
    left: 0;
    right: 0;
    width: 520px;
    max-width: 100%;
    padding: 35px 35px 15px 35px;
    margin: 120px auto;
  }
  .tips {
    font-size: 14px;
    color: #fff;
    margin-bottom: 10px;
    span {
      &:first-of-type {
        margin-right: 16px;
      }
    }
  }
  .svg-container {
    padding: 6px 5px 6px 15px;
    color: $dark_gray;
    vertical-align: middle;
    width: 30px;
    display: inline-block;
  }
  .title {
    font-size: 26px;
    color: $light_gray;
    margin: 0px auto 40px auto;
    text-align: center;
    font-weight: bold;
  }
  .show-pwd {
    position: absolute;
    right: 10px;
    top: 7px;
    font-size: 16px;
    color: $dark_gray;
    cursor: pointer;
    user-select: none;
  }
  .set-language {
    color: #fff;
    position: absolute;
    top: 40px;
    right: 35px;
  }
}
@media screen and (orientation:landscape) and (max-width:1024px) {
  .register-container {
    position: relative;
    overflow-y: auto;
    .register-form {
      transform: translate(-50%, -50%);
      left: 50%;
      top: 50%;
      margin: auto;
    }
  }
}
</style>
