<template lang="">
<div class="container">
  <div class="card large ">
  <div class="center row col s12">
    <h1  class="col s12">REGISTER</h1>
    <form @submit.prevent='register()' class="col s12">
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">account_circle</i>
          <input v-model="regData.name" id="icon_prefix" type="text" class="validate">
          <label for="icon_prefix">First Name</label>
        </div>
        <div class="input-field col s6">
          <i class="material-icons prefix">credit_card</i>
          <input v-model="regData.cin" id="icon_cin" type="text">
          <label for="icon_cin">CIN</label>
        </div>
        <div class="input-field col s6">
          <i class="material-icons prefix">phone</i>
          <input v-model="regData.phone" id="icon_telephone" type="text" class="validate">
          <label for="icon_telephone">Telephone</label>
        </div>
        <div class="input-field col s6">
          <i class="material-icons prefix">email</i>
          <input v-model="regData.email" id="email" type="email" class="validate">
          <label for="email">Email</label>
          <span class="helper-text" data-error="Email form wrong" data-success="right"></span>
        </div>
        
        <div class="input-field col s6">
          <i class="material-icons prefix">password</i>
          <input v-model="regData.password" id="icon_password" type="password" class="validate">
          <label for="icon_password">Password</label>
        </div>
      </div>
      <button  class="btn waves-effect waves-light pink darken-5" type="submit" name="action">REGISTER
        <i class="material-icons right">send</i>
      </button>
    </form>
    </div>
  </div>
    </div>
</template>
<script>
import { ref } from "vue";
import { useRouter } from "vue-router";
import Api from "../../hooks/Api.js";
import Auth from "../../hooks/checkAuth.js";

export default {
  setup() {
    const router = useRouter()
    const regData = ref({
      name: "",
      email: "",
      password: "",
      cin: "",
      phone: "",
    });
    const register = async () => {
      const response = await Api.post("auth/register", regData.value);
      if(response.error){
        console.log(response.error);
        router.push("/Auth")
      }else{
        console.log(response);
        Auth.addToken(response.Token,response.User)
        router.push("/")
      }
    };
    return {
      register,
      regData,
    };
  },
};
</script>
<style lang="css" scoped>
.card {
  padding: 20px;
}

.container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
}

/* label color */
.input-field label {
  color: #000;
}
/* label focus color */
.input-field input[type="text"]:focus + label,
.input-field input[type="password"]:focus + label,
.input-field input[type="email"]:focus + label {
  color: #e91e63;
}
/* label underline focus color */
.input-field input[type="text"]:focus,
.input-field input[type="email"]:focus,
.input-field input[type="password"]:focus {
  border-bottom: 1px solid #e91e63;
  box-shadow: 0 1px 0 0 #e91e63;
}
/* valid color */
.input-field input[type="text"].valid,
.input-field input[type="email"].valid,
.input-field input[type="password"].valid {
  border-bottom: 1px solid #e91e63;
  box-shadow: 0 1px 0 0 #e91e63;
}
/* invalid color */
.input-field input[type="text"].invalid {
  border-bottom: 1px solid rgb(223, 0, 0);
  box-shadow: 0 1px 0 0 rgb(240, 0, 0);
}
/* icon prefix focus color */
.input-field .prefix.active {
  color: #e91e63;
}
</style>