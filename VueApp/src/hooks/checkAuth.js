import Api from '@/hooks/Api.js'
export default {
    addToken(Token,ref) {
        localStorage.setItem('Token', Token)
        localStorage.setItem('ref', ref)
    },

    async checkAuth(token) {
        let ref = localStorage.getItem('ref')
        let result = await Api.get(`auth/Token/${ref}`,token)
        console.log(result);
    }
}