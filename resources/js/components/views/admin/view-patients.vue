<template>
    <Navbar />
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 col-lg-2 bg-light vh-100 p-0">
          <AdminSidebar />
        </div>
        </div>
        </div>
        </template>
        <script>
        import AdminSidebar from "../../layoutComponents/AdminSidebar.vue";
        import Navbar from "../../layoutComponents/Navbar.vue";
        
        export default {
          name: "Patients",
          components: {
            AdminSidebar,
            Navbar,
          },
        }

          </script>