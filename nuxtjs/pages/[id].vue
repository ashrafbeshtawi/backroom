<template>
  <v-container>
    <!-- Hero Section -->
    <v-row align="center">
      <v-col cols="12">
        <h1 class="display-3 text-center">Welcome to Your Freelancer Portfolio</h1>
        <p class="text-center">Showcase your skills and work to potential clients.</p>
        <v-btn color="primary" large>Get Started</v-btn>
      </v-col>
    </v-row>

    <!-- Features Section -->
    <v-row>
      <v-col cols="12" md="4">
        <v-card class="text-center">
          <v-card-title class="headline">Feature 1</v-card-title>
          <v-card-text>Highlight your skills and expertise.</v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" md="4">
        <v-card class="text-center">
          <v-card-title class="headline">Feature 2</v-card-title>
          <v-card-text>Showcase your work with ease.</v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" md="4">
        <v-card class="text-center">
          <v-card-title class="headline">Feature 3</v-card-title>
          <v-card-text>Connect with potential clients.</v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
  <!-- Footer Section -->
  <v-footer>
    <v-container>
      <v-row>
        <v-col cols="12" class="text-center">
          &copy; 2023 Freelancer Portfolio. All rights reserved.
        </v-col>
      </v-row>
    </v-container>
  </v-footer>
</template>

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
