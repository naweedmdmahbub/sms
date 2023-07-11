<template>
  <div class="app-container">
    <form-component v-if="isMounted" :student="student" :mode="mode" />
  </div>
</template>

<script>
import FormComponent from './FormComponent';
import axios from 'axios';
export default {
  name: 'CreateStudent',
  components: { FormComponent },
  data() {
    return {
      student: {},
      mode: 'view',
      isMounted: false,
    }
  },
  async mounted(){
    const id = this.$route.params && this.$route.params.id;
    await axios.get('/api/students/'+id)
      .then(response => {
        console.log('response:', response);
        this.student = response.data.data;
      });
    this.isMounted = true;
  },
}
</script>

<style>

</style>