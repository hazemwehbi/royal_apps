import AuthorList from './components/Author/List.vue';
import AuthorAdd from './components/Author/Add.vue';
import AuthorEdit from './components/Author/Edit.vue';
import BookList from './components/Book/List.vue';
import BookAdd from './components/Book/Add.vue';
import BookEdit from './components/Book/Edit.vue';
import Profile from './components/Book/Profile.vue';
import Login from './Login.vue';
import Register from './Register.vue';
import Index from './Index.vue';

export const routes = [
 
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'home',
        path: '/',
        component: Index,
        meta:{ guest: true},
        children:[
            {
                name: 'home',
                path: '/',
                component: AuthorList
            },
            {
                name: 'author_add',
                path: '/author/add',
                component: AuthorAdd
            },
            {
                name: 'author_edit',
                path: '/author/edit/:id',
                component: AuthorEdit
            },
          
            {
                name: 'book',
                path: '/book/:id?',
                component: BookList
            },
            {
                name: 'book_add',
                path: '/book/add',
                component: BookAdd
            },
            {
                name: 'book_edit',
                path: '/book/edit/:id',
                component: BookEdit
            },
            {
                name: 'profile',
                path: '/book/profile/:id',
                component: Profile
            },
        ]
    },
   
];


