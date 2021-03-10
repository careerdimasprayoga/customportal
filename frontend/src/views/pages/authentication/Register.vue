<template>
  <div class="auth-wrapper auth-v2">
    <b-row class="auth-inner m-0">

      <!-- Left Text-->
      <b-col lg="4" class="left-style d-none d-lg-flex p-5">
        <div class="sidetext" style="width: 100%; height: 100px; margin-top: 35vh;">
          <h1 class="text-white">RTS Expedition & Logistic</h1>
          <h4 class="text-white">All Shipments from China is our Specialty</h4>
        </div>
        <!-- style="margin-top: -1300px;" -->
      </b-col>
      <!-- /Left Text-->

      <!-- Register-->
      <b-col lg="8" class="auth-bg px-2 p-lg-5" style="padding-top: 5px !important">
        <!-- Awal batas form wizard -->
        <b-col xl="12" lg="12">
          <img :src="daftarImg" style="display: block; margin: 0 auto; width: 150px !important;">
        </b-col>
        <b-col xl="12" lg="12">
          <form-wizard
            color="#a21f1e"
            shape="square"
            finish-button-text="Submit"
            back-button-text="Previous"
            class="mb-3"
            @on-complete="register"
          >
            <!-- accoint details tab -->
            <tab-content
              title="Akun"
              :before-change="validationForm"
            >
              <validation-observer
                ref="accountRules"
                tag="form"
              >
                <b-row>
                  <b-col md="6">
                    <b-form-group
                      label="Kode Marking"
                    >
                      <validation-provider
                        #default="{ errors }"
                        name="Kode Marking"
                        rules="required"
                      >
                        <div class="input-group validasi">
                          <div class="input-group-prepend">
                            <span class="input-group-text">123/</span>
                          </div>
                          <b-form-input :state="errors.length > 0 ? false:null" v-model="form.kode" placeholder="ID Marking" class="form-control" />
                        </div>
                        <small class="text-danger">{{ errors[0] }}</small>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                  <b-col md="6">
                    <b-form-group
                      label="Username"
                      label-for="name"
                    >
                      <validation-provider
                        #default="{ errors }"
                        name="username"
                        rules="required"
                      >
                        <b-form-input
                          v-model="form.username"
                          :state="errors.length > 0 ? false:null"
                          placeholder="johndoe"
                        />
                        <small class="text-danger">{{ errors[0] }}</small>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                  <b-col md="6">
                    <b-form-group
                      label="Email"
                      label-for="email"
                    >
                      <validation-provider
                        #default="{ errors }"
                        name="email"
                        rules="required|email"
                      >
                        <b-form-input
                          id="email"
                          v-model="form.email"
                          type="email"
                          :state="errors.length > 0 ? false:null"
                          placeholder="john.doe@email.com"
                        />
                        <small class="text-danger">{{ errors[0] }}</small>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                  <b-col md="6">
                    <b-form-group
                      label="Password"
                    >
                      <validation-provider
                        #default="{ errors }"
                        name="Password"
                        vid="Password"
                        rules="required"
                      >
                        <b-form-input
                          v-model="form.password"
                          type="password"
                          :state="errors.length > 0 ? false:null"
                          placeholder="Password"
                        />
                        <small class="text-danger">{{ errors[0] }}</small>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                </b-row>
              </validation-observer>
            </tab-content>

            <!-- personal details tab -->
            <tab-content
              title="Personal Info"
              :before-change="validationFormInfo"
            >
              <validation-observer
                ref="infoRules"
                tag="form"
              >
                <b-row>
                  <b-col
                    cols="12"
                    class="mb-2"
                  >
                    <h5 class="mb-0">
                      Personal Info
                    </h5>
                    <small class="text-muted">Masukan Personal Info anda.</small>
                  </b-col>
                  <b-col md="6">
                    <b-form-group
                      label="Nama Lengkap"
                    >
                      <validation-provider
                        #default="{ errors }"
                        name="Nama Lengkap"
                        rules="required"
                      >
                        <b-form-input
                          v-model="form.nama"
                          placeholder="Nama Lengkap"
                          :state="errors.length > 0 ? false:null"
                        />
                        <small class="text-danger">{{ errors[0] }}</small>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                  <b-col md="6">
                    <b-form-group
                      label="No. Telepon"
                    >
                      <validation-provider
                        #default="{ errors }"
                        name="No. Telepon"
                        rules="required"
                      >
                        <b-form-input
                          type="number"
                          id="last-name"
                          v-model="form.telepon"
                          :state="errors.length > 0 ? false:null"
                          placeholder="No. Telepon"
                        />
                        <small class="text-danger">{{ errors[0] }}</small>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                  <b-col md="6">
                    <b-form-group
                      label="No. Whatsapp"
                    >
                      <validation-provider
                        #default="{ errors }"
                        name="No. Whatsapp"
                        rules="required"
                      >
                        <b-form-input
                          type="number"
                          v-model="form.whatsapp"
                          :state="errors.length > 0 ? false:null"
                          placeholder="No. Whatsapp"
                        />
                        <small class="text-danger">{{ errors[0] }}</small>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                  <b-col md="6">
                    <b-form-group label="KTP">
                      <validation-provider
                        #default="{ errors }"
                        name="Foto KTP"
                        rules="ktp"
                      >
                        <input type="file" @change="fileKtp" :state="errors.length > 0 ? false:null" required>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                  <b-col md="12">
                    <b-form-group label="Alamat">
                      <validation-provider
                        #default="{ errors }"
                        name="Alamat"
                        rules="required"
                      >
                        <textarea v-model="form.alamat" class="form-control" placeholder="Alamat Lengkap" cols="82" rows="3" style="border-color: #e2e0e6"></textarea>
                        <small class="text-danger br">{{ errors[0] }}</small>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                </b-row>
              </validation-observer>
            </tab-content>

            <!-- social link -->
            <tab-content
              title="Informasi Tambahan"
              :before-change="validationFormSocial"
            >
              <validation-observer
                ref="socialRules"
                tag="form"
              >
                <b-row>
                  <b-col
                    cols="12"
                    class="mb-2"
                  >
                    <h5 class="mb-0">
                      Informasi Tambahan
                    </h5>
                    <small class="text-muted">Masukan beberapa informasi tambahan</small>
                  </b-col>
                  <b-col md="6">
                    <b-form-group
                      label="NPWP"
                    >
                      <validation-provider
                        #default="{ errors }"
                        name="NPWP"
                      >
                        <b-form-input
                          v-model="form.npwp"
                          :state="errors.length > 0 ? false:null"
                          placeholder="NPWP"
                        />
                        <small class="text-danger">{{ errors[0] }}</small>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                  <b-col md="6">
                    <b-form-group
                      label="Nama Perusahaan"
                    >
                      <validation-provider
                        #default="{ errors }"
                        name="Nama Perusahaan"
                      >
                        <b-form-input
                          v-model="form.perusahaan"
                          :state="errors.length > 0 ? false:null"
                          placeholder="Nama Perusahaan"
                        />
                        <small class="text-danger">{{ errors[0] }}</small>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                  <b-col md="6">
                    <b-form-group
                      label="Rekening"
                    >
                      <validation-provider
                        #default="{ errors }"
                        name="Rekening"
                      >
                        <b-form-input
                          v-model="form.rekening"
                          :state="errors.length > 0 ? false:null"
                          placeholder="Rekening"
                        />
                        <small class="text-danger">{{ errors[0] }}</small>
                      </validation-provider>
                    </b-form-group>
                  </b-col>
                  <b-col md="6">
                    <b-form-group
                      label="Rekomendasi"
                    >
                      <b-form-input
                        v-model="form.rekomendasi"
                        placeholder="Rekomendasi"
                      />
                    </b-form-group>
                  </b-col>
                </b-row>
              </validation-observer>
            </tab-content>
            <p class="text-center mt-2">
              <span>Already have an account?</span>
              <b-link :to="{name:'auth-login'}">
                <span>&nbsp;Sign in instead</span>
              </b-link>
            </p>
          </form-wizard>
        </b-col>

        <!-- Batas Suci -->
        <b-col sm="8" md="6" lg="8" class="px-xl-2 mx-auto">

        <!-- Batas -->
          
        </b-col>
      </b-col>
    <!-- /Register-->
    </b-row>
  </div>
</template>

<style scoped>
.left-style {
  padding: 30px !important;
  background-repeat: no-repeat;
  /* background-position: -100px -550px;  */
  background-position: -130px -100px !important;
  background-image: url('../../../assets/images/internal/bg-4.jpg'); 
  min-height: 500px; 
  background-attachment: fixed; 
  background-position: center; 
  background-repeat: no-repeat; 
  background-size: cover;
}
</style>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard'
import vSelect from 'vue-select'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import { codeIcon } from './code'

/* eslint-disable global-require */
import axios from 'axios'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import VuexyLogo from '@core/layouts/components/Logo.vue'
import {
  BFormInvalidFeedback, BRow, BCol, BLink, BButton, BForm, BFormCheckbox, BFormGroup, BFormInput, BInputGroup, BInputGroupAppend, BImg, BCardTitle, BCardText,
} from 'bootstrap-vue'
import { required, email } from '@validations'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import store from '@/store/index'
import useJwt from '@/auth/jwt/useJwt'

import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default {
  components: {
    VuexyLogo,
    BRow,
    BImg,
    BCol,
    BLink,
    BButton,
    BForm,
    BCardText,
    BCardTitle,
    BFormCheckbox,
    BFormGroup,
    BFormInput,
    BInputGroup,
    BInputGroupAppend,
    // validations
    ValidationProvider,
    ValidationObserver,

    // Batas Suci
    FormWizard,
    TabContent,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    vSelect,
    BFormInvalidFeedback,
    ToastificationContent,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      form: {
        kode: '',
        nama: '',
        email: '',
        telepon: '',
        whatsapp: '',
        npwp: '',
        ktp: {},
        perusahaan: '', 
        alamat: '',
        rekening: '',
        rekomendasi: '',
        username: '',
        password: '',
      },
      status: '',
      username: '',
      userEmail: '',
      password: '',
      sideImg: require('@/assets/images/background/bg-4.jpg'),
      daftarImg: require('@/assets/images/internal/logo.png'),
      // validation
      required,
      email,
      // Batas suci
      name: '',
      emailValue: '',
      PasswordValue: '',
      first_name: '',
      last_name: '',
      address: '',
      landMark: '',
      pincode: '',
      city: '',
      required,
      email,
      codeIcon
    }
  },
  computed: {
    passwordToggleIcon() {
      return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    imgUrl() {
      if (store.state.appConfig.layout.skin === 'dark') {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.sideImg = require('@/assets/images/pages/register-v2-dark.svg')
        return this.sideImg
      }
      return this.sideImg
    },
  },
  methods: {
    formSubmitted() {
      this.$toast({
        component: ToastificationContent,
        props: {
          title: 'Form Submitted',
          icon: 'EditIcon',
          variant: 'success',
        },
      })
    },
    validationForm() {
      return new Promise((resolve, reject) => {
        this.$refs.accountRules.validate().then(success => {
          if (success) {
            resolve(true)
          } else {
            reject()
          }
        })
      })
    },
    validationFormInfo() {
      return new Promise((resolve, reject) => {
        this.$refs.infoRules.validate().then(success => {
          if (success) {
            resolve(true)
          } else {
            reject()
          }
        })
      })
    },
    validationFormAddress() {
      return new Promise((resolve, reject) => {
        this.$refs.addressRules.validate().then(success => {
          if (success) {
            resolve(true)
          } else {
            reject()
          }
        })
      })
    },
    validationFormSocial() {
      return new Promise((resolve, reject) => {
        this.$refs.socialRules.validate().then(success => {
          if (success) {
            resolve(true)
          } else {
            reject()
          }
        })
      })
    },
    fileKtp() {
      this.form.ktp = event.target.files[0]
      if (this.form.ktp.size >= 2097152) {
        let variant = 'danger'  
        let message = 'Max Gambar 2 Mb'
        this.alert(variant, message)
      }
    },
    alert(variant, message) {
      this.$toast({
        component: ToastificationContent,
        props: {
          title: 'Notification',
          icon: 'BellIcon',
          text: message,
          variant: variant,
        },
      })
    },
    register() {
      if (this.form.ktp.size >= 2097152) {
        let variant = 'danger'
        let message = 'Max Gambar 2 Mb'
        this.alert(variant, message)
      }
      const data = new FormData()
      data.append('kode', this.form.kode)
      data.append('nama', this.form.nama)
      data.append('email', this.form.email)
      data.append('telepon', this.form.telepon)
      data.append('whatsapp', this.form.whatsapp)
      data.append('npwp', this.form.npwp)
      data.append('ktp', this.form.ktp)
      data.append('perusahaan', this.form.perusahaan)
      data.append('alamat', this.form.alamat)
      data.append('rekening', this.form.rekening)
      data.append('rekomendasi', this.form.rekomendasi)
      data.append('username', this.form.username)
      data.append('password', this.form.password)
      
      axios
        .post(`/api/auth/register`, data)
        .then(response => {
          if(response.data.code === 401) {
            let variant = 'danger'
            let message = response.data.message
            this.alert(variant, message)
          } else {
            let variant = 'success'
            let message = 'Daftar berhasil! Silahkan Log In'
            this.alert(variant, message)
            setTimeout(this.$router.push('/login'), 6000)
          }
        })
        .catch(error => {
          let variant = 'danger'
          let message = 'Foto KTP harus di isi'
          this.alert(variant, message)
        })
    }
  },
}
/* eslint-disable global-require */
</script>

<style lang="scss">
@import '@core/scss/vue/pages/page-auth.scss';

@import '@core/scss/vue/libs/vue-wizard.scss';
@import '@core/scss/vue/libs/vue-select.scss';
</style>
