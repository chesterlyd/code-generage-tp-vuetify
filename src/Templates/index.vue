<template>
  <v-content no-back>
    <template #right>
    </template>

    <template #main>
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
      <el-button @click="toPage('./add')" icon="el-icon-plus" size="small"> 添加 </el-button>
    </template>

    <v-table :loading="loading" :options="tableOptions" :data="tableData.data" @selection-change="selectionChange">
        <template #handler="{ row }">
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
    </v-table>
  </v-content>
</template>

<script>
import { defineComponent } from "vue"
import indexMixin from "/index"

export default defineComponent({
  mixins: [indexMixin],
  data() {
    return {
      module: '{{controller_name}}',
      tableOptions: [
        {{ table_colum_html }}
      ],
    }
  },
  methods: {},
})
</script>

<style lang="scss" scoped></style>
