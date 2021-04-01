<template>
  <div class="">
    <v-form class="v-form" ref="v-form" v-model="valid" lazy-validation>
      {{ curd_form_group }}
      <v-btn color="success" :disabled="!valid" @click="submit">保存</v-btn>
    </v-form>
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
