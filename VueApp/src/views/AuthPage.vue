<template lang="">
<div class="container">
    <div class="row col s12">
        <div class="card Large">
            <router-link class="cardContainer" :to ="{name : 'Login'}">
                <img :src="LoginImg" alt="">
                <h6 class="center">you have account ? Login Now</h6>
            </router-link>
        </div>
        <div class="card Large ">
            <router-link class="cardContainer" :to="{ name: 'Register'}">
                <img :src="RegisterImg" alt="">
                <h6 class="center">New here ? so register</h6>
            </router-link>
        </div>
    </div>
</div>
</template>
<script>
import LoginImg from "../assets/LoginImg.svg";
import RegisterImg from "../assets/RegisterImg.svg";
export default {
  setup() {
    return {
      LoginImg,
      RegisterImg,
    };
  },
};
</script>
<style lang="css" scoped>
.card {
  height: 60vh;
  width: 100%;
}
.container {
    height: 100%;
}

.row {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 50px;
  height: 100%;
}

.card {
  padding: 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  
}
h6 {
  font-weight: 600;
  color: rgb(245, 19, 19);
  text-transform: uppercase;
}

.cardContainer {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  height: 90%;
}

.cardContainer img {
  width: 80%;
}
</style>