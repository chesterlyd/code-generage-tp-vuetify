<template>
  <v-content>
    <el-form :rules="rules" ref="form" :model="formData">
      {{ curd_form_group }}
    </el-form>
    <template #footer>
      <el-button v-ripple type="danger" icon="Back" @click="toPage(-1)">返回</el-button>
      <el-button v-ripple type="warning" icon="Delete" :disabled="disabled" @click="deleteTemporary">
        删除暂存数据
      </el-button>
      <el-button
          v-ripple
          :loading="temporaryLoading"
          type="primary"
          icon="Brush"
          :disabled="disabled"
          @click="temporary"
      >
        暂存
      </el-button>
      <el-button v-ripple :loading="loading" type="success" icon="Check" :disabled="disabled" @click="submit">
        保存
      </el-button>
    </template>
  </v-content>
</template>

<script setup>
const rules = {}
const { toPage,loading, temporaryLoading, disabled, form, formData, submit, temporary, deleteTemporary } = useEdit({
  url: "/demo/tmpDemoGenerate/info",
  submitUrl: "/demo/tmpDemoGenerate/edit",
  formData: {{curd_form_field}},
})
</script>

<style lang="scss" scoped></style>
