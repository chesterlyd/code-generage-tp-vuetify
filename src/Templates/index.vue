<template>
  <div class="content">
    <div class="card-title">
      <h4></h4>
      <!--      <v-top-echarts :data="tableData.data"></v-top-echarts>-->
    </div>
    <div class="card">
      <Form :model="searchData" inline label-colon ref="form">
        <FormItem>
          {{ search_form }}
          <Button
              type="primary"
              :loading="loading"
              icon="ios-search-outline"
          >
            搜索
          </Button>
          <Button
              type="error"
              icon="ios-sync"
              @click="formResetFields"
          >
            重置
          </Button>
        </FormItem>
      </Form>
      <Table
          ref="table"
          border
          highlight-row
          context-menu
          show-context-menu
          :loading="loading"
          :columns="header"
          :data="tableData.data"
          @on-select="onSelect"
          @on-contextmenu="contextMenuHandle"
      >
        <template #contextMenu>
          <DropdownItem
              @click.native="
							toPage('/{{controller_name}}/edit?id=' + contextLine.id)
						"
          >
            编辑
          </DropdownItem>
          <DropdownItem
              @click.native="deleteHandle"
              style="color: #ed4014"
          >
            删除
          </DropdownItem>
        </template>
      </Table>
      <Row justify="end" class="page">
        <Page
            show-sizer
            show-elevator
            show-total
            transfer
            :total="tableData.total"
            :current.sync="tableData.current_page"
            :page-size="tableData.per_page"
            :page-size-opts="pageSizeOpts"
            @on-page-size-change="onPageSizeChange"
        />
      </Row>
    </div>
  </div>
</template>

<script lang="ts">
import { Mixins, Component } from "vue-property-decorator";
import Index from "index";
import { TableHeader } from "i";

@Component({
  name: "{{component_name}}",
})
export default class App extends Mixins(Index) {
  header: TableHeader[] = {{table_columns}};
tableData = {
  current_page: 1,
  data: [],
  last_page: 1,
  per_page: 0,
  total: 0,
};
config = {
  indexUrl: "/admin/{{controller_name}}/index",
  deleteUrl: "/admin/{{controller_name}}/delete",
};
}
</script>

<style lang="scss" scoped></style>

