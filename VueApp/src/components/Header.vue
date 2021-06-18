<template lang="">
  <nav class="pink darken-5">
    <div class=" container nav-wrapper ">
      <router-link to="/"><img :src="logo" alt=""></router-link>
      <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      <ul class="right hide-on-med-and-down">
        <li><router-link class="black-text" to="/">Home</router-link></li>
        <li><router-link class="black-text" to="/Dashboard">Dashboard</router-link></li>
        <li><router-link class="black-text" :to="{ name: 'Contact'}">Contact</router-link></li>        
        <li v-if="!user.loading" class="black-text userLogo"> <i class="material-icons yellow-text darken-1-text">account_circle</i> {{ store.state.username }}</li>
      </ul>
    </div>
  </nav>

  <ul class="sidenav" id="mobile-demo">
    <li><a href="sass.html">Sass</a></li>
    <li><a href="badges.html">Components</a></li>
    <li><a href="collapsible.html">Javascript</a></li>
    <li><a href="mobile.html">Mobile</a></li>
  </ul>

</template>
<script>
import logo from "../assets/logo.png";
import { ref, watch, onMounted } from "vue";
import { useStore } from "vuex";
import M from "materialize-css";
import Api from "@/hooks/Api.js";
export default {
  mounted() {
    M.AutoInit();
  },

  setup() {
    const store = useStore();
    const token = ref("");
    const user = ref({
      loading: true,
      data: {},
    });

    const getUserData = async () => {
      token.value = localStorage.getItem("Token");
      user.value.data = await Api.get("user/me", token.value);
      user.value.loading = false;
    };
    onMounted(getUserData());

    watch(store.state.Authed, () => {
      getUserData();
    });

    return {
      logo,
      user,
      store,
    };
  },
};
</script>
<style lang="css" scoped>
img {
  width: 10%;
}
nav ul a {
  font-size: 1.2rem;
  font-weight: 500;
}

.userLogo {
  display: flex;
  gap: 10px;
}
</style>
