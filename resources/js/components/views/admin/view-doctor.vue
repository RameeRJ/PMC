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
        <form @submit.prevent="registerDoctor">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" v-model="form.name" />
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" v-model="form.email" required />
          </div>
          <div class="form-group">
            <label for="department">Department</label>
            <input type="text" id="department" v-model="form.department" required />
          </div>
          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" v-model="form.phone" required />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" v-model="form.password" required />
          </div>
          <div class="form-group">
            <label for="confirmpassword">Confirm Password</label>
            <input type="password" id="confirmpassword" v-model="form.password_confirmation" required />
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
import { ref } from 'vue';
import Swal from "sweetalert2"; // Ensure to use ref for reactive variables

export default {
  name: "AdminHome",
  components: {
    AdminSidebar,
    Navbar,
  },
  setup() {
    const doctors = ref([]);
    const error = ref(null);
    const showAddDoctorModal = ref(false);

    const form = ref({
      name: "",
      email: "",
      department: "",
      phone: +'+92' + "",
      password: "",
      confirmpassword: "",
    });

    // Function to fetch doctors
    const fetchDoctors = async () => {
      try {
        const response = await axios.post('/doctors'); // Use the POST method with the appropriate endpoint
        doctors.value = response.data; // Update the reactive doctors array
      } catch (error) {
        console.error('Error fetching doctors:', error);
        error.value = 'Failed to load doctors. Please try again.'; // Handle the error
      }
    };

    const registerDoctor = async () => {
      try {
        await axios.post('/add-doctors', form.value); // Use the form data for adding a new doctor
        Swal.fire({
          icon: 'success',
          title: 'Doctor registered successfully',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2000,
          padding: '2em',
        });
        showAddDoctorModal.value = false; // Close modal
        resetForm(); // Reset the form after successful registration
        fetchDoctors(); // Re-fetch doctors after adding
      } catch (error) {
        console.error('Error registering doctor:', error);
        Swal.fire({
          icon: 'error',
          title: 'Registration failed',
          text: error.response?.data?.message || 'An error occurred. Please try again.',
        });
      }
    };

    const resetForm = () => {
      form.value = {
        name: "",
        email: "",
        department: "",
        phone: "",
        password: "",
        confirmpassword: "",
      };
    };

    const removeDoctor = async (doctorId) => {
      try {
        await axios.delete(`/doctors/${doctorId}`); // Adjust the URL for deletion
        fetchDoctors(); // Re-fetch doctors after deletion
      } catch (error) {
        console.error('Error removing doctor:', error);
      }
    };

    // Fetch doctors when the component is mounted
    fetchDoctors();

    return {
      doctors,
      error,
      showAddDoctorModal,
      form,
      fetchDoctors,
      registerDoctor,
      resetForm,
      removeDoctor,
    };
  },
};
</script>


<style scoped>
@import "/public/assets/css/view.css";
</style>
