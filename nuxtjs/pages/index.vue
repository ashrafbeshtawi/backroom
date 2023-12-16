<template>
  <v-navigation-drawer app v-model="sidebarOpen">
    <v-list-item title="XFolio" subtitle="Portfolio on Steroids"></v-list-item>
    <v-divider></v-divider>
    <v-list-item  title="Home"></v-list-item>
    <v-list-item  title="Demo"></v-list-item>
    <v-list-item  title="Why XFolio"></v-list-item>
  </v-navigation-drawer>
    <!-- Header Section -->
    <v-app-bar app color="primary">
      <v-app-bar-nav-icon @click="toggleSidebar" />
      <v-toolbar-title>XFolio</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn >Home</v-btn>
      <v-btn >Demo</v-btn>
      <v-btn >Why XFolio</v-btn>
      <v-btn >Sign Up</v-btn>
      <v-btn >Login</v-btn>
    </v-app-bar>

    <v-main class="wrapper">
      <v-row class="mt-5 h-screen">
        <v-col class="flex justify-space-around align-center">
          <div class="title text-5xl">
            {{title}}
          </div>
        </v-col>
      </v-row>
    </v-main>

    <!-- Footer Section -->
    <v-footer>
      <v-container>
        <v-row>
          <v-col cols="12" class="text-center">
            &copy; 2023 XFolio. All rights reserved.
          </v-col>
        </v-row>
      </v-container>
    </v-footer>
</template>
<style scoped>
.wrapper {
  height: 95%;
  background-image: url('background.jpg');
  background-size: cover;
}
.planet {
  width: 400px;
  animation: bounce 5s;
}

@keyframes bounce {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-20px);
  }
}

.letter {
  color: red;
}
</style>
<script>
import anime from 'animejs/lib/anime.es.js';

export default {
  data() {
    return {
      sidebarOpen: false,
      title: '',
    };
  },
  mounted() {
    this.triggerAnimation();
  },

  methods: {
    toggleSidebar() {
      this.sidebarOpen = !this.sidebarOpen;
    },
    triggerAnimation() {
      const contents = [
        {title: 'Hello there', description: 'Very cool app'},
        {title: 'First Title', description: 'Very cool app'},
        {title: 'Second one', description: 'Very cool app'},
        {title: 'Third one', description: 'Very cool app'},

      ];
      const timeline = anime.timeline({ loop: true });
      let j = -1;

      timeline
        .add({
          targets: '.title',
          scale: [4,1],
          opacity: [0,1],
          translateZ: 0,
          easing: "easeOutExpo",
          duration: 2000,
          update: (anim) => {
            if (Math.round(anim.progress) === 5) {
              j = j + 1 >= contents.length ? 0 : j + 1;
              this.title = contents[j].title;
            }
          }
        })
        .add({
          targets: '.title',
          opacity: 0,
          duration: 2000,
          easing: "easeOutExpo",
        })
    }

  },
};
</script>
