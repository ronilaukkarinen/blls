<template>
    <div id="login">
        <transition name="fade">
            <div v-if="performingRequest" class="loading">
                <p>Ladataan...</p>
            </div>
        </transition>
        <section id="wrapper">
            <div class="login-container" :class="{ 'signup-form': !showLoginForm && !showForgotPassword }">
                <form v-if="showLoginForm" @submit.prevent>
                    <h1>Tervetuloa takaisin</h1>                    

                    <label for="email1">Sähköposti</label>
                    <input v-model.trim="loginForm.email" type="text" placeholder="" id="email1" />

                    <label for="password1">Salasana</label>
                    <input v-model.trim="loginForm.password" type="password" placeholder="" id="password1" />

                    <button @click="login" class="button">Kirjaudu sisään</button>

                    <div class="extras">
                        <a @click="togglePasswordReset">Unohditko salasanasi?</a>
                        <a @click="toggleForm">Rekisteröidy</a>
                    </div>
                </form>
                <form v-if="!showLoginForm && !showForgotPassword" @submit.prevent>
                    <h1>Rekisteröityminen</h1>

                    <label for="name">Nimi</label>
                    <input v-model.trim="signupForm.name" type="text" placeholder="" id="name" />

                    <label for="title">Yritys</label>
                    <input v-model.trim="signupForm.title" type="text" placeholder="" id="title" />

                    <label for="email2">Sähköpostiosoite</label>
                    <input v-model.trim="signupForm.email" type="text" placeholder="you@email.com" id="email2" />

                    <label for="password2">Salasana</label>
                    <input v-model.trim="signupForm.password" type="password" placeholder="" id="password2" />

                    <button @click="signup" class="button">Rekisteröidy</button>

                    <div class="extras">
                        <a @click="toggleForm">Takaisin kirjautumiseen</a>
                    </div>
                </form>
                <form v-if="showForgotPassword" @submit.prevent class="password-reset">
                    <div v-if="!passwordResetSuccess">
                        <h1>Nollaa salasanasi</h1>
                        <p>Lähetämme sinulle sähköpostiin linkin, jonka avulla voit luoda uuden salasanan.</p>

                        <label for="email3">Sähköpostiosoitteesi</label>
                        <input v-model.trim="passwordForm.email" type="text" placeholder="you@email.com" id="email3" />

                        <button @click="resetPassword" class="button">Lähetä</button>

                        <div class="extras">
                            <a @click="togglePasswordReset">Takaisin kirjautumiseen</a>
                        </div>
                    </div>
                    <div v-else>
                        <h1>Onnistui!</h1>
                        <p>Katso sähköpostilaatikostasi ohjeet salasanan nollaamiseen.</p>
                        <button @click="togglePasswordReset" class="button">Takaisin kirjautumiseen</button>
                    </div>
                </form>
                <transition name="fade">
                    <div v-if="errorMsg !== ''" class="error-msg">
                        <p>{{ errorMsg }}</p>
                    </div>
                </transition>
            </div>
        </section>
    </div>
</template>

<script>
    const fb = require('../firebaseConfig.js')
    import HilloLogo from '../assets/svg/dashboard/logo.svg';

    export default {
        name: 'Login',
        data() {
            return {
                loginForm: {
                    email: '',
                    password: ''
                },
                signupForm: {
                    name: '',
                    title: '',
                    email: '',
                    userId: '',
                    password: ''
                },
                passwordForm: {
                    email: ''
                },
                showLoginForm: true,
                showForgotPassword: false,
                passwordResetSuccess: false,
                performingRequest: false,
                errorMsg: ''
            }
        },
        methods: {
            toggleForm() {
                this.errorMsg = ''
                this.showLoginForm = !this.showLoginForm
            },
            togglePasswordReset() {
                if (this.showForgotPassword) {
                    this.showLoginForm = true
                    this.showForgotPassword = false
                    this.passwordResetSuccess = false
                } else {
                    this.showLoginForm = false
                    this.showForgotPassword = true
                }
            },
            login() {
                this.performingRequest = true

                fb.auth.signInWithEmailAndPassword(this.loginForm.email, this.loginForm.password).then(res => {
                    this.$store.commit('setCurrentUser', res.user)
                    this.$store.dispatch('fetchUserProfile')
                    this.performingRequest = false
                    this.$router.push('/dashboard')
                }).catch(err => {
                    console.log(err)
                    this.performingRequest = false
                    this.errorMsg = err.message
                })
            },
            signup() {
                this.performingRequest = true

                fb.auth.createUserWithEmailAndPassword(this.signupForm.email, this.signupForm.password).then(res => {
                    this.$store.commit('setCurrentUser', res.user)

                    // create user obj
                    fb.usersCollection.doc(res.user.uid).set({
                        name: this.signupForm.name,
                        title: this.signupForm.title
                    }).then(() => {
                        this.$store.dispatch('fetchUserProfile')
                        this.performingRequest = false
                        this.$router.push('/dashboard')
                    }).catch(err => {
                        console.log(err)
                        this.performingRequest = false
                        this.errorMsg = err.message
                    })
                }).catch(err => {
                    console.log(err)
                    this.performingRequest = false
                    this.errorMsg = err.message
                })
            },
            resetPassword() {
                this.performingRequest = true

                fb.auth.sendPasswordResetEmail(this.passwordForm.email).then(() => {
                    this.performingRequest = false
                    this.passwordResetSuccess = true
                    this.passwordForm.email = ''
                }).catch(err => {
                    console.log(err)
                    this.performingRequest = false
                    this.errorMsg = err.message
                })
            }
        }
    }
</script>