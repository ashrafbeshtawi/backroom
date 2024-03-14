<template>
  <!-- Header Section -->
  <v-app-bar app color="primary">
    <v-toolbar-title>XFolio</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-btn>Home</v-btn>
    <v-btn>Demo</v-btn>
    <v-btn>Why XFolio</v-btn>
    <v-btn>Sign Up</v-btn>
    <v-btn>Login</v-btn>
  </v-app-bar>

  <v-main class="wrapper">
    <v-row class="mt-5 h-screen">
      <v-col class="flex flex-col justify-center">
        <div id="title" class="text-5xl">
          {{ title }}
        </div>
        <div id="description" class="text-2xl">
          {{ description }}
        </div>
        <div class="board"></div>
      </v-col>
      <v-col class="flex flex-col justify-center">
        <div class="image-slider"></div>
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

#title {
  z-index: 2;
}
#description {
  width: 400px;
  z-index: 2;
}

.board {
  position: absolute;
  background-color: #5f769c;
  z-index: 1;
  width: 450px;
  height: 350px;
  border-radius: 50px;
}

.image-slider {
  background-color: #5f769c;
  width: 75%;
  height: 75%;
  border-radius: 50px;
}
@keyframes bounce {
  0% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(-20px);
  }
}

</style>
<script>
import anime from 'animejs/lib/anime.es.js';

export default {
  data() {
    return {
      animationDuration: 3,
      title: '',
      description: '',
      progress: 0,
      currentContent: 0,
      contents: [
        {
          title: 'First Slide',
          description: 'First Lorem ipsum dolor sit amet, consectetur ' +
            'adipiscing elit, sed do eiusmod tempor incididunt ut ' +
            'labore et dolore magna aliqua. Sed arcu non odio euismod ' +
            'lacinia at quis risus sed. At in tellus integer feugiat ' +
            'scelerisque varius morbi. Sit amet dictum sit amet. Gravida '
        },
        {
          title: 'Second Slide',
          description: 'Second Lorem ipsum dolor sit amet, consectetur ' +
            'adipiscing elit, sed do eiusmod tempor incididunt ut ' +
            'labore et dolore magna aliqua. Sed arcu non odio euismod ' +
            'lacinia at quis risus sed. At in tellus integer feugiat ' +
            'scelerisque varius morbi. Sit amet dictum sit amet. Gravida '
        },
        {
          title: 'Third Slide',
          description: 'Third Lorem ipsum dolor sit amet, consectetur ' +
            'adipiscing elit, sed do eiusmod tempor incididunt ut ' +
            'labore et dolore magna aliqua. Sed arcu non odio euismod ' +
            'lacinia at quis risus sed. At in tellus integer feugiat ' +
            'scelerisque varius morbi. Sit amet dictum sit amet. Gravida '
        },
      ]
    };
  },
  mounted() {
    // call on each 1 of 100th of the animation duration
    setInterval(this.animate, (this.animationDuration * 1000) / 100)
  },

  methods: {
    animate() {
      this.title = this.contents[this.currentContent].title;
      this.description = this.contents[this.currentContent].description;
      const titleElement = document.getElementById('title');
      const descriptionElement = document.getElementById('description');

      if (this.progress >= 100) {
        this.progress = 0;
        this.currentContent = this.currentContent + 1 >= this.contents.length ? 0 : this.currentContent + 1;
      } else {
        this.progress = this.progress + 1;
      }
      titleElement.style.opacity = (this.progress / 100).toString();
      descriptionElement.style.opacity = (this.progress / 100).toString();

    }
  },
};
</script>
