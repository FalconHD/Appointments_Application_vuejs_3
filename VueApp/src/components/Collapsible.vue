<template>
  <li v-if="data">
    <div class="collapsible-header">
      <div>
        <i class="material-icons true">check_box</i>
        {{ copDate.join(" ") }}
      </div>
      <div>Appointment Number {{ data.time }} in This Day</div>
      <div>
        <router-link :to="{ name: 'Update', params: { id: data.id }}">
          <i
            @click="deleteItem(data.reference)"
            class="material-icons yellow-text accent-2-text"
            >sync</i
          >
        </router-link>
        <router-link :to="{ name: 'Delete', params: { id: data.id }}">
          <i class="material-icons deep-orange-text accent-4-text">delete</i>
        </router-link>
      </div>
    </div>
    <div class="collapsible-body">
      <div class="bodyCaintainer">
        <span>{{ dayTimes[data.time - 1].from }}</span
        ><span> to </span>
        <span>{{ dayTimes[data.time - 1].to }}</span>
      </div>
    </div>
  </li>
  <li v-else>
    <h4>no appointments created yet ...</h4>
  </li>
</template>
<script>
import { ref } from "vue";
export default {
  props: {
    data: Object,
  },

  setup(props) {
    let dayTimes = [
      {
        from: "08:00",
        to: "09:45",
      },
      {
        from: "10:00",
        to: "11:45",
      },
      {
        from: "14:00",
        to: "15:45",
      },
      {
        from: "16:00",
        to: "17:45",
      },
    ];
    const copDate = ref("");

    const deleteItem = (item) => {
      console.log(item);
    };
    copDate.value = new Date(props.data.day).toString().split(" ").slice(0, 4);
    return {
      copDate,
      dayTimes,
      deleteItem,
    };
  },
};
</script>
<style lang="css" scoped>
.container {
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.bodyCaintainer {
  display: flex;
  justify-content: space-evenly;
}
.times {
  width: 100%;
}
.collapsible {
  padding: 0 30px;
}
.collapsible-header {
  display: flex;
  justify-content: space-between;
}

.false {
  color: red;
}

.true {
  color: green;
}
</style>