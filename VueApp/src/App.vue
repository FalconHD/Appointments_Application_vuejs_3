<template>
  <Suspense>
    <Header />
  </Suspense>
  <main class="grey lighten-4">
    <router-view />
  </main>
  <Footer />
</template>



<script>
import Footer from "@/components/Footer.vue";
import { defineAsyncComponent } from "vue";

const Header = defineAsyncComponent(() => import("./components/Header.vue"));
import Api from "@/hooks/Api.js";
import { useStore } from "vuex";
import { onMounted } from "vue";
export default {
  components: {
    Header,
    Footer,
  },

  setup() {
    const store = useStore();
    let auth = async () => {
      if (localStorage.getItem("Token")) {
        let response = await Api.get("user/me", localStorage.getItem("Token"));
        store.state.username = response.name;
      }
    };
    onMounted(auth());
  },
};
</script>


<style >
#app {
  display: flex;
  min-height: 100vh;
  height: 100vh;
  flex-direction: column;
}

main {
  flex: 1 0 auto;
}
</style>
