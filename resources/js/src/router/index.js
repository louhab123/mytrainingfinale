import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store/index.js'
import {canNavigate,getHomeRouteForLoggedInUser} from './RouterProtection.js'
Vue.use(VueRouter)

const routes = [
  {
    meta : {
      requiresAuth:true,
      resource: 'admin-dashboard'
    },
    path: '/',
    redirect: 'dashboard',
  },
  {
    meta : {
      requiresAuth:true, 
      resource: 'admin-dashboard'
    },
    path: '/dashboard',
    name: 'dashboard',
    component: () => import('@/views/dashboard/Dashboard.vue'),
  
  },
  {
    path: '/login',
    name: 'pages-login',
    component: () => import('@/views/pages/Login.vue'),
    meta: {
      layout: 'blank',
      redirectIfLoggedIn: true,
    },
  },
  {
    meta : {requiresAuth:true},
    path: '/suivi-fi-fc',
    name: 'suivi-fi-fc',
    resource: 'my-formations',
    component: () => import('@/views/formations/Suivie/Table.vue'),
  },

  {
    meta : {requiresAuth:true},
    path: '/suivi-fi-fc-all',
    name: 'suivi-fi-fc-all',
    resource: 'all-formations',
    component: () => import('@/views/formations/Suivie/Table2.vue'),
  },
  {
    meta : {
      requiresAuth:true,
      
           },
    path: '/detail-formation/:id',
    name: 'detail-formation',
    component: () => import('@/views/formations/Suivie/DetailFormation.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/start-fi',
    name: 'start-fi',
    component: () => import('@/views/formations/StartFi.vue'),
  },
  {
    meta : {requiresAuth:true,},
    path: '/quiz-details/:id',
    name: 'quiz-details',
    resource: 'quiz-details',
    component: () => import('@/views/ListeSupports/DetailsQuizSimple.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/quiz-details3/:id',
    name: 'quiz-details3',
    component: () => import('@/views/ListeSupports/ListQuizDetails.vue'),
  },
 
  {
    meta : {requiresAuth:true},
    path: '/quiz-details2/:id',
    name: 'quiz-details2',
    component: () => import('@/views/ListeSupports/DetailsFinaleQuiz.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/quiz-finale-details/:id',
    name: 'quiz-finale-details',
    component: () => import('@/views/ListeSupports/ListeFinaleQuizDetails.vue'),
  },

  {
    meta : {requiresAuth:true},
    path: '/start-fc',
    name: 'start-fc',
    component: () => import('@/views/formations/StartFc.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/getDetailsStateOfPrsence/:formation_type/:formation_id',
    name: 'getDetailsStateOfPrsence',
    component: () => import('@/views/formations/Suivie/getDetailsStateOfPrsence.vue'),
  },
  
  {
    meta : {requiresAuth:true},
    path: '/getComuleStateOfPresence/:formation_type/:formation_id',
    name: 'getComuleStateOfPresence',
    component: () => import('@/views/formations/Suivie/getComuleStateOfPresence.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/addSupportfifc',
    name: 'addSupportfifc',
    component: () => import('@/views/Support/addSupport.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/start-simple-quiz/:id/:nom/:site',
    name: 'start-simple-quiz',
    component: () => import('@/views/Support/StartSimpleQuiz.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/start-finale-quiz/:id/:nom',
    name: 'start-finale-quiz',
    component: () => import('@/views/Support/StartFinaleQuiz.vue'),

  },
  {
    meta : {requiresAuth:true},
    path: '/liste-module',
    name: 'liste-module',
    component: () => import('@/views/ListeSupports/ListeModule.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/liste-fi',
    name: 'liste-fi',
    component: () => import('@/views/ListeSupports/ListeFi.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/add-activite',
    name: 'add-activite',
    component: () => import('@/views/activitees/AddActivité.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/liste-videos',
    name: 'liste-videos',
    component: () => import('@/views/ListeSupports/ListeVideos.vue'),

  },
  {
    meta : {requiresAuth:true},
    path: '/dashboard-historique',
    name: 'dashboard-historique',
    component: () => import('@/views/Historique/HistoriqueFis.vue'),

  },

  {
    meta : {requiresAuth:true},
    path: '/liste-quizs',
    name: '',
    component: () => import('@/views/ListeSupports/Listequizs.vue'),

  },
  
  {
    meta : {requiresAuth:true},
    path: '/liste-finale-quizs',
    name: 'liste-finale-quizs',
    component: () => import('@/views/ListeSupports/ListeFinaleQuiz.vue'),

  },
  {
    meta : {requiresAuth:true},
    path: '/show-resource/:id',
    name: 'show-resource',
    component: () => import('@/views/ListeSupports/ShowResource.vue'),

  },
  {
    meta : {requiresAuth:true},
    path: '/edit-service/:id',
    name: 'edit-service',
    component: () => import('@/views/activitees/SeriviceEdit.vue'),

  },
  {
    meta : {requiresAuth:true},
    path: '/edit-resource/:id',
    name: 'edit-resource',
    component: () => import('@/views/ListeSupports/EditRessource.vue'),

  },
  
  
  {
    meta : {requiresAuth:true},
    path: '/show-resource-details/:id',
    name: 'show-resource-details',
    component: () => import('@/views/ListeSupports/ShowResourceDetails.vue'),

  },
  {
    meta : {requiresAuth:true},
    path: '/show-video/:id',
    name: 'show-video',
    component: () => import('@/views/ListeSupports/ShowVideo.vue'),

  },
  {
    meta : {requiresAuth:true},
    path: '/show-video-detail/:id',
    name: 'show-video-detail',
    component: () => import('@/views/ListeSupports/ShowVideoDetails.vue'),

  },
  {
    meta : {requiresAuth:true},
    path: '/show-video/:id',
    name: 'show-video',
    component: () => import('@/views/ListeSupports/ShowVideo.vue'),

  },
  {
    path: '/globale-reporting',
    name: 'globale-reporting',
    component: () => import('@/views/Reporting/Globale.vue'),
  },
  {
    path: '/activity-reporting',
    name: 'activity-reporting',
    component: () => import('@/views/Reporting/Activity.vue'),
  },
  {
    path: '/service-reporting',
    name: 'service-reporting',
    component: () => import('@/views/Reporting/Service.vue'),
  },
  {
    path: '/agent-reporting',
    name: 'agent-reporting',
    component: () => import('@/views/Reporting/Agent.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/add-user',
    name: 'add-user',
    component: () => import('@/views/users/addUser.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/profil',
    name: 'profil',
    component: () => import('@/views/users/Profil.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/agent-list',
    name: 'agent-list',
    component: () => import('@/views/agents/AgentsListe.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/admin-list',
    name: 'admin-list',
    component: () => import('@/views/users/AdminList.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/formateur-list',
    name: 'formateur-list',
    component: () => import('@/views/users/FormateurList.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/client-list',
    name: 'client-list',
    component: () => import('@/views/users/ClientList.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/edit-user/:id',
    name: 'edit-user',
    component: () => import('@/views/users/editUser.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/note-agent',
    name: 'note-agent',
    component: () => import('@/views/agents/NoteAgent.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/detail-response/:agent_id/:group_quiz_id',
    name: 'detail-response',
    component: () => import('@/views/agents/DetailsResponse.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/welcome-agent',
    name: 'espace-agent',
    component: () => import('@/views/UsersDashboard/Agent.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/welcome-client',
    name: 'espace-client',
    component: () => import('@/views/UsersDashboard/Client.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/welcome-formateur',
    name: 'espace-formateur',
    resource : 'formateur-dashboard',
    component: () => import('@/views/UsersDashboard/Formateur.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/activitees',
    name: 'activitees',
    component: () => import('@/views/activitees/List.vue'),
  },
  {
    meta : {requiresAuth:true},
    path: '/service/:id',
    name: 'service',
    component: () => import('@/views/activitees/ListServices.vue'),
  },
  {
    path: '*',
    redirect: 'error-404',
  },
  
  {
    meta : {requiresAuth:true},
    path: '/detail-agent/:agent_id',
    name: 'detail-agent',
    component: () => import('@/views/agents/FormationAgents.vue'),
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
})





router.beforeEach((to,from,next)=>{
  const isLoggedIn = store.state.user.token 
  const role = sessionStorage.getItem('role')
  const ability = JSON.parse(sessionStorage.getItem('ability'))
  if(to.meta.requiresAuth &&  !isLoggedIn  ){
      next({name:'pages-login'});
  }
  if(isLoggedIn && role && ability  && to.meta.resource){
    if(!ability.includes(to.meta.resource)) 
  {
    if (role === 'admin') return next({ name: 'dashboard' });
    if (role === 'agent') return next({ name: 'espace-agent' });
    if (role === 'client') return next({name: 'espace-client' });
    if (role === 'formateur') return next({name: 'espace-formateur'});
  
  }
  else {
    next();
  }

  }

  else {
    
      next();
  }

  
})




export default router
