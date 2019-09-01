@extends('layouts.main')
@section('content')

<div id="app">
    <v-app id="inspire">

        <v-navigation-drawer
            v-model="drawer"
            app        >
            <v-list dense>

                <router-link active v-ripple="{'center':true}" @click="" to="/" tabindex="0" class="v-list-item v-list-item--link theme--light">
                    <div class="v-list-item__action">
                        <i aria-hidden="true" class="v-icon notranslate material-icons theme--light">
                            dashboard</i></div>
                    <div class="v-list-item__content">
                        <div class="v-list-item__title">
                            Dashboard
                        </div></div>

                </router-link>

                <router-link v-ripple="{'center':true}" @click="" to="/accounts" tabindex="0" class="v-list-item v-list-item--link theme--light">
                    <div class="v-list-item__action">
                        <i aria-hidden="true" class="v-icon notranslate material-icons theme--light">
                            people</i></div>
                    <div class="v-list-item__content">
                        <div class="v-list-item__title">
                            Accounts
                        </div></div>
                </router-link>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar
            app
            color="green darken-4"
            dark
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>APP</v-toolbar-title>
            <v-spacer></v-spacer>

            <v-btn icon>
                <v-icon>mdi-heart</v-icon>
            </v-btn>

            <v-btn icon>
                <v-icon>mdi-magnify</v-icon>
            </v-btn>
        </v-app-bar>

        <v-content padding-x="3">
            <v-container   fluid >
                <transition>
                    <router-view></router-view>

                </transition>
            </v-container>
        </v-content>

    </v-app>
</div>
    @endsection
