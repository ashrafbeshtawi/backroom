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

    <!-- Main Content Section -->
    <v-main class="wrapper">
      <v-row class="mt-5 h-screen">
        <v-col class="flex justify-space-around align-center">
          <div class="title text-5xl">XFolio</div>
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
</style>
<script>
import anime from 'animejs/lib/anime.es.js';

export default {
  data() {
    return {
      sidebarOpen: false,
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
        {title: '12344555L', description: 'Very cool app'},
      ];
      const timeline = anime.timeline({ loop: true });
      let j = 0;

      timeline
        .add({
          targets: '.title',
          opacity: 0,
          duration: 2000,
          easing: "easeOutExpo",
          update: (anim) => {
            if (anim.progress >= 100) {
              j = (j + 1) % contents.length; // Adjusted the increment logic
              const textWrapper = document.querySelector('.title');
              textWrapper.innerHTML = contents[j].title; // Set the title content once
              textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
            }
          }
        })
        .add({
          targets: '.title .letter',
          scale: [4, 1],
          opacity: [0, 1],
          translateZ: 0,
          easing: "easeOutExpo",
          duration: 2000,
          delay: (el, i) => 70 * i
        }, 1000);
    }

  },
};
</script>
