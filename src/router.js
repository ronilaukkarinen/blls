import Vue from 'vue'
import Router from 'vue-router'
import firebase from 'firebase'

import Dashboard from '@/views/Dashboard'
import Login from '@/views/Login'
import SignUp from '@/views/SignUp'
import AccountCreated from '@/views/AccountCreated'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '*',
      redirect: '/dashboard'
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: Dashboard,
      meta: {
        requiresAuth: true
      }
    },    
    {
      path: '/account-created',
      name: 'Account created',
      component: AccountCreated
    },
    {
      path: '/sign-up',
      name: 'SignUp',
      component: SignUp
    }
  ]
})

export default router

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(x => x.meta.requiresAuth)
    const currentUser = firebase.auth().currentUser

    if (requiresAuth && !currentUser) {
        next('/login')
    } else if (requiresAuth && currentUser) {
        next()
    } else {
        next()
    }
})