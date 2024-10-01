<template>
  <Navbar />
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-lg-2 bg-light vh-100 p-0">
        <AdminSidebar />
      </div>
      <div class="col-md-9 col-lg-10 p-4">
        <div class="doctor-list-section">
          <div class="doctor-list-header d-flex justify-content-between align-items-center margin">
            <h2>All Schedules</h2>
            <button class="add btn-responsive">
              <i class="fas fa-plus"></i> Add Schedules
            </button>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Session Title</th>
                <th>Doctor</th>
                <th>Date and Time</th>
                <th>Max Number of Booking</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="doctor in doctors" :key="doctor.id">
                <td>{{ doctor.name }}</td>
                <td>{{ doctor.email }}</td>
                <td>{{ doctor.department }}</td>
                <td>{{ doctor.phone }}</td>
                <td>
                  <button class="action" @click="editDoctor(doctor.id)">
                    <i class="fas fa-edit"></i> <!-- Edit icon -->
                  </button>       
                    <button class="action" @click="removeDoctor(doctor.id)">
                      <i class="fas fa-trash-alt"></i> <!-- Remove/Delete icon -->
                    </button>
                </td>
              </tr>
            </tbody> 
          </table>
        </div>
      </div>
    </div>
    </div>
    </template>
        <script>
        import AdminSidebar from "../../layoutComponents/AdminSidebar.vue";
        import Navbar from "../../layoutComponents/Navbar.vue";
        
        export default {
          name: "Schedule",
          components: {
            AdminSidebar,
            Navbar,
          },
        }

          </script>

<style scoped>
@import "/public/assets/css/view.css";
</style>