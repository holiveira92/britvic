<template>
    <div>
        <jet-banner />
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Bootstrap -->
                <div>
                    <b-navbar toggleable="lg" type="dark" class="navbar-dark-color">
                        <b-navbar-brand :href="route('home')" :active="route().current('home')">Britivic Test</b-navbar-brand>
                        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

                        <b-collapse id="nav-collapse" is-nav>
                        <b-navbar-nav>
                            <b-nav-item :href="route('veiculos')">Veículos</b-nav-item>
                            <b-nav-item :href="route('reservas')">Reservas</b-nav-item>
                            <b-nav-item :href="route('disponibilidade')">Relatório Disponibilidade</b-nav-item>
                        </b-navbar-nav>

                        <!-- Right aligned nav items -->
                        <b-navbar-nav class="ml-auto">
                            <b-nav-item :href="route('usuarios')">Usuários</b-nav-item>
                            <b-nav-item-dropdown right>
                            <!-- Using 'button-content' slot -->
                            <template #button-content>
                                <em>{{ $page.props.user.name }}</em>
                            </template>
                            <b-dropdown-item :href="route('profile.show')">Perfil</b-dropdown-item>
                            <b-dropdown-item :href="route('api-tokens.index')">API Tokens</b-dropdown-item>
                            <!-- Authentication -->
                            <form @submit.prevent="logout">
                                <jet-dropdown-link as="button">
                                    Logout
                                </jet-dropdown-link>
                            </form>
                            </b-nav-item-dropdown>
                        </b-navbar-nav>
                        </b-collapse>
                    </b-navbar>
                </div>
                    
            </nav>

            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>

            <!-- Modal Portal -->
            <portal-target name="modal" multiple>
            </portal-target>
        </div>
    </div>
</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark'
    import JetBanner from '@/Jetstream/Banner'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
    
    export default {
        components: {
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    }
</script>
<style lang="scss">
@import './resources/css/variables';
@import './resources/css/bootstrap';
@import './resources/css/custom';

.navbar-dark-color{
    background-color: #563d7c;
}

.navbar-dark .navbar-nav .nav-link{
    color: #fff
}
    
</style>