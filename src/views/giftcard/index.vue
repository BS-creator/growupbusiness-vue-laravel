<template>
  <div class="app-container">
    <h1>{{hello}}</h1>
    <router-link to="/giftcreator">
      <el-button :loading="loading" type="primary" class="login-btn" size="large">
        <div>
          <i class="el-icon-plus"></i>
          <span>Add New GiftCard</span>
        </div>
      </el-button>
    </router-link>
  </div>
</template>

<script>
export default {
  name: "GiftCard",
  components: {},
  directives: {},
  filters: {},
  data() {
    return {
      hello: "Gift Card Creator",
      loading: false
    };
  },
  created() {
    // this.getList();
  },
  methods: {}
};
</script>

<style>
</style>
