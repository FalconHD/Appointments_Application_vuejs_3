<template>
  <div class="row">
    <div class="container">
      <div class="part part1 col s6">
        <div>
          <h2 class="">
            Welcome to <span class="pink-text darken-5">Quick.Rd</span><br />
          </h2>
          <p>Best Appointment System for Your business</p>
        </div>
        <router-link :to="{ name: 'Auth' }"
          ><a class="waves-effect waves-light btn-large pink darken-5"
            ><i class="material-icons left">check</i>GET STARTED</a
          >
        </router-link>
      </div>
      <div class="part part2 col s6">
        <img :src="img1" alt="" />
      </div>
    </div>
  </div>
</template>

<script>
import img1 from "../assets/med1.svg";
export default {
  name: "Home",

  setup() {
    return {
      img1,
    };
  },
};
</script>


<style lang="css" scoped>
img {
  width: 100%;
}
.container {
  height: 100%;
}
.part {
  height: 100%;
  display: flex;
  justify-content: center;
  flex-direction: column;
  gap: 30px;
}

.part2 {
  align-items: flex-end;
}
.row {
  height: 100%;
}

h2 {
  margin: 0;
}
/* h2 span {
  color: #e676ca;
  font-weight: 600;
} */
h5 {
  color: #424242;
}
p {
  font-size: 1.3rem;
}
</style>
