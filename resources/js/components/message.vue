<template>
  <div>
    <li class="list-group-item" :class="className"><slot></slot></li>
    <small class="badge float-right" :class="badgeName">{{ user }}</small>
    <small class="badge float-left" :class="badgeName">{{ time }}</small>
  </div>
</template>

<script>
export default {
  props: ["color", "user", "time"],
  computed: {
    className() {
      return "list-group-item-" + this.color;
    },
    badgeName() {
      return "badge-" + this.color;
    },
  },

  mounted() {
    console.log("Component mounted.");
  },
};
</script>
