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
          <h2>All Doctors ({{ doctors.length }})</h2>
          <button
              class=" add"
              @click="addNewDoctor"
            >
              Add New Doctor
            </button>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Doctor Name</th>
                <th>Email</th>
                <th>Specialties</th>
                <th>Events</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="doctor in doctors" :key="doctor.id">
                <td>{{ doctor.name }}</td>
                <td>{{ doctor.email }}</td>
                <td>{{ doctor.specialty }}</td>
                <td>
                  <button class="btn btn-sm btn-primary">Edit</button>
                  <button class="btn btn-sm btn-info">View</button>
                  <button class="btn btn-sm btn-danger" @click="removeDoctor(doctor.id)">Remove</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Add New Doctor Button at the bottom -->
         <center>
        <div class="add-doctor-section">
          <div class="add-new-doctor-container">
            <button
              class="login-btn btn-primary btn button-icon"
              @click="addNewDoctor"
            >
              Add New Doctor
            </button>
          </div>
        </div>
        </center>
      </div>
    </div>
  </div>
</template>
 
<script>
import AdminSidebar from "../../layoutComponents/AdminSidebar.vue";
import Navbar from "../../layoutComponents/Navbar.vue";

export default {
  name: 'AdminHome',
  components: {
    AdminSidebar,
    Navbar
  },
  data() {
    return {
      newDoctor: {
        name: '',
        email: '',
        specialty: ''
      },
      doctors: [], // This will hold the list of doctors
    };
  },
  methods: {
    addNewDoctor() {
      // Add the new doctor to the list (you can replace this with an API call)
      this.doctors.push({ ...this.newDoctor, id: Date.now() });
      // Clear the form
      this.newDoctor.name = '';
      this.newDoctor.email = '';
      this.newDoctor.specialty = '';
    },
    removeDoctor(doctorId) {
      // Remove doctor from the list (you can replace this with an API call)
      this.doctors = this.doctors.filter(doctor => doctor.id !== doctorId);
    }
  }
};
</script>

<style scoped>
.add-doctor-section {
  background-color: #f8f9fa;
  padding: 20px;
  border-radius: 5px;
}

h1 {
  text-align: center;
}

h2 {
  margin-bottom: 20px;
}

.table th, .table td {
  vertical-align: middle;
}

.table button {
  margin-right: 5px;
}

.btn-primary, .btn-info, .btn-danger {
  color: white;
}
.logout-btn {
  padding: 8px 16px;
  background-color: #c86373;
  color: whitesmoke;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  letter-spacing: 0.5px;
  transition: all 0.3s;
  font-size: 16px;
  

}
.add{
  background-color: #c86373;
}
</style>