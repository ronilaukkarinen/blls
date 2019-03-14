import firebase from 'firebase'
import 'firebase/firestore'

const config = {
  apiKey: "AIzaSyAWp9OL0apAumUEGR9mvDEPuPu4b2WLaQ4",
  authDomain: "hillo-app.firebaseapp.com",
  databaseURL: "https://hillo-app.firebaseio.com",
  projectId: "hillo-app",
  storageBucket: "hillo-app.appspot.com",
  messagingSenderId: "218258742140"
}
firebase.initializeApp(config)

// Firebase utils
const db = firebase.firestore()
const auth = firebase.auth()
const currentUser = auth.currentUser

// Date issue fix according to firebase
const settings = {
    timestampsInSnapshots: true
}
db.settings(settings)

// Firebase collections
const usersCollection = db.collection('users')
const postsCollection = db.collection('posts')
const commentsCollection = db.collection('comments')
const likesCollection = db.collection('likes')

export {
    db,
    auth,
    currentUser,
    usersCollection,
    postsCollection,
    commentsCollection,
    likesCollection
}