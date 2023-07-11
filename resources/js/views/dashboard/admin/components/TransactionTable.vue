<template>
  <el-table
    :data="department_students"
    style="width: 100%;padding-top: 15px;"
  >
    <el-table-column label="Department" min-width="200">
      <template slot-scope="scope">
        {{ scope.row.name }}
      </template>
    </el-table-column>
    <el-table-column label="Students" min-width="200">
      <template slot-scope="scope">
        {{ scope.row.students_count }}
      </template>
    </el-table-column>
  </el-table>
</template>

<script>
export default {
  props: ['department_students'],
};
</script>
