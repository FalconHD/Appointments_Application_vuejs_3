<template lang="">
   <div class="container center">
        <div class="row ">
            <div class="col s12">
            <div class="card white darken-1">
            <div class="card-content white-text">
            <span class="card-title red">Cancle Appointment</span>
            <p class="black-text">Are you Sure You Want To Cancle This Appointment</p>
            </div>
            <div class="card-action ">
                <router-link to="/Dashboard">
                    <button class="btn waves-effect waves-light">No Go Back
                        <i class="material-icons right">keyboard_backspace</i>
                    </button>
                </router-link>
                <button @click='Delete(id)' class="btn waves-effect waves-light accepte red white-text">Cancle Now
                    <i class="material-icons right">delete_forever</i>
                </button>
            </div>
        </div>
    </div>
  </div>
   </div>
</template>
<script>
import { useRoute,useRouter } from "vue-router";
import Api from "@/hooks/Api.js";
import {} from "vue";
export default {
  setup() {
    const {
      params: { id },
    } = useRoute();
     const router = useRouter();
    const Delete = async (id) => {
        const response = await Api.get(`reservation/delete/${id}`,localStorage.getItem("Token"))
        console.log(response);
        router.push('/Dashboard')
    };
    return {
      id,
      Delete,
    };
  },
};
</script>
<style lang="css" scoped>
.accepte {
  color: #ffab40;
}

</style>