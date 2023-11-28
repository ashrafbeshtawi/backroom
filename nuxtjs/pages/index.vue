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

      <v-container>
        <v-row class="mt-5">
          <v-col>
            <v-card title="XFolio" text="lorem ipsum" variant="tonal"></v-card>
          </v-col>
          <v-col class="flex justify-space-around">
            <img class="planet" src="planet1.png">
          </v-col>
        </v-row>
      </v-container>
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
  background-repeat: repeat;
}
.planet {
  width: 400px;
  animation: bounce 5s infinite;
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
export default {
  data() {
    return {
      sidebarOpen: false,
    };
  },
  methods: {
    toggleSidebar() {
      this.sidebarOpen = !this.sidebarOpen;
    },
  },
};
</script>
