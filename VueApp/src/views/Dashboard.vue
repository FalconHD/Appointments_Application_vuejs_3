<template>
  <Authorized />
  <div class="container center">
    <h3 v-if="!items.error">My Space</h3>
    <div class="container">
      <ul v-if="!items.error" class="collapsible times">
        <Col v-for="item in items" :key="item" :data="item" />
      </ul>
      <div v-else class="times centerContainer">
        <h4>You Have no Appointments yet 🕶</h4>
      </div>
    </div>
    <router-link to="/Add">
      <button class="btn waves-effect waves-light">
        ADD
        <i class="material-icons right">add</i>
      </button>
    </router-link>
  </div>
</template>

<script>
import Authorized from "@/components/Auth/Authorized.vue";
import Col from "@/components/Collapsible.vue";
import Api from "@/hooks/Api.js";
import { ref, onMounted } from "vue";
import M from "materialize-css";

export default {
  mounted() {
    M.AutoInit();
  },

  components: {
    Authorized,
    Col,
  },

  setup() {
    const items = ref([]);
    const token = ref(localStorage.getItem("Token"));
    const getData = async () => {
      items.value = await Api.get("/reservation/all", token.value);
    };

    onMounted(getData());
    return {
      items,
    };
  },
};
</script>


<style lang="css" scoped>
.centerContainer {
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>