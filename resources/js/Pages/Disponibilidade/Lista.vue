<template>
<app-layout>
<b-container fluid>
    <template>
      <div style="width:50%;float:left;margin-right:30px;">
          <b-form-group class="cb"
          id="fieldset-2"
          description="Escolha o Veículo"
          label="Selecione o veículo"
          label-for="id_veiculo"
          >
              <b-form-select id="id_veiculo" name="id_veiculo" v-model="selecao.veiculo_id" :options="optionsVeiculos"></b-form-select>
          </b-form-group>
      </div>

      <div style="width:30%;float:left;">
          <b-form-group class="cb"
          id="fieldset-2"
          description="Escolha o Mês"
          label="Selecione o mês"
          label-for="mes"
          >
              <b-form-select id="mes" name="mes" v-model="selecao.mes" :options="optionsMes"></b-form-select>
          </b-form-group>
      </div>

      <div>
        <b-link :href="route('disponibilidade.filter',[selecao.veiculo_id,selecao.mes])"><b-button variant="secondary" size="sm" class="mr-1">
                Filtrar
        </b-button></b-link>
      </div>

    </template>

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
import moment from 'moment'

export default {
    components: {
        AppLayout
    },
    props: ['disponibilidade','veiculos', 'selecao'],
    data() {
      return {
        items: this.disponibilidade,
        fields: [
          { key: 'dia', label: 'Dia', sortable: true, sortDirection: 'desc' },
          { key: 'dia_semana', label: 'Dia Semana', sortable: true, sortDirection: 'desc' },
          { key: 'mes', label: 'Mês', sortable: true, class: 'text-center' },
          { key: 'disponivel', label: 'Disponível', sortable: true, class: 'text-center' },
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
        },
        veiculo_id: 0,
        mesAtual: moment().format("MM"),
        optionsVeiculos: this.mountSelectVeiculos(),
        optionsMes: [
          { value: "01", text: "Janeiro"},
          { value: "02", text: "Fevereiro"},
          { value: "03", text: "Março"},
          { value: "04", text: "Abril"},
          { value: "05", text: "Maio"},
          { value: "06", text: "Junho"},
          { value: "07", text: "Julho"},
          { value: "08", text: "Agosto"},
          { value: "09", text: "Setembro"},
          { value: "10", text: "Outubro"},
          { value: "11", text: "Novembro"},
          { value: "12", text: "Dezembro"}
        ]
      }
    },
    mounted() {},
    methods: {
      /* Define dados para popular o select */
      mountSelectVeiculos(){
          let options = []
          for (let veiculo of this.veiculos){
              options.push({ value: veiculo.id, text: `Modelo: ${veiculo.modelo} - Marca:${veiculo.marca} - Placa: ${veiculo.placa}` });
          }
          return options
      },

      //tratamento do botão submit
      submit() {
          this.form.get(this.route('disponibilidade.filter'), {})
      }
    }
}
</script>

<style lang="scss">

.cb {
  color: black;
}

thead {
    color: black;
    background-color: #fff;
}
tbody tr {
    color: black;
}

</style>