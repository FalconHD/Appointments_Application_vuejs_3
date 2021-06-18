<template lang="">
    <div>
        
    </div>
</template>
<script>
import { ref, onMounted, watch } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
import Api from "../../hooks/Api.js";
export default {
  setup() {
    const isAuthed = ref({});
    const router = useRouter();
    const store = useStore();

    let auth = async () => {
      if (localStorage.getItem("Token")) {
        isAuthed.value = await Api.get(
          `auth/token/${localStorage.getItem("ref")}`,
          localStorage.getItem("Token")
        );

        let response = await Api.get("user/me", localStorage.getItem("Token"));
        store.state.username = response.name;
      } else {
        router.push("/Auth");
      }

      // console.log(isAuthed.value.newToken);
    };
    onMounted(auth()),
      watch(isAuthed, () => {
        if (isAuthed.value.newToken) {
          console.log(isAuthed.value.newToken);
          localStorage.setItem("Token", isAuthed.value.newToken);
          localStorage.setItem("ref", isAuthed.value.User.reference);
        } else if (isAuthed.value.error) {
          localStorage.removeItem("token");
          localStorage.removeItem("token");
          router.push("/Auth");
        }
      });
    return {
      isAuthed,
    };
  },
};
</script>
<style lang="">
</style>