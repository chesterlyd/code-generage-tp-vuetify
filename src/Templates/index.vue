<template>
  <v-content no-back>
    <template #right>
      <el-form inline>
        <el-form-item>
          {{ search_form }}
          <el-button
              icon="el-icon-search"
              size="mini"
              round
              type="primary"
              @click="toSearch"
          >
            搜索
          </el-button>
        </el-form-item>
      </el-form>
    </template>

    <template #main>
      <el-button @click="toPage('./add')" icon="el-icon-plus" size="small"> 添加 </el-button>
    </template>

    <el-table v-loading="loading" :data="tableData.data" @selection-change="selectionChange">
      {{ table_colum_html }}
      <el-table-column label="操作" width="350" align="center" header-align="center">
        <template #default="{ row }">
          <el-button
              type="text"
              size="mini"
              icon="el-icon-edit"
              @click="toPage('./edit', { query: { id: row.id } })"
          >
            编辑
          </el-button>
          <el-popconfirm
              title="是否确定删除？"
              @confirm="toDelete(row)"
              placement="top-end"
          >
            <template #reference>
              <el-button
                  type="text"
                  size="mini"
                  icon="el-icon-delete"
                  style="color: #f56c6c"
              >
                删除
              </el-button>
            </template>
          </el-popconfirm>
        </template>
      </el-table-column>
    </el-table>
    <br />
    <el-row type="flex" justify="end">
      <el-col :span="6">
        <el-pagination
            class="el-pagination"
            background
            layout="total,prev,pager,next,sizes,jumper"
            :current-page="tableData.current_page"
            :page-sizes="[10, 20, 30, 40, 50, 70, 100]"
            :page-size="tableData.per_page"
            :total="tableData.total"
            @size-change="sizeChange"
            @current-change="currentChange"
        >
        </el-pagination>
      </el-col>
    </el-row>
  </v-content>
</template>

<script>
import { defineComponent } from "vue"
import indexMixin from "/index"

export default defineComponent({
  mixins: [indexMixin],
  data() {
    return {
      indexUrl: "/admin/{{controller_name}}/index",
      deleteUrl: "/admin/{{controller_name}}/delete",
    }
  },
  methods: {},
})
</script>

<style lang="scss" scoped></style>
