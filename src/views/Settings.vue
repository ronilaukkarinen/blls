<template>
    <section id="settings">
        <div class="col1">
            <h3>Settings</h3>
            <p>Update your profile</p>

            <transition name="fade">
                <p v-if="showSuccess" class="success">profile updated</p>
            </transition>

            <form @submit.prevent>
                <label for="name">Name</label>
                <input v-model.trim="name" type="text" :placeholder="userProfile.name" id="name" />

                <label for="title">Job Title</label>
                <input v-model.trim="title" type="text" :placeholder="userProfile.title" id="title" />

                <button @click="updateProfile" class="button">Update Profile</button>
            </form>
        </div>
    </section>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        data() {
            return {
                name: '',
                title: '',
                userId: '',
                showSuccess: false
            }
        },
        computed: {
            ...mapState(['userProfile'])
        },
        methods: {
            updateProfile() {
                this.$store.dispatch('updateProfile', {
                    name: this.name !== '' ? this.name : this.userProfile.name,
                    title: this.title !== '' ? this.title : this.userProfile.title,
                    userId: this.userId !== '' ? this.userId : this.userProfile.userId
                })

                this.name = ''
                this.title = ''
                this.userId = ''

                this.showSuccess = true

                setTimeout(() => { this.showSuccess = false }, 2000)
            }
        }
    }
</script>