<template>
  <v-content
      no-back
      v-model:tableOptions="tableOptions"
      @on-export="toExport"
      @on-reload="reload"
      @on-reset-search="toResetSearch"
      @on-search="toSearch"
      :search-arrow="true"
  >
    <template #search="{ show }">
      {{ search_form }}
    </template>
    <template #main>
      <el-button
          v-auth=""
          v-ripple
          type="primary"
          icon="Plus"
          size="small"
          @click="toPage('{{ to_add }}')"
          v-once
      >
        添加
      </el-button>
    </template>

    <v-table
        :loading="loading"
        :options="tableOptions"
        :data="tableData"
        @size-change="sizeChange"
        @current-change="currentChange"
        @selection-change="selectionChange"
        :el-table-props="{
				'row-key': 'id',
			}"
    >
      <template #操作="{ id }">
        <el-button
            v-auth=""
            v-ripple
            size="small"
            text
            icon="Edit"
            @click="
						toPage('{{ to_edit }}', {
							id,
						})
					"
        >
          编辑
        </el-button>
        <el-popconfirm title="确认删除该记录, 是否继续?" @confirm="toDelete(id)">
          <template #reference>
            <el-button
                v-auth=""
                v-ripple
                size="small"
                text
                icon="Delete"
            >
              删除
            </el-button>
          </template>
        </el-popconfirm>
      </template>
    </v-table>
  </v-content>
</template>

<script setup>
import { ElMessage } from "element-plus"

const tableOptions = reactive([
  {
    type: "selection",
  },
  {{ table_colum_html }}
  {
    title: "操作",
    width: 200,
  },
])

const {
  toPage,
  loading,
  tableData,
  search,
  toSearch,
  toResetSearch,
  reload,
  sizeChange,
  currentChange,
  selectionChange,
  toExport,
  toDelete,
} = useIndex({
  index: "{{ index_url }}",
  export: "",
  delete: "{{ delete_url }}",
})
</script>

<style lang="scss" scoped></style>
