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
    <v-btn>{{ progress }}</v-btn>
  </v-app-bar>

  <v-main class="wrapper">
    <v-row class="mt-5 h-screen">
      <v-col class="animation_container flex flex-col align-center justify-center">
        <div class="title text-5xl">
          {{ title }}
        </div>
        <div class="board"></div>
        <div class="description text-2xl">
          {{ description }}
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

.title {
  opacity: 0;
}
.description {
  width: 400px;
  z-index: 2;
}
.animation_container {
  position: relative;
}
.board {
  position: absolute;
  background-color: #1f69c0;
  z-index: 1;
  width: 450px;
  height: 350px;
  border-radius: 50px;
  bottom: 22%;
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
      title: '',
      description: '',
      progress: 0,
      called: false,
    };
  },
  mounted() {
    this.triggerLoopAnimation();
  },

  methods: {
    triggerOneTimeAnimation() {
      const timeline = anime.timeline({loop: true});
    },
    triggerLoopAnimation() {
      if (this.called) {
        return;
      }
      this.called = true;
      const contents = [
        {
          title: 'First Slide',
          description: 'Lorem ipsum dolor sit amet, consectetur ' +
            'adipiscing elit, sed do eiusmod tempor incididunt ut ' +
            'labore et dolore magna aliqua. Sed arcu non odio euismod ' +
            'lacinia at quis risus sed. At in tellus integer feugiat ' +
            'scelerisque varius morbi. Sit amet dictum sit amet. Gravida ' +
            'cum sociis natoque penatibus et magnis dis parturient. Congue '
        },
        {
          title: 'Second Slide',
          description: 'Lorem ipsum dolor sit amet, consectetur ' +
            'adipiscing elit, sed do eiusmod tempor incididunt ut ' +
            'labore et dolore magna aliqua. Sed arcu non odio euismod ' +
            'lacinia at quis risus sed. At in tellus integer feugiat ' +
            'scelerisque varius morbi. Sit amet dictum sit amet. Gravida ' +
            'cum sociis natoque penatibus et magnis dis parturient. Congue '
        },
        {
          title: 'Third Slide',
          description: 'Lorem ipsum dolor sit amet, consectetur ' +
            'adipiscing elit, sed do eiusmod tempor incididunt ut ' +
            'labore et dolore magna aliqua. Sed arcu non odio euismod ' +
            'lacinia at quis risus sed. At in tellus integer feugiat ' +
            'scelerisque varius morbi. Sit amet dictum sit amet. Gravida ' +
            'cum sociis natoque penatibus et magnis dis parturient. Congue '
        },
      ];
      const timeline = anime.timeline({loop: true});
      this.title = contents[0].title;
      this.description = contents[0].description;
      let j = -1;

      timeline
        .add({
          targets: '.title',
          scale: [0.1, 1],
          opacity: [0, 1],
          translateY: '-100px',
          translateZ: 0,
          easing: "easeOutExpo",
          duration: 4000,
          update: (anim) => {
            this.progress = Math.round(anim.progress)
            if (Math.round(anim.progress) === 5) {
              j = j + 1 >= contents.length ? 0 : j + 1;
              this.title = contents[j].title;
              this.description = contents[j].description;
              console.log(this.title)
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
