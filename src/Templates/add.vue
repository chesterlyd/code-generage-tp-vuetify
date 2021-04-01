<template>
  <div class="content edit">
    <div class="card-title">
      <Button @click="toPage(-1)">
        <Icon type="ios-arrow-back" /> 返回
      </Button>
      <h4>添加</h4>
    </div>
    <div class="card">
      <Form
          class="form"
          ref="form"
          :model="formData"
          :rules="rules"
          label-position="left"
          :label-width="120"
      >
        {{ curd_form_group }}
        <Button type="primary" @click="submit">保存</Button>
      </Form>
    </div>
  </div>
</template>

<script lang="ts">
import { Mixins, Component } from "vue-property-decorator"
import Add from "add"

@Component({
  name: "{{component_name}}",
})
export default class App extends Mixins(Add) {
  formData = {{curd_form_field}}
config = {
  addUrl: "/admin/{{controller_name}}/add",
}
}
</script>

<style lang="scss" scoped>
.v-form {
  width: 100%;
  max-width: 950px;
}
</style>
