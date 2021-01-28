<template>
<app-layout>
    <jet-form-section @submitted="update" >
        <template #title>
            Informações do Veículo
        </template>

        <template #description>
            Atualize as informações do veículo
            <br><br>
            <b-link :href="route('veiculos')"><b-button variant="success" size="sm" class="mr-1">
                Voltar
            </b-button></b-link>
        </template>
        
        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="modelo" value="Modelo" />
                <jet-input id="modelo" type="text" class="cb mt-1 block w-full" v-model="form.modelo" required autofocus autocomplete="name" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="marca" value="Marca" />
                <jet-input id="marca" type="text" class="cb mt-1 block w-full" v-model="form.marca" required />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="placa" value="Placa" />
                <jet-input id="placa" type="text" class="cb mt-1 block w-full" v-model="form.placa" required />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="ano" value="Ano" />
                <jet-input id="ano" type="number" class="cb mt-1 block w-full" v-model="form.ano" required />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Salvo com Sucesso.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Salvar
            </jet-button>
        </template>
    </jet-form-section>
</app-layout>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
            AppLayout,
        },
        props: ['veiculos'],

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'PUT',
                    modelo: this.veiculos.modelo,
                    marca: this.veiculos.marca,
                    placa: this.veiculos.placa,
                    ano: this.veiculos.ano,
                }),
            }
        },

        methods: {
            // Tratamento para botão de salvar/atualizar
            update() {
                this.form.put(route('veiculos.edit',this.veiculos.id), {
                    errorBag: 'updateProfileInformation',
                    preserveScroll: true
                });
            },

        },
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