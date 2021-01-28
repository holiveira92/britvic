<template>
<app-layout>
    <jet-authentication-card class="mgtp-neg60">
        <jet-validation-errors class="mb-2" />

        <form @submit.prevent="submit">
            <div>
                <jet-label for="modelo" value="Modelo" />
                <jet-input id="modelo" type="text" class="cb mt-1 block w-full" v-model="form.modelo" required autofocus autocomplete="name" />
            </div>

            <div class="mb-2">
                <jet-label for="marca" value="Marca" />
                <jet-input id="marca" type="text" class="cb mt-1 block w-full" v-model="form.marca" required />
            </div>

            <div class="mb-2">
                <jet-label for="placa" value="Placa" />
                <jet-input id="placa" type="text" class="cb mt-1 block w-full" v-model="form.placa" required />
            </div>

            <div class="mb-2">
                <jet-label for="ano" value="Ano" />
                <jet-input id="ano" type="number" class="cb mt-1 block w-full" v-model="form.ano" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Cadastrar
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

        data() {
            return {
                form: this.$inertia.form({
                    modelo: '',
                    marca: '',
                    placa : '',
                    ano: '',
                })
            }
        },

        methods: {
            /* Tratamento para botão salvar/atualizar */
            submit() {
                this.form.post(this.route('veiculos.create'), {})
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
