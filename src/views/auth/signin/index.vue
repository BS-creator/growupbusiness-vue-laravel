<template>
  <div class="login-container">
    <el-form
      ref="loginForm"
      :model="loginForm"
      :rules="loginRules"
      class="login-form"
      autocomplete="on"
      label-position="left"
    >
      <div class="title-container">
        <h3 class="title">SignIn Form</h3>
      </div>

      <el-form-item prop="email">
        <span class="svg-container">
          <svg-icon icon-class="user" />
        </span>
        <el-input
          ref="email"
          v-model="loginForm.email"
          placeholder="Username"
          name="email"
          type="text"
          tabindex="1"
          autocomplete="on"
        />
      </el-form-item>

      <el-tooltip v-model="capsTooltip" content="Caps lock is On" placement="right" manual>
        <el-form-item prop="password">
          <span class="svg-container">
            <svg-icon icon-class="password" />
          </span>
          <el-input
            :key="passwordType"
            ref="password"
            v-model="loginForm.password"
            :type="passwordType"
            placeholder="Password"
            name="password"
            tabindex="2"
            autocomplete="on"
            @keyup.native="checkCapslock"
            @blur="capsTooltip = false"
            @keyup.enter.native="handleLogin"
          />
          <span class="show-pwd" @click="showPwd">
            <svg-icon :icon-class="passwordType === 'password' ? 'eye' : 'eye-open'" />
          </span>
        </el-form-item>
      </el-tooltip>

      <el-button
        :loading="loading"
        type="primary"
        class="login-btn"
        size="large"
        style="width:100%;margin-bottom:30px;"
        @click.native.prevent="handleLogin"
      >
        <div>
          <i class="fa fa-sign-in"></i>
          <span>Sign In</span>
        </div>
      </el-button>

      <div style="position:relative">
        <div class="tips">
          <span>Or SignIn with</span>
        </div>
        <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
          <el-button
            @click="AuthProvider('instagram')"
            size="large"
            type="info"
            class="social-media-btn"
          >
            <div>
              <i class="fa fa-instagram"></i>
              <span>Instagram</span>
            </div>
          </el-button>
          <el-button
            @click="AuthProvider('facebook')"
            size="large"
            type="primary"
            class="social-media-btn"
          >
            <div>
              <i class="fa fa-facebook"></i>
              <span>Facebook</span>
            </div>
          </el-button>
          <el-button
            @click="AuthProvider('google')"
            size="large"
            type="danger"
            class="social-media-btn"
          >
            <div>
              <i class="fa fa-google"></i>
              <span>Google</span>
            </div>
          </el-button>
        </div>
      </div>

      <div style="position:relative">
        <div class="tips">
          <span>No registered yet?</span>
        </div>
        <div>
          <router-link to="/signup">
            <el-button size="large" type="success" class="social-media-btn">
              <div>
                <i class="fa fa-sign-up"></i>
                <span>Sign Up</span>
              </div>
            </el-button>
          </router-link>
        </div>
      </div>
    </el-form>
  </div>
</template>

<script>
import { validUsername, validEmail } from "@/utils/validate";
import SocialSign from "./components/SocialSignin";

export default {
  name: "Login",
  components: { SocialSign },
  data() {
    const validateUserEmail = (rule, value, callback) => {
      if (!validEmail(value)) {
        callback(new Error("Please enter the valid Email"));
      } else {
        callback();
      }
    };
    const validatePassword = (rule, value, callback) => {
      if (value.length < 6) {
        callback(new Error("The password can not be less than 6 digits"));
      } else {
        callback();
      }
    };
    return {
      loginForm: {
        email: "admin@admin.com",
        password: "111111"
      },
      loginRules: {
        email: [
          { required: true, trigger: "blur", validator: validateUserEmail }
        ],
        password: [
          { required: true, trigger: "blur", validator: validatePassword }
        ]
      },
      passwordType: "password",
      capsTooltip: false,
      loading: false,
      showDialog: false,
      redirect: undefined,
      otherQuery: {}
    };
  },
  watch: {
    $route: {
      handler: function(route) {
        const query = route.query;
        if (query) {
          this.redirect = query.redirect;
          this.otherQuery = this.getOtherQuery(query);
        }
      },
      immediate: true
    }
  },
  created() {
    // console.log(this.$ServerURL);
  },
  mounted() {
    if (this.loginForm.email === "") {
      this.$refs.email.focus();
    } else if (this.loginForm.password === "") {
      this.$refs.password.focus();
    }
  },
  destroyed() {
    // window.removeEventListener('storage', this.afterQRScan)
  },
  methods: {
    testApi() {
      this.$http
        .post(this.$ServerURL + "test/")
        .then(response => {
          console.log(response.data);
        })
        .catch(err => {
          console.log({ err: err });
        });
    },
    checkCapslock(e) {
      const { key } = e;
      this.capsTooltip = key && key.length === 1 && key >= "A" && key <= "Z";
    },
    showPwd() {
      if (this.passwordType === "password") {
        this.passwordType = "";
      } else {
        this.passwordType = "password";
      }
      this.$nextTick(() => {
        this.$refs.password.focus();
      });
    },
    handleLogin() {
      this.$refs.loginForm.validate(valid => {
        if (valid) {
          this.loading = true;
          this.$store
            .dispatch("user/login", this.loginForm)
            .then(() => {
              this.$router.push({
                path: this.redirect || "/",
                query: this.otherQuery
              });
              this.loading = false;
            })
            .catch(() => {
              this.loading = false;
            });
        } else {
          console.log("error submit!!");
          return false;
        }
      });
    },
    getOtherQuery(query) {
      return Object.keys(query).reduce((acc, cur) => {
        if (cur !== "redirect") {
          acc[cur] = query[cur];
        }
        return acc;
      }, {});
    },
    AuthProvider(provider) {
      var self = this;

      this.$auth
        .authenticate(provider)
        .then(response => {
          console.log(response);
          self.SocialLogin(provider, response);
        })
        .catch(err => {
          console.log({ err: err });
        });
    },
    SocialLogin(provider, response) {
      this.$store
        .dispatch("user/socialSignin", { provider, response })
        .then(() => {
          this.$router.push({
            path: this.redirect || "/",
            query: this.otherQuery
          });
        })
        .catch(() => {
          console.log("social signin failed");
        });
    }
  }
};
</script>

<style lang="scss">
/* Detail see https://github.com/PanJiaChen/vue-element-admin/pull/927 */

$bg: #283443;
$light_gray: #fff;
$cursor: #fff;

@supports (-webkit-mask: none) and (not (cater-color: $cursor)) {
  .login-container .el-input input {
    color: $cursor;
  }
}

/* reset element-ui css */
.login-container {
  .el-icon-loading {
    position: relative;
    top: 8px;
    font-size: 27px;
  }
  .social-media-btn {
    // width: 100%;
    margin-bottom: 30px;
    margin-left: 0;
  }
  .social-media-btn div,
  .login-btn div {
    width: 100px;
    margin: auto;
  }
  .social-media-btn div i,
  .login-btn i {
    float: left;
  }
  .el-input {
    display: inline-block;
    height: 47px;
    width: 85%;

    input {
      background: transparent;
      border: 0px;
      -webkit-appearance: none;
      border-radius: 0px;
      padding: 12px 5px 12px 15px;
      color: $light_gray;
      height: 47px;
      caret-color: $cursor;

      &:-webkit-autofill {
        box-shadow: 0 0 0px 1000px $bg inset !important;
        -webkit-text-fill-color: $cursor !important;
      }
    }
  }

  .el-form-item {
    border: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    color: #454545;
  }
}
</style>

<style lang="scss" scoped>
$bg: #2d3a4b;
$dark_gray: #889aa4;
$light_gray: #eee;

.login-container {
  min-height: 100%;
  width: 100%;
  background-color: $bg;
  overflow: hidden;

  .el-icon-loading {
    margin-top: 9px;
    font-size: 25px;
  }
  .login-form {
    position: relative;
    width: 520px;
    max-width: 100%;
    padding: 160px 35px 0;
    margin: 0 auto;
    overflow: hidden;
  }

  .tips {
    font-size: 14px;
    color: #fff;
    margin-bottom: 10px;

    span {
      &:first-of-type {
        margin-right: 16px;
      }
    }
  }

  .svg-container {
    padding: 6px 5px 6px 15px;
    color: $dark_gray;
    vertical-align: middle;
    width: 30px;
    display: inline-block;
  }

  .title-container {
    position: relative;

    .title {
      font-size: 26px;
      color: $light_gray;
      margin: 0px auto 40px auto;
      text-align: center;
      font-weight: bold;
    }
  }

  .show-pwd {
    position: absolute;
    right: 10px;
    top: 7px;
    font-size: 16px;
    color: $dark_gray;
    cursor: pointer;
    user-select: none;
  }

  .thirdparty-button {
    position: absolute;
    right: 0;
    bottom: 6px;
  }

  @media only screen and (max-width: 470px) {
    .thirdparty-button {
      display: none;
    }
  }
}
</style>
