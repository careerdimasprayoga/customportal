<template>
  <div class="auth-wrapper auth-v2">
    <b-row class="auth-inner m-0">

      <!-- Login-->
      <b-col
        lg="6"
        class="d-flex align-items-center auth-bg px-2 p-lg-5"
      >
        <b-col
          sm="8"
          md="6"
          lg="12"
          class="px-xl-2 mx-auto"
        >
          <div class="headerIcon" style="width: 100%; height: auto">
            <img :src="this.loginImg" alt="" style="display: block; margin: 0 auto !important;">
          </div>
          <b-card-title
            class="mb-2 mt-2 font-weight-bold text-center"
            title-tag="h2"
          >
            Member Area
          </b-card-title>

          <!-- form -->
          <validation-observer
            ref="loginForm"
            #default="{invalid}"
          >
            <b-form
              class="auth-login-form mt-2"
              @submit.prevent="login"
            >
              <!-- email -->
              <b-form-group
                label="Kode Marking"
                label-for="login-email"
              >
                <validation-provider
                  #default="{ errors }"
                  name="Kode Marking"
                  rules="required"
                >
                  <b-form-input
                    v-model="form.kode_marking"
                    :state="errors.length > 0 ? false:null"
                    placeholder="123/ID Marking"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- forgot password -->
              <b-form-group>
                <div class="d-flex justify-content-between">
                  <label for="login-password">Password</label>
                </div>
                <validation-provider
                  #default="{ errors }"
                  name="Password"
                  rules="required"
                >
                  <b-input-group
                    class="input-group-merge"
                    :class="errors.length > 0 ? 'is-invalid':null"
                  >
                    <b-form-input
                      id="login-password"
                      v-model="form.password"
                      :state="errors.length > 0 ? false:null"
                      class="form-control-merge"
                      :type="passwordFieldType"
                      name="login-password"
                      placeholder="Password"
                    />
                    <b-input-group-append is-text>
                      <feather-icon
                        class="cursor-pointer"
                        :icon="passwordToggleIcon"
                        @click="togglePasswordVisibility"
                      />
                    </b-input-group-append>
                  </b-input-group>
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- submit buttons -->
              <b-button
                type="submit"
                variant="primary"
                block
                :disabled="invalid"
              >
                Sign in
              </b-button>
            </b-form>
          </validation-observer>

          <b-card-text class="text-center mt-2">
            <span>New on our platform? </span>
            <b-link :to="{name:'auth-register'}">
              <span>&nbsp;Create an account</span>
            </b-link>
          </b-card-text>

          <!-- divider -->
          <!-- For social login -->
        </b-col>
      </b-col>

      <!-- Rigt Text-->
      <b-col
        lg="6"
        class="d-none d-lg-flex align-items-center p-5 left-style"
      >
        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
          <!-- <b-img
            fluid
            :src="sideImg"
            alt="Login V2"
          /> -->
        </div>
      </b-col>
      <!-- /Right Text-->
    <!-- /Login-->
    </b-row>
  </div>
</template>

<script>
import axios from 'axios'
/* eslint-disable global-require */
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import VuexyLogo from '@core/layouts/components/Logo.vue'
import {
  BRow, BCol, BLink, BFormGroup, BFormInput, BInputGroupAppend, BInputGroup, BFormCheckbox, BCardText, BCardTitle, BImg, BForm, BButton, BAlert, VBTooltip,
} from 'bootstrap-vue'
import useJwt from '@/auth/jwt/useJwt'
import { required, email } from '@validations'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import store from '@/store/index'
import { getHomeRouteForLoggedInUser } from '@/auth/utils'

import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default {
  directives: {
    'b-tooltip': VBTooltip,
  },
  components: {
    BRow,
    BCol,
    BLink,
    BFormGroup,
    BFormInput,
    BInputGroupAppend,
    BInputGroup,
    BFormCheckbox,
    BCardText,
    BCardTitle,
    BImg,
    BForm,
    BButton,
    BAlert,
    VuexyLogo,
    ValidationProvider,
    ValidationObserver,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      status: '',
      form: {
        kode_marking: '',
        password: ''
      },
      sideImg: require('@/assets/images/internal/bg-4.jpg'),
      loginImg: require('@/assets/images/internal/logo.png'),
      // validation rules
      required,
      email,
    }
  },
  computed: {
    passwordToggleIcon() {
      return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    imgUrl() {
      if (store.state.appConfig.layout.skin === 'dark') {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.sideImg = require('@/assets/images/pages/login-v2-dark.svg')
        return this.sideImg
      }
      return this.sideImg
    },
  },
  methods: {
    notif(title, icon, variant) {
      this.$toast({
        component: ToastificationContent,
        position: 'top-right',
        props: {
          title: title,
          icon: icon,
          variant: variant,
        },
      })
    },
    login() {
      axios
        .post(`/api/auth/login`, this.form)
        .then(response => {
          if(response.data.code === 201) {
            return this.notif(response.data.message, 'CoffeeIcon', 'danger')
          }

          let userData = response.data.userData[0]
          userData.ability = [{action: "manage", subject: "all"}]
          userData.avatar = 'avatarasem.jpg'
          useJwt.setToken(response.data.accessToken)
          useJwt.setRefreshToken(response.data.refreshToken)
          localStorage.setItem('userData', JSON.stringify(userData))

          this.notif(response.data.message, 'CoffeeIcon', 'success')
          setTimeout(()=>{
            this.$router.push('/dashboard/ecommerce')
          },2000)
        })
        .catch(error => {
          this.$toast({
            component: ToastificationContent,
            position: 'top-right',
            props: {
              title: `Ada kesalahan otentikasi`,
              icon: 'CoffeeIcon',
              variant: 'danger',
            },
          })
        })
      
      
      // this.$refs.loginForm.validate().then(success => {
      //   if (success) {
      //     useJwt.login({
      //       email: this.userEmail,
      //       password: this.password,
      //     })
      //       .then(response => {
      //         console.log(response)
      //         const { userData } = response.data
      //         useJwt.setToken(response.data.accessToken)
      //         useJwt.setRefreshToken(response.data.refreshToken)
      //         localStorage.setItem('userData', JSON.stringify(userData))
      //         this.$ability.update(userData.ability)

      //         // ? This is just for demo purpose as well.
      //         // ? Because we are showing eCommerce app's cart items count in navbar
      //         this.$store.commit('app-ecommerce/UPDATE_CART_ITEMS_COUNT', userData.extras.eCommerceCartItemsCount)

      //         // ? This is just for demo purpose. Don't think CASL is role based in this case, we used role in if condition just for ease
      //         this.$router.replace(getHomeRouteForLoggedInUser(userData.role))
      //           .then(() => {
      //             this.$toast({
      //               component: ToastificationContent,
      //               position: 'top-right',
      //               props: {
      //                 title: `Welcome ${userData.fullName || userData.username}`,
      //                 icon: 'CoffeeIcon',
      //                 variant: 'success',
      //                 text: `You have successfully logged in as ${userData.role}. Now you can start to explore!`,
      //               },
      //             })
      //           })
      //           .catch(error => {
      //             this.$refs.loginForm.setErrors(error.response.data.error)
      //           })
      //       })
      //   }
      // })
    },
  },
}
</script>

<style scoped>
.left-style {
  padding: 30px !important;
  background-repeat: no-repeat;
  /* background-position: -100px -550px;  */
  background-position: 600px -100px !important;
  background-image: url('../../../assets/images/internal/bg-4.jpg'); 
  min-height: 500px; 
  background-attachment: fixed; 
  background-position: center; 
  background-repeat: no-repeat; 
  background-size: cover;
}
</style>

<style lang="scss">
@import '@core/scss/vue/pages/page-auth.scss';
</style>
