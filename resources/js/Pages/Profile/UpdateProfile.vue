<template>
<app-layout>
    <jet-form-section @submitted="update">
        <template #title>
            Informações do Perfil
        </template>

        <template #description>
            Atualiza as informações do seu perfil
            <br><br>
            <b-link :href="route('usuarios')"><b-button variant="success" size="sm" class="mr-1">
                Voltar
            </b-button></b-link>
        </template>
        
        <template #form>
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Nome" />
                <jet-input id="name" type="text" class="cb mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>

            <!-- CPF -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="document" value="CPF" />
                <jet-input id="document" type="text" class="cb mt-1 block w-full" v-model="form.document" autocomplete="document" />
                <jet-input-error :message="form.errors.document" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="cb mt-1 block w-full" v-model="form.email" />
                <jet-input-error :message="form.errors.email" class="mt-2" />
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
        props: ['user'],

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'PUT',
                    name: this.user.name,
                    email: this.user.email,
                    document: this.user.document,
                    photo: null,
                }),

                photoPreview: null,
            }
        },

        methods: {
            update() {
                this.form.put(route('usuarios.edit',this.user.id), {
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
    
</style>