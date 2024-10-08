<template>
  <Navbar />
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-lg-2 bg-light vh-100 p-0">
        <PatientSidebar />
      </div>
      </div>
      </div>
      </template>
      <script>
      import PatientSidebar from "../../layoutComponents/PatientSidebar.vue";
      import Navbar from "../../layoutComponents/NavBar.vue";
      
      export default {
        name: "Appointment",
        components: {
          PatientSidebar,
          Navbar,
        },
      }

        </script>