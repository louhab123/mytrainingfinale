<template>
  <v-navigation-drawer
    :value="isDrawerOpen"
    app
    floating
    width="260"
    class="app-navigation-menu"
    :right="$vuetify.rtl"
    @input="val => $emit('update:is-drawer-open', val)"
  >
    <!-- Navigation Header -->
    <div class="vertical-nav-header d-flex items-center ps-6 pe-5 pt-5 pb-2">
      <router-link to="/" class="d-flex align-center text-decoration-none">
        <v-img
          :src="require('@/assets/images/logos/logo.png').default"
          max-height="300px"
          max-width="200px"
          alt="logo"
          contain
          eager
          class="app-logo me-3"
        ></v-img>
        <v-slide-x-transition>
        
        </v-slide-x-transition>
      </router-link>
    </div>

    <!-- Navigation Items v-if="this.$can('admin-dashboard')" -->
    <v-list expand shaped class="vertical-nav-menu-items pr-5" >
      <nav-menu-link title="Accueil" :to="{ name: 'dashboard' }"  :icon="icons.mdiHomeOutline"></nav-menu-link>
    
     <nav-menu-group title="Formations"  v-if="this.$ability.can('start-formation')" :icon="icons.mdiBookOpenPageVariant">
        <nav-menu-link title="Commencer une FI" :to="{ name: 'start-fi' }" :icon="icons.mdiFileDocumentEditOutline" v-if="this.$ability.can('start-fi')" ></nav-menu-link>
        <nav-menu-link title="Commencer une FC" :to="{ name: 'start-fc' }" :icon="icons.mdiFileEdit" v-if="this.$ability.can('start-fi')"></nav-menu-link>
      </nav-menu-group>

      <nav-menu-group title="Suivi des formations " :icon="icons.mdiTableAccount" v-if="this.$ability.can('my-formations')">
        <nav-menu-link title="Mes formations" :to="{ name: 'suivi-fi-fc' }" :icon="icons.mdiClipboardTextMultipleOutline" v-if="this.$ability.can('my-formations')" ></nav-menu-link>
        <nav-menu-link title="Tableau de suivi " :to="{ name: 'suivi-fi-fc-all' }" :icon="icons.mdiDatabaseCheckOutline" v-if="this.$ability.can('all-formations')" ></nav-menu-link>
      </nav-menu-group>
  
      <nav-menu-group title=" Supports des formations " :icon="icons.mdiAirFilter" >
        <nav-menu-link title="Ajouter un Support fi/fc" :to="{ name: 'addSupportfifc' }" :icon="icons.mdiBookOpenPageVariantOutline" v-if="this.$ability.can('add-support')"></nav-menu-link>
        <nav-menu-link title="Liste des supports fi /fc " :to="{ name: 'liste-module' }" :icon="icons.mdiBookOpenPageVariantOutline" v-if="this.$ability.can('supports-liste')" ></nav-menu-link>
      </nav-menu-group>

      <nav-menu-section-title title="Reporting des formations :" v-if="this.$ability.can('reporting')"  ></nav-menu-section-title>
      <nav-menu-group title="Reporting" :icon="icons.mdiHomeAnalytics" v-if="this.$ability.can('reporting')" >
        <nav-menu-link title="Global" :to="{ name: 'globale-reporting' }" :icon="icons.mdiEarth" v-if="this.$ability.can('reporting-globale')"></nav-menu-link>
        <nav-menu-link title="Par activité" :to="{ name: 'activity-reporting' }" :icon="icons.mdiAngular" v-if="this.$ability.can('reporting-activite')"></nav-menu-link>
         <nav-menu-link title="Par service" :to="{ name: 'service-reporting' }" :icon="icons.mdiWashingMachine" v-if="this.$ability.can('reporting-service')"></nav-menu-link>
          <nav-menu-link title="Par agent" :to="{ name: 'agent-reporting' }" :icon="icons.mdiFaceAgent" v-if="this.$ability.can('reporting-agent')"></nav-menu-link>
      </nav-menu-group>
        <nav-menu-section-title title="Les agents :" v-if="this.$ability.can('agents')"></nav-menu-section-title>
       <nav-menu-group title="Agents" v-if="this.$ability.can('agents')" :icon="icons.mdiAccountMultiple">

         <nav-menu-link title="Liste des agents" :to="{ name: 'agent-list' }" v-if="this.$ability.can('notes-liste')"></nav-menu-link>
          <nav-menu-link title="Les notes des agents" :to="{ name: 'note-agent' }"  v-if="this.$ability.can('notes-liste')"></nav-menu-link>
      </nav-menu-group>
      <nav-menu-section-title title="Les utilisateurs :" v-if="this.$ability.can('users')"></nav-menu-section-title>
       <nav-menu-group title="utilisateurs" :icon="icons.mdiAccountMultiple" v-if="this.$ability.can('users')">
        <nav-menu-link title="Ajouter un utilisateur" :to="{ name: 'add-user' }" v-if="this.$ability.can('users-add')"></nav-menu-link> 
        <nav-menu-group title="Liste" >
          <nav-menu-link title="Admins"  :to="{ name: 'admin-list' }" v-if="this.$ability.can('users')" ></nav-menu-link> 
          <nav-menu-link title="Formateurs"  :to="{ name: 'formateur-list' }" v-if="this.$ability.can('users')"  ></nav-menu-link>
          <nav-menu-link title="Clients"  :to="{ name: 'client-list' }" v-if="this.$ability.can('users')"></nav-menu-link>
        </nav-menu-group>
      </nav-menu-group>
       <nav-menu-section-title title="Les activitées : " v-if="this.$ability.can('activitees-list')"></nav-menu-section-title>
       <nav-menu-group title="activitées" v-if="this.$ability.can('activitees-list')" :icon="icons.mdiAngularjs">
        <nav-menu-link title="Liste des activitées " v-if="this.$ability.can('activitees-list')" :to="{ name: 'activitees' }" ></nav-menu-link>
      </nav-menu-group>
       <!-- <nav-menu-section-title title="historique des anciennes formations :" v-if="this.$ability.can('historique-dashboard')"></nav-menu-section-title>
       <nav-menu-group title="Historique" v-if="this.$ability.can('historique-dashboard')" :icon="icons.mdiChartBar">
        <nav-menu-link title="Dashboard " v-if="this.$ability.can('historique-dashboard')" :to="{ name: 'dashboard-historique' }" ></nav-menu-link>
      </nav-menu-group> -->
      
     
    </v-list>
 


 


   
  </v-navigation-drawer>
</template>

<script>

// eslint-disable-next-line object-curly-newline
import {
  mdiHomeOutline,
  mdiAlphaTBoxOutline,
  mdiEyeOutline,
  mdiCreditCardOutline,
  mdiTable,
  mdiFileOutline,
  mdiAccountGroupOutline ,
  mdiFormSelect,
  mdiAccountCogOutline,
  mdiBookOpenPageVariant ,
  mdiTableAccount ,
  mdiChartWaterfall ,
  mdiChartAreaspline ,
  mdiChartTree ,
  mdiAccountReactivateOutline ,
  mdiAccountSupervisorCircle,
  mdiAccountMultiple ,
  mdiAngularjs ,
  mdiChartBar,
  mdiAirFilter ,
  mdiHomeAnalytics ,
  mdiBookOpenPageVariantOutline,
  mdiDatabaseCheckOutline,
  mdiClipboardTextMultipleOutline,
  mdiFileEdit,
  mdiFileDocumentEditOutline,
  mdiFileDocumentPlus,
  mdiAccountFilterOutline,
  mdiAngular,
  mdiFaceAgent,
  mdiWashingMachine,
  mdiEarth,
  mdiReceiptTextPlus,
} from '@mdi/js'
import NavMenuSectionTitle from './components/NavMenuSectionTitle.vue'
import NavMenuGroup from './components/NavMenuGroup.vue'
import NavMenuLink from './components/NavMenuLink.vue'
import { AbilityBuilder, Ability } from '@casl/ability'


export default {
  components: {
    NavMenuSectionTitle,
    NavMenuGroup,
    NavMenuLink,
  },
  data(){
  return {
    role: '',
    ability : {},
  }
  },
  mounted(){
      this.role = sessionStorage.getItem('role')
      this.ability = JSON.parse(sessionStorage.getItem('ability'))
      const { can, rules} = new AbilityBuilder(Ability);
      this.ability.forEach(el=>{
        can(el)
        })
       this.$ability.update(rules)
  },
  watch: {
    $router: {
      handler(){
      this.ability = JSON.parse(sessionStorage.getItem('ability'))
      const { can, rules} = new AbilityBuilder(Ability);
      this.ability.forEach(el=>{
        can(el)
        })
       this.$ability.update(rules)
      }
    }
  },
  props: {
    isDrawerOpen: {
      type: Boolean,
      default: null,
    },
  },
  setup() {
    return {
      icons: {
        mdiHomeOutline,
        mdiAlphaTBoxOutline,
        mdiEyeOutline,
        mdiCreditCardOutline,
        mdiTable,
        mdiFileOutline,
        mdiFormSelect,
        mdiAccountCogOutline,
        mdiBookOpenPageVariant,
        mdiTableAccount ,
        mdiAccountGroupOutline ,
        mdiChartWaterfall ,
        mdiChartAreaspline ,
        mdiChartTree ,
        mdiAccountReactivateOutline,
        mdiAccountSupervisorCircle,
        mdiAccountMultiple,
        mdiAngularjs,
        mdiChartBar,
        mdiAirFilter ,
        mdiHomeAnalytics ,
        mdiBookOpenPageVariantOutline,
        mdiDatabaseCheckOutline,
        mdiClipboardTextMultipleOutline,
        mdiFileEdit,
        mdiFileDocumentEditOutline,
        mdiFileDocumentPlus,
        mdiEarth,
        mdiAccountFilterOutline,
        mdiAngular,
        mdiFaceAgent,
        mdiWashingMachine,
        mdiReceiptTextPlus,
      },
    }
  },
}
</script>

<style lang="scss" scoped>
@import '@resources/sass/preset/mixins.scss';

.app-title {
  font-size: 1.25rem;
  font-weight: 700;
  font-stretch: normal;
  font-style: normal;
  line-height: normal;
  letter-spacing: 0.3px;
}

// ? Adjust this `translateX` value to keep logo in center when vertical nav menu is collapsed (Value depends on your logo)
.app-logo {
  transition: all 0.18s ease-in-out;
  .v-navigation-drawer--mini-variant & {
    transform: translateX(-4px);
  }
}

@include theme(app-navigation-menu) using ($material) {
  background-color: map-deep-get($material, 'background');
}

.app-navigation-menu {
  .v-list-item {
    &.vertical-nav-menu-link {
      ::v-deep .v-list-item__icon {
        .v-icon {
          transition: none !important;
        }
      }
    }
  }
}

// You can remove below style
// Upgrade Banner
.app-navigation-menu {
  .upgrade-banner {
    position: absolute;
    bottom: 13px;
    left: 50%;
    transform: translateX(-50%);
  }
}
</style>
