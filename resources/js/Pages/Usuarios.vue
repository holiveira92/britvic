<template>
<app-layout>
<b-container fluid>
    <!-- User Interface controls -->
    <b-row style="padding:20px;">
      <b-link :href="route('usuarios.create')"><b-button variant="success" size="sm" class="mr-1">
          Novo Usuário
        </b-button></b-link>
      <b-col lg="6" class="my-1">
        <b-form-group
          label=""
          label-for="filter-input"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          class="mb-0"
        > 
        
          <b-input-group size="sm">
            <b-form-input
              id="filter-input"
              v-model="filter"
              type="search"
              placeholder="Buscar"
            ></b-form-input>

            <b-input-group-append>
              <b-button :disabled="!filter" @click="filter = ''">Limpar</b-button>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>
      </b-col>
    </b-row>

    <!-- Main table element -->
    <b-table
      :items="items"
      :fields="fields"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filter"
      :filter-included-fields="filterOn"
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      :sort-direction="sortDirection"
      stacked="md"
      show-empty
      small
    >
      <template #cell(name)="row">
        {{ row.value }}
      </template>

      <template #cell(actions)="row">
        <b-link :href="route('usuarios.edit', row.item.id)"><b-button size="sm" class="mr-1">
          Editar
        </b-button></b-link>
        <b-button variant="danger" size="sm" class="mr-1" @click.prevent="confirmDelete($event,row.item.id)">
          Excluir
        </b-button>
        <a :href="route('usuarios.delete', row.item.id)" :id="'delBtn_' + row.item.id"></a>
      </template>

      <template #row-details="row">
        <b-card>
          <ul>
            <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
          </ul>
        </b-card>
      </template>
    </b-table>

  </b-container>
</app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'

export default {
    components: {
        AppLayout,
    },
    props: ['users'],
    data() {
      return {
        items: this.users,
        fields: [
          { key: 'name', label: 'Nome', sortable: true, sortDirection: 'desc' },
          { key: 'document', label: 'CPF', sortable: true, class: 'text-center' },
          { key: 'email', label: 'Email', sortable: true, class: 'text-center' },
          { key: 'actions', label: 'Ações' }
        ],
        totalRows: 1,
        currentPage: 1,
        perPage: 100,
        pageOptions: [5, 10, 15, { value: 100, text: "Show a lot" }],
        sortBy: '',
        sortDesc: false,
        sortDirection: 'asc',
        filter: null,
        filterOn: [],
        infoModal: {
          id: 'info-modal',
          title: '',
          content: ''
        }
      }
    },
    mounted() {},
    methods: {
      confirmDelete: function (event,id) {
        event.preventDefault()
        if(confirm("Deseja realmente excluir este usuário?") == true) {
          var elem = document.getElementById("delBtn_" + id)
          elem.click()
        }
      }
    }
}
</script>

<style lang="scss">

thead {
    color: black;
    background-color: #fff;
}
tbody tr {
    color: black;
}

</style>