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

    <div v-if="showAddDoctorModal" class="modal-backdrop">
      <div class="modal-content">
        <button class="close-icon" @click="showAddDoctorModal = false"><i class="fas fa-times"></i></button>
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
            <label for="department">Department</label>
            <input type="text" id="department" v-model="newDoctor.department" required />
          </div>
          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" v-model="newDoctor.phone" required />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" v-model="newDoctor.password" required />
          </div>
          <div class="form-group">
            <label for="confirmpassword">Confirm Password</label>
            <input type="password" id="confirmpassword" v-model="newDoctor.confirmpassword" required />
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
import axios from 'axios'; // Import axios for API calls

export default {
  name: "AdminHome",
  components: {
    AdminSidebar,
    Navbar,
  },
  data() {
    return {
      showAddDoctorModal: false,
      newDoctor: {
        name: "",
        email: "",
        department: "",
        phone: "",
        password: "",
        confirmpassword: "",
      },
      doctors: [],
    };
  },
  created() {
    this.fetchDoctors(); // Fetch the list of doctors when the component is created
  },
  methods: {
    async fetchDoctors() {
      try {
        const response = await axios.get('/doctors'); // Adjust the URL if needed
        this.doctors = response.data.map(doctor => ({
          id: doctor.id,
          name: doctor.user.name, // Assuming user is nested and has a name property
          email: doctor.user.email, // Assuming user has an email property
          department: doctor.department,
          phone: doctor.user.phone, // Assuming user has a phone property
        })); // Transform the response to fit your table
      } catch (error) {
        console.error('Error fetching doctors:', error);
      }
    },
    async submitNewDoctor() {
      if (this.newDoctor.password !== this.newDoctor.confirmpassword) {
        alert("Passwords do not match");
        return;
      }
      try {
        await axios.post('/doctors', this.newDoctor);
        this.fetchDoctors();
        this.resetForm();
        this.showAddDoctorModal = false;
      } catch (error) {
        console.error('Error adding doctor:', error);
      }
    },
    resetForm() {
      this.newDoctor = {
        name: "",
        email: "",
        department: "",
        phone: "",
        password: "",
        confirmpassword: "",
      };
    },
    async removeDoctor(doctorId) {
      try {
        await axios.delete(`/doctors/${doctorId}`); // Adjust the URL for deletion
        this.fetchDoctors();
      } catch (error) {
        console.error('Error removing doctor:', error);
      }
    },
  },
};
</script>

<style scoped>
@import "/public/assets/css/view.css";
</style>   