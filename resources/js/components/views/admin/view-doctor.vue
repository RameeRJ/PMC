<template>
  <Navbar />
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar Column (left) -->
      <div class="col-md-3 col-lg-2 bg-light vh-100 p-0">
        <AdminSidebar />
      </div>

      <!-- Admin Content (right) -->
      <div class="col-md-9 col-lg-10 p-4">
        <!-- List of Doctors -->
        <div class="doctor-list-section">
          <div class="doctor-list-header d-flex justify-content-between align-items-center margin">
            <h2>All Doctors ({{ doctors.length }})</h2>
            <button class="add btn-responsive" @click="showAddDoctorModal = true">
              <i class="fas fa-plus"></i> Add Doctor
            </button>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Doctor Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Phone</th>
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
                  <button class="btn btn-sm btn-primary">Edit</button>
                  <button class="btn btn-sm btn-info">View</button>
                  <button class="btn btn-sm btn-danger" @click="removeDoctor(doctor.id)">Remove</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Add Doctor Modal -->
    <div v-if="showAddDoctorModal" class="modal-backdrop">
      <div class="modal-content">
        <button class="close-icon" @click="showAddDoctorModal = false" ><i class="fas fa-times"></i></button>
        <h3 class="center">Add New Doctor</h3>
        <form @submit.prevent="submitNewDoctor">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" v-model="newDoctor.name" required />
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" v-model="newDoctor.email" required />
          </div>
          <div class="form-group">
            <label for="specialty">Department</label>
            <input type="text" id="specialty" v-model="newDoctor.department" required />
          </div>
          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" v-model="newDoctor.phone" required />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" v-model="newDoctor.password" required />
          </div><div class="form-group">
            <label for="password">ConfirmPassword</label>
            <input type="password" id="password" v-model="newDoctor.confirmpassword" required />
          </div>
          <div class="button-group">
            <button type="submit" class="btn btn-add">Submit</button>
            <button type="reset" class="btn btn-add-secondary" @click="resetForm">Reset</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import AdminSidebar from "../../layoutComponents/AdminSidebar.vue";
import Navbar from "../../layoutComponents/Navbar.vue";

export default {
  name: "AdminHome",
  components: {
    AdminSidebar,
    Navbar,
  },
  data() {
    return {
      showAddDoctorModal: false, // Control modal visibility
      newDoctor: {
        name: "",
        email: "",
        Department: "",
        phone: "",
        password: "",
      },
      doctors: [], // This will hold the list of doctors
    };
  },
  methods: {
    addNewDoctor() {
      this.showAddDoctorModal = true; // Show modal on button click
    },
    submitNewDoctor() {
      // Add the new doctor to the list (you can replace this with an API call)
      this.doctors.push({ ...this.newDoctor, id: Date.now() });

      // Clear the form
      this.newDoctor.name = "";
      this.newDoctor.email = "";
      this.newDoctor.department = "";
      this.newDoctor.phone = "";
      this.newDoctor.password = "";

      // Hide modal
      this.showAddDoctorModal = false;
    },
    removeDoctor(doctorId) {
      // Remove doctor from the list (you can replace this with an API call)
      this.doctors = this.doctors.filter((doctor) => doctor.id !== doctorId);
    },
  },
};
</script>

<style scoped>
@import "/public/assets/css/view.css";

</style>
