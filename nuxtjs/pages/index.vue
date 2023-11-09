<template>
  <div>
    <!-- Header Section -->
    <v-app>
      <v-navigation-drawer app>
        <!-- Sidebar content goes here -->
      </v-navigation-drawer>

      <v-app-bar app color="primary">
        <v-app-bar-nav-icon @click="toggleSidebar" />
        <v-toolbar-title>Freelancer Portfolio</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn outlined>Sign Up</v-btn>
        <v-btn text>Login</v-btn>
      </v-app-bar>
    </v-app>

    <!-- Main Content Section -->
    <v-main>
      <v-container>
        <!-- Hero Section -->
        <v-row align="center">
          <v-col cols="12">
            <h1>Welcome to Your Freelancer Portfolio</h1>
            <p>Showcase your skills and work to potential clients.</p>
            <v-btn color="primary" large>Get Started</v-btn>
          </v-col>
        </v-row>

        <!-- Features Section -->
        <v-row>
          <v-col cols="12" sm="6" md="4">
            <v-card>
              <v-card-title>Feature 1</v-card-title>
              <v-card-text>Highlight your skills and expertise.</v-card-text>
            </v-card>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-card>
              <v-card-title>Feature 2</v-card-title>
              <v-card-text>Showcase your work with ease.</v-card-text>
            </v-card>
          </v-col>
          <v-col cols="12" sm="6" md="4">
            <v-card>
              <v-card-title>Feature 3</v-card-title>
              <v-card-text>Connect with potential clients.</v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
    <!-- Footer Section -->
    <v-footer app>
      <v-container>
        <!-- Footer content goes here -->
      </v-container>
    </v-footer>
  </div>
</template>
<script>
export default {
  methods: {
    toggleSidebar() {
      // Implement the sidebar toggle logic here
    },
  },
};
</script>

