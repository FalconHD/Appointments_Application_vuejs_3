<template lang="">
    <div class="addContainer">
        <div class="container center">
        <div>
            <label class="black-text dayInput" for="">Enter The Day : </label><br>
            <input v-model.lazy="day" type="text" class="datepicker inputDate" placeholder="day">
        </div>
        <ul v-if="times.loading.value" class="collection">
            <li class="collection-item " v-for="(time,index) in times.data" :key="time" :class="{full : time.full,not:!time.full }" @click="updateApp(!time.full,index+1,time)">
                <span >
                    {{time.from}}  
                </span>
                 <i class="material-icons">keyboard_arrow_right</i>
                <span>
                    {{time.to}}
                </span>
            </li>
            
        </ul>
        <ul v-else-if="day && !times.loading.value" class="collection">
              <li class="collection-item " v-for="(time,index) in times.data" :key="time" :class="{full : time.full,not:!time.full }" @click="updateApp(!time.full,index+1,time)">
                <span >
                    {{time.from}}  
                </span>
                 <i class="material-icons">keyboard_arrow_right</i>
                <span>
                    {{time.to}}
                </span>
            </li>
        </ul>
        <h3 v-else>
             Waiting for The Day 
        </h3>
    </div>
    </div>
</template>
<script>
import { ref, watch } from "vue";
import { useRouter } from "vue-router";
import Api from "@/hooks/Api.js";
import M from "materialize-css";
export default {
  mounted() {
    M.AutoInit();
  },

  setup() {
    const router = useRouter();
    const fetchedData = ref([]);
    const day = ref();
    let times = ref({
      loading: false,
      data: [
        {
          from: "08:00",
          to: "09:45",
          full: false,
          id: 0,
        },
        {
          from: "10:00",
          to: "11:45",
          full: false,
          id: 0,
        },
        {
          from: "14:00",
          to: "15:45",
          full: false,
          id: 0,
        },
        {
          from: "16:00",
          to: "17:45",
          full: false,
          id: 0,
        },
      ],
    });

    const updateApp = async (conditon, index) => {
      if (conditon) {
        let data = {
          user: localStorage.getItem("ref"),
          time: index,
          day: new Intl.DateTimeFormat("en-UK").format(new Date(day.value)),
        };
        data.day = data.day.split("/").reverse().join("-");
        await Api.post(`reservation/Add`, data, localStorage.getItem("Token"));
        router.push("/Dashboard");
      }
    };
    const fetchData = async (data) => {
      fetchedData.value = await Api.post(
        "reservation/find",
        data,
        localStorage.getItem("Token")
      );
      fetchedData.value.map((item) => {
        times.value.data[item.time - 1].full = true;
      });
      if (fetchedData.value.length > 0) {
        times.value.loading = true;
      } else if (fetchedData.value.length == 0) {
        times.value.data.map((item) => {
          item.full = false;
        });
        times.value.loading = false;
      }
      times.value.loading = false;
    };

    watch(day, () => {
      console.log(new Date(day.value));
      let data = {
        day: new Intl.DateTimeFormat("en-UK").format(new Date(day.value)),
      };
      data.day = data.day.split("/").reverse().join("-");
      console.log(data.day);
      try {
        fetchData(data);
      } catch (error) {
        times.value.loading.value = false;
        console.log(error);
      }
    });

    return {
      day,
      times,
      updateApp,
    };
  },
};
</script>
<style lang="css" scoped>
.inputDate {
  width: auto !important;
}

.inputDate::placeholder {
  color: black;
  font-size: 0.9rem;
}

.collection {
  display: flex;
  width: 100%;
  justify-content: center;
  align-items: center;
  height: 40%;
}
.collection .collection-item {
  display: flex;
  justify-content: center;
  align-items: center;
  justify-content: space-evenly;
  width: 100%;
  height: 100%;
  border-left: 3px solid #000;
  transition: all 0.2s ease;
}
.collection .collection-item:hover {
  border-left: 13px solid #000;
}
.addContainer {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 50%;
}
.addContainer div {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100%;
}

.dayInput {
  font-size: 1.2rem;
  margin-right: 2rem;
}

.full {
  background-color: rgba(255, 0, 0, 0.473);
}
.not {
  background-color: rgba(72, 255, 0, 0.473);
  cursor: pointer;
}
</style>