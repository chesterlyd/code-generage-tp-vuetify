<template>
  <div class="index-content">
    <v-form>
      <v-container>
        <v-row>
          {{ search_form }}
        </v-row>
        <v-row>
          <v-col cols="12" lg="3">
            <v-btn to="/{{controller_name}}/add">
              <v-icon left size="24">mdi-plus</v-icon>
              添加
            </v-btn>
            <v-btn color="success">
              <v-icon left size="24">mdi-magnify</v-icon>
              搜索
            </v-btn>
            <v-btn text color="error">
              <v-icon left size="18">fa-refresh</v-icon>清空
            </v-btn>
          </v-col>
        </v-row>
        <v-row> </v-row>
      </v-container>
    </v-form>
    <l-table
      show-select
      show-expand
      :loading="loading"
      :headers="header"
      :select.sync="tableSelect"
      :data="tableData"
      :expanded.sync="expanded"
      @change="pageChange"
    >
      <template #handler="{ row }">
        <v-btn
          color="primary"
          text
          :to="'/{{controller_name}}/edit?id=' + row.id"
          small
          ><v-icon size="14" left>fa-edit</v-icon>edit</v-btn
        >
        <v-btn color="error" text @click="deleteHandle(row)" small
          ><v-icon size="14" left>fa-trash-o</v-icon>delete</v-btn
        >
        <!-- <l-more-btn small>
					<v-list-item @click="clickHandle" color="error">
						<v-icon size="14" left>fa-trash-o</v-icon>
						delete
					</v-list-item>
					<v-list-item>
						<v-icon size="14" left>fa-trash-o</v-icon>
						delete
					</v-list-item>
				</l-more-btn> -->
      </template>
      <template #expanded-item="{ row }">
        <!-- {{ row.a }} -->
      </template>
    </l-table>
  </div>
</template>

<script lang="ts">
import { Mixins, Component } from "vue-property-decorator";
import index from "index";
import { Data, Headers } from "i";

@Component({
  name: "{{component_name}}",
})
export default class App extends Mixins(index) {
  header: Headers[] = {{table_columns}};
  tableData: Data = {
    current_page: 1,
    data: [],
    last_page: 1,
    per_page: 0,
    total: 0,
  };
  tableConfig = {
    indexUrl: "/admin/{{controller_name}}/index",
    deleteUrl: "/admin/{{controller_name}}/delete",
  };
  expanded = [];
  rules = {{{search_rules}}};
}
</script>

<style lang="scss" scoped></style>
