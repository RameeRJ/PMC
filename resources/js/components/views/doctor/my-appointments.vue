<template>
    <Navbar />
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 col-lg-2 bg-light vh-100 p-0">
          <DoctorSidebar />
        </div>
        </div>
        </div>
        </template>
        <script>
        import DoctorSidebar from "../../layoutComponents/DoctorSidebar.vue";
        import Navbar from "../../layoutComponents/NavBar.vue";
        
        export default {
          name: "MyAppointment",
          components: {
            DoctorSidebar,
            Navbar,
          },
        }

          </script>