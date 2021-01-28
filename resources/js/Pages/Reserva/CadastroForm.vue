<template>
<app-layout>
    <jet-authentication-card class="mgtp-neg60">
        <jet-validation-errors class="mb-2" />

        <form @submit.prevent="submit">
            <div>
                <template>
                <div>
                    <b-form-group class="cb"
                    id="fieldset-1"
                    description="Escolha o usuário"
                    label="Selecione o usuário"
                    label-for="id_user"
                    >
                        <b-form-select id="id_user" name="id_user" v-model="form.user_id" :options="optionsUser" required></b-form-select>
                    </b-form-group>
                </div>
                </template>

                <template>
                <div>
                    <b-form-group class="cb"
                    id="fieldset-2"
                    description="Escolha o Veículo"
                    label="Selecione o veículo"
                    label-for="id_veiculo"
                    >
                        <b-form-select id="id_veiculo" name="id_veiculo" v-model="form.veiculo_id" :options="optionsVeiculos" required></b-form-select>
                    </b-form-group>
                </div>
                </template>

                <template>
                <div>
                    <b-form-group class="cb"
                    id="fieldset-3"
                    description="Selecione a data de início da reserva"
                    label="Data de início"
                    label-for="datepicker-inicio"
                    >
                    <input type="date" id="datepicker-inicio" name="data_inicio" v-model="form.data_inicio" :min="form.data_inicio"/>
                    </b-form-group>
                </div>
                </template>

                <template>
                <div>
                    <b-form-group class="cb"
                    id="fieldset-4"
                    description="Selecione a data de fim da reserva"
                    label="Data de fim"
                    label-for="datepicker-fim"
                    >
                    <input type="date" id="datepicker-fim" name="data_fim" v-model="form.data_fim" :min="form.data_inicio"/>
                    </b-form-group>
                </div>
                </template>

            </div>


            <div class="flex items-center justify-end mt-4">
                <b-link :href="route('reservas')"><b-button variant="secondary" size="sm" class="mr-1">
                    Voltar
                </b-button></b-link>
                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reservar
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</app-layout>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from "@/Jetstream/Checkbox";
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    import AppLayout from '@/Layouts/AppLayout'
    import moment from 'moment'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            AppLayout
        },
        props: ['veiculos','reservas','users'],
        data() {
            return {
                form: this.$inertia.form({
                    user_id: '',
                    veiculo_id: '',
                    data_inicio : moment().format('YYYY-MM-DD'),
                    data_fim: '',
                }),
                optionsUser: this.mountSelectUser(),
                optionsVeiculos: this.mountSelectVeiculos()
            }
        },

        methods: {
            /* tratamento para botão salvar/atualizar */
            submit() {
                this.form.post(this.route('reservas.create'), {})
            },

            /* Define dados para popular o select */
            mountSelectUser(){
                let options = []
                for (let user of this.users){
                    options.push({ value: user.id, text: user.name + " - " + user.document});
                }
                return options
            },

            /* Define dados para popular o select */
            mountSelectVeiculos(){
                let options = []
                for (let veiculo of this.veiculos){
                    options.push({ value: veiculo.id, text: `Modelo: ${veiculo.modelo} - Marca:${veiculo.marca} - Placa: ${veiculo.placa}` });
                }
                return options
            }
        }
    }
</script>

<style lang="scss">

.cb {
    color: black;
}
.mgtp-neg60{
    margin-top:-60px;
}
    
</style>
