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
      <v-col class="flex flex-col align-center justify-evenly">
        <div class="title text-5xl">
          {{ title }}
        </div>
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

.planet {
  width: 400px;
  animation: bounce 5s;
}
.description {
  width: 400px;
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
      description: ''
    };
  },
  mounted() {
    this.triggerAnimation();
  },

  methods: {
    triggerAnimation() {
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
            if (Math.round(anim.progress) === 5) {
              j = j + 1 >= contents.length ? 0 : j + 1;
              this.title = contents[j].title;
              this.description = contents[j].description;
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
