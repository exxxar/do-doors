import util from './utilites';


const BASE_DOCUMENTS_LINK = '/documents'

let state = {

}

const getters = {

}

const actions = {

    async loadDocumentConfig(context) {
        let link = `${BASE_DOCUMENTS_LINK}/config`
        let method = 'GET'

        let _axios = util.makeAxiosFactory(link, method)

        return _axios.then((response) => {
            let dataObject = response.data
            return Promise.resolve(dataObject);
        }).catch(err => {
            context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },

    async storeDocumentConfig(context, payload = {form: null}) {
        let link = `${BASE_DOCUMENTS_LINK}/config`

        let _axios = util.makeAxiosFactory(link, "POST", payload.form)

        return _axios.then((response) => {

            return Promise.resolve(response.data);
        }).catch(err => {

            if (err.response)
                context.commit("setErrors", err.response.data.errors || [])
            return Promise.reject(err);
        })
    },

}
const mutations = {

}

const clientsModule = {
    state,
    mutations,
    actions,
    getters
}
export default clientsModule;
