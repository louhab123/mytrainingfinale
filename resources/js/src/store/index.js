import Vue from 'vue'
import Vuex from 'vuex'
import axiosClient from '../axios'
Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    user: {
      data: {
        name: '',
        email: ''
          },
      token : sessionStorage.getItem('TOKEN'),
  },
  agent : [],
  activities: [],
  services: []
  },
  mutations: {
    setUser : (state,userData)=>{
      state.user.token = userData.access_token.plainTextToken
      state.user.data.name = userData.user.name
      state.user.data.email = userData.user.email
      sessionStorage.setItem('TOKEN',state.user.token)
      sessionStorage.setItem('user',userData.user.name)
      sessionStorage.setItem('role',userData.user.role)
      sessionStorage.setItem('userId',userData.user.id)
      sessionStorage.setItem('ability', JSON.stringify(userData.ability))
      
    
  },
  setAgents : (state,data)=>{
     state.agents = data
  },
  setActivities: (state,data) =>{
    state.activities = data
  },
  setServices: (state,data)=>{
      state.services = data
  },
  logout: (state) =>{
    state.user.data = {};
    state.user.token = null;
  
},
  },
  actions: {
    sendDataAgent({commit}, response){
      return  axiosClient.post('/note/sendDataAgent',response)
      .then(response=>{
        return response;
      })
    },
    startFormationFiPost({commit},detail){
 
      return axiosClient.post('/formation/startFormationFiPost',detail)
      .then(response=>{
        return response
      })
    },
    getServices({commit}){
      return axiosClient.get('/getServices')
      .then(({data})=>{
          commit('setServices',data)
          return data;
      })
    },
    logout({commit}){
      return axiosClient.get('/logout')
      .then(response=>{
          commit('logout')
          return response
      })
  },
    login({commit},user){
       return axiosClient.post('/login',user)
      .then(({data})=>{
        if(data.message!=='incorrect') {
          commit('setUser',data)
          return data;
        }
        else {
          return data;
        }
 
      })
  },
  getAgents({commit}){
    return axiosClient.get('/getAgents')
   .then(({data})=>{
       commit('setAgents',data)
       return data;
   })

},
getActivities({commit}){
  return axiosClient.get('/getActivities')
 .then(({data})=>{
     commit('setActivities',data)
     return data;
 })

},
addNewAgent({commit},agents){
  return axiosClient.post('agent/add',agents)
  .then(response=>{
    return response;
  })
},
selectedAgent({commit},agents) {
  return axiosClient.post('agent/selectedAgent',agents)
  .then(response=>{
    return response;
  })
},
startFormationFCPost({commit},detail){
  return axiosClient.post('/formation/startFormationFCPost',detail)
  .then(response=>{
    return response
  })
},
getFormations({commit}){
  return axiosClient.get('/formation/getFormations')
  .then(response=>{
      return response;
  })
},
getFormationsDetail({commit},id){
  return axiosClient.get(`/formation/getFormationsDetail/${id}`)
  .then(response=>{
      return response;
  })
},
statofpresence({commit},details){
  return axiosClient.post('/state/statofpresence',details)
  .then(response=>{
      return response;
  })
},
 getFormateurs({commit}){
     return axiosClient.get('/users/getFormateurs')
     .then((response)=>{
       return response;
     })
   },
   getClients({commit}){
    return axiosClient.get('/users/getClients')
    .then((response)=>{
      return response;
    })
  },
  getadmins({commit}){
    return axiosClient.get('/users/getadmins')
    .then((response)=>{
      return response;
    })
  },
getDetailsStateOfPrsence({commit},details){
  return axiosClient.get(`/state/getDetailsStateOfPrsence/${details.formation_type}/${details.formation_id}`)
  .then(response=>{
    return response
  })

},
getComuleStateOfPresence({commit}, details) {
 return axiosClient.get(`/state/getComuleStateOfPresence/${details.formation_type}/${details.formation_id}`)
  .then(response=>{
    return response
  })
},
addResource({commit}, formData){
  return axiosClient.post('/formation/addResource', formData)
  .then(response=>{
    return response;
})
},
addVideo({commit},formData){
  return axiosClient.post('/formation/addVideo', formData)
  .then(response=>{
    return response;
})
},
addSimpleQuiz({commit},addSimpleQuiz ){
  return axiosClient.post('/quiz/addSimpleQuiz', addSimpleQuiz )
  .then(response=>{
    console.log(response.data)
    return response;
})
},
addFinaleQuiz({commit},addFinaleQuiz) {
  return axiosClient.post('/quiz/addFinaleQuiz', addFinaleQuiz)
.then(response=>{
  return response;
})
},
getfis({commit}){
  return axiosClient.get('/resource/all')
  .then(response=>{
      return response;
  })
},
geteResource({commit},id){
  return  axiosClient.get(`/resource/geteResource/${id}`)
},
geteResource2({commit},id){
  return  axiosClient.get(`/resource/geteResource2/${id}`)
},
getVideos({commit}){
  return axiosClient.get('/videos/all')
  .then(response=>{
      return response;
  })
},
ShowVdeo({commit},id){
  return  axiosClient.get(`/videos/ShowVdeo/${id}`)
  .then(response=>{
    return response;
})
},
ShowVdeo2({commit},id){
  return  axiosClient.get(`/videos/ShowVdeo2/${id}`)
  .then(response=>{
    return response;
})
},
quizs({commit}){
  return  axiosClient.get('/quiz/all')
  .then(response=>{
    return response;
})
},
quizs2({commit}){
  return  axiosClient.get(`/quiz/all2`)
  .then(response=>{
    return response;
})
},
quizs3({commit},id){
  return  axiosClient.get(`/quiz/all3/${id}`)
  .then(response=>{
    return response;
})
},
quizs4({commit},id){
  return  axiosClient.get(`/quiz/all4/${id}`)
  .then(response=>{
    return response;
})
},
getQuizDetails({commit},id){
  return  axiosClient.get(`/quiz/${id}`)
  .then(response=>{
    return response;
})
},
getQuizDetails2({commit},id){
  return  axiosClient.get(`/quiz/finale/${id}`)
  .then(response=>{
    return response;
})
},
getGlobaleReporting({commit}, data){
  return  axiosClient.post('/reporting/getGlobaleReporting',data)
  .then(response=>{
    return response;
  })
},

getFormationsgetAll({commit}){
  return  axiosClient.get('/formation/getFormationsgetAll')
  .then(response=>{
    return response;
  })
},
addAgent({commit},agent){
  return  axiosClient.post('agent/add2',agent)
  .then(response=>{
    return response;
  })
},
addSimpleQuizInstructions({commit},addSimpleQuizInstructions){
    return  axiosClient.post('quiz/addSimpleQuizInstructions',addSimpleQuizInstructions)
  .then(response=>{
    return response;
  })
},
addFinaleQuizInstruction({commit},addSimpleQuizInstructions){
  return  axiosClient.post('quiz/addFinaleQuizInstruction',addSimpleQuizInstructions)
  .then(response=>{
    return response;
  })
},
sendDataAgentSimpleQuiz(){
  return  axiosClient.post('/note/sendDataAgentSimpleQuiz',response)
  .then(response=>{
    return response;
  })
},
deleteQuizSimple({commit},id){
  return  axiosClient.post('/quiz/deleteQuizSimple',id)
  .then(response=>{
    return response;
  })
},
getAgentNotes({commit}){
  return  axiosClient.get('/note/getAgentNotes')
  .then(response=>{
    return response;
  })
},
getResponseAgentDetail({commit},detail){
  return  axiosClient.post('/note/getResponseAgentDetail',detail)
  .then(response=>{
    return response;
  })
},
getcountVagues({commit}){
  return  axiosClient.get('/formation/count/vagues')
  .then(response=>{
    return response;
  })
},
getEffictif({commit}){
  return  axiosClient.get('/formation/count/effitive')
  .then(response=>{
    return response;
  })
},
getcountfc({commit}){
  return  axiosClient.get('/formation/count/fc')
  .then(response=>{
    return response;
  })
},
getcountfi({commit}){
  return  axiosClient.get('/formation/count/fi')
  .then(response=>{
    return response;
  })
},
getcounAgents({commit}){
  return  axiosClient.get('/agent/count')
  .then(response=>{
    return response;
  })
},
getCountQuizs({commi}){
  return  axiosClient.get('/quiz/count')
  .then(response=>{
    return response;
  })
},
getFormationsByservice({commit}){
  return  axiosClient.get('/reporting/byService')
  .then(response=>{
    return response;
  })
},
getFormationsByActviteAnsService({commit}){
  return axiosClient.get('/reporting/getFormationsByActviteAnsService')
  .then(response=>{
    return response;
  })
},
getFormationsByActviteAnsService2({commit}){
  return axiosClient.get('/reporting/getFormationsByActviteAnsService2')
  .then(response=>{
    return response;
  })
},
getQuizSimpleByActvite({commit}){
  return axiosClient.get('/reporting/getQuizSimpleByActvite')
  .then(response=>{
    return response;
  })
},
getReportingActvity({commit},data){
  return axiosClient.post('/reporting/getReportingActvity',data)
  .then(response=>{
    return response;
  })
},
getReportingbySerice({commit}, data){
  return axiosClient.post('/reporting/getReportingbySerice',data)
  .then(response=>{
    return response;
  })
},
getAgents2({commit}){
     return axiosClient.get('agent/all')
     .then(response=>{
      return response;
     })
},
getReportingbyAgent({commit},data){
  return axiosClient.post('/reporting/getReportingbyAgent',data)
  .then(response=>{
    return response;
  })
},
getVagues({commit}){
  return axiosClient.get('/vagues/all')
  .then(response=>{
    return response
  })
},
AddNewUser({commit},User){
  return axiosClient.post('/users/add',User)
  .then(response=>{
    return response
  })
},
getCurrentUser({commit}){
  return axiosClient.get('/users/show')
},
updateUser({commit},User){
  return axiosClient.post('/users/edit',User)
  .then(response=>{
    return response
  })
},
getServices2({commit},id){
  return axiosClient.get(`/services/show2/${id}`)
  .then(response=>{
    return response
  })
},
getServices3({commit},id){
  return axiosClient.get(`/services/show3/${id}`)
  .then(response=>{
    return response
  })
},
editService({commit}, data) {
  return axiosClient.post('/services/editName', data)
  .then((response)=>{
    return response
  })
},
getformationByactiviteDashboeardAdmin({commit}){
  return axiosClient.get('dashboard/getformationByactiviteDashboeardAdmin')
  .then(response=>{
    return response
  })

},
effectiveByWeeek({commit}){
return axiosClient.get('vagues/effectiveByWeeek')
.then((response)=>{
  return response
})
},
deleteResource({commit},id){
  return axiosClient.get(`/resource/delete/${id}`)
  .then((response)=>{
    return response
  })
},
handlActivite({commit},data){
  return axiosClient.post('activities/edit',data)
  .then((response)=>{
    return response
  })
},
getMyFormations({commit},data){
  return axiosClient.post('/formation/getMyFormations',data)
  .then((response)=>{
    return response
  })
},
getmyformationsAll(){
  return axiosClient.get('/formation/getmyformationsAll')
  .then((response)=>{
    return response
  })
},
addActivite({commit},nom){
  return axiosClient.post('/activities/add',nom)
  .then((response)=>{
    return response
  })
},
addService({commit},data){
  return axiosClient.post('/services/add',data)
  .then((response)=>{
    return response
  })
},
deleteMyformation({commit},vague){
  return axiosClient.post('/formation/deleteMyformation',vague)
  .then((response)=>{
    return response
  })
},
getAncienFis({commit}){
   return axiosClient.get('historique/getAncienFis')
   .then((response)=>{
     return response
   })
},
changeActivitieImage({commit}, formData){
  return axiosClient.post('activities/changeActivitieImage',formData)
  .then((response)=>{
    return response
  })
},
getAgentNotesFilter({commit},details){
  return axiosClient.post('/note/getAgentNotesFilter',details)
  .then((response)=>{
    return response
  })
},
deleteNoteAgent({commit},id){
  return axiosClient.get(`/note/delete/${id}`)
  .then((response)=>{
    return response
  })
},
sendMessage({commit},data){
  return axiosClient.post('/messages/send',data)
  .then((response)=>{
    return response
  })
},
getAllMessages({commit}){
  return axiosClient.get('/messages/getMyMessages')
  .then((response)=>{
    return response
  })
},
answerToAgentMessage({commit},data){
  return axiosClient.post('/messages/answerToAgentMessage',data)
  .then((response)=>{
    return response
  })
},
getAgentdetails({commit},agent_id){
   return axiosClient.get(`/agent/getAgentdetails/${agent_id}`)
},
ExtractNotes({commit}) {

  return axiosClient.get('/agent/notes/extraire',
  {
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    },
    responseType: 'blob',
  }
  )
  .then((response)=>{
    return response
  })
},
handlService({commit}, data) {
  return axiosClient.post('services/edit', data)
  .then((response)=>{
    return response
  })
},
getModule({commit}, id) {
  return axiosClient.get(`/resource/2/${id}`)
  .then(response=>{
    return response 
  })
},
editResources({commit}, data){
  return axiosClient.post('resource/edit', data)
  .then(response=>{
    return response
  })
}
  },
 

  
 
  modules: {},
})
