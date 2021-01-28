<template>
<app-layout>
    <jet-authentication-card>
        <jet-validation-errors class="mb-2" />

        <form @submit.prevent="submit">
            <div>
                <jet-label for="name" value="Nome" />
                <jet-input id="name" type="text" class="cb mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
            </div>

            <div class="mb-2">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="cb mt-1 block w-full" v-model="form.email" required />
            </div>

            <div class="mb-2">
                <jet-label for="document" value="CPF" />
                <jet-input id="document" type="text" class="cb mt-1 block w-full" v-model="form.document" required autofocus autocomplete="document" />
            </div>

            <div class="mb-2">
                <jet-label for="password" value="Senha" />
                <jet-input id="password" type="password" class="cb mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
            </div>

            <div class="mb-2">
                <jet-label for="password_confirmation" value="Confirm Password" />
                <jet-input id="password_confirmation" type="password" class="cb mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                <jet-label for="terms">
                    <div class="flex items-center" style="display:none;">
                        <jet-checkbox name="terms" id="terms" v-model="form.terms" />

                        <div class="ml-2">
                            Eu concordo com os <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Termos de Serviço</a> e <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Política de Privacidade</a>
                        </div>
                    </div>
                </jet-label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrar
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
                    name: '',
                    email: '',
                    document : '',
                    password: '',
                    password_confirmation: '',
                    terms: true,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('usuarios.create'), {})
            }
        }
    }
</script>

<style lang="scss">

.cb {
    color: black;
}
    
</style>
