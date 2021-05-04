<template>
  <v-content>
    <el-form
        :model="formData"
        :rules="rules"
        class="el-form"
        ref="form"
        label-position="right"
        label-width="80px"
    >
      {{ curd_form_group }}
      <el-form-item>
        <el-button type="primary" @click="submit">保存</el-button>
      </el-form-item>
    </el-form>
  </v-content>
</template>

<script>
import { defineComponent } from "vue"
import addMixin from "/add"

export default defineComponent({
  mixins: [addMixin],
  data() {
    return {
      formData: {{curd_form_field}},
    rules: {},
    addUrl: "/admin/{{controller_name}}/add",

        options: [],
  }
  },
  methods: {},
})
</script>

<style lang="scss" scoped>
.el-form-item {
  &.input {
    width: 780px;
  }
}
</style>
