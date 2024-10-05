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
              <tr v-if="doctors.length === 0">
                <td colspan="6" class="text-center">No doctors available</td>
              </tr>
              <tr v-for="doctor in doctors" :key="doctor.id">
                <td>{{ doctor.name }}</td>
                <td>{{ doctor.email }}</td>
                <td>{{ doctor.department }}</td>
                <td>{{ doctor.phone }}</td>
                <td>
                  <button class="action" @click="editDoctor(doctor.id)">
                    <i class="fas fa-edit"></i>
                  </button>       
                  <button class="action" @click="removeDoctor(doctor.id)">
                    <i class="fas fa-trash-alt"></i>
                  </button>
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
        <button class="close-icon" @click="showAddDoctorModal = false"><i class="fas fa-times"></i></button>
        <h3 class="center">Add New Doctor</h3>
        <form @submit.prevent="registerDoctor">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" v-model="form.name" required />
          </div>
          <div class="form-group">
            <label for="email">Email</label>    
            <input type="email" id="email" v-model="form.email" required />
          </div>
          <div class="form-group">
            <label for="department">Department</label>
            <div class="custom-select-wrapper">
              <select id="department" v-model="form.department" required>
                <option value="" disabled>Select Department</option>
                <option v-for="department in departments" :key="department.id" :value="department.name">
                  {{ department.name }}
                </option>
              </select>
            </div>
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

    <!-- Edit Doctor Modal -->
    <div v-if="showEditDoctorModal" class="modal-backdrop">
      <div class="modal-content">
        <button class="close-icon" @click="showEditDoctorModal = false">
          <i class="fas fa-times"></i>
        </button>
        <h3 class="center">Edit Doctor</h3>
        <form @submit.prevent="updateDoctor">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" v-model="form.name" required />
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" v-model="form.email" required />
          </div>
          <div class="form-group">
            <label for="department">Department</label>
            <div class="custom-select-wrapper">
              <select id="department" v-model="form.department" required>
                <option value="" disabled>Select Department</option>
                <option v-for="department in departments" :key="department.id" :value="department.name">
                  {{ department.name }}
                </option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" v-model="form.phone" required />
          </div>
          <div class="button-group">
            <button type="submit" class="btn btn-add">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import AdminSidebar from "../../layoutComponents/AdminSidebar.vue";
import Navbar from "../../layoutComponents/NavBar.vue";
import axios from 'axios';
import { ref,watch } from 'vue';
import Swal from "sweetalert2";

export default {
  name: "Doctor",
  components: {
    AdminSidebar,
    Navbar,
  },
  setup() {
    const doctors = ref([]);
    const departments = ref([]);
    const error = ref(null);
    const showAddDoctorModal = ref(false);
    const showEditDoctorModal = ref(false);
    const editingDoctorId = ref(null);

    const form = ref({
      name: "",
      email: "",
      department: "",
      phone: "",
      password: "",
      confirmpassword: "",
    });

    // Fetch doctors and departments
    const fetchDoctors = async () => {
      try {
        const response = await axios.post('/doctors');
        doctors.value = response.data;
      } catch (error) {
        console.error('Error fetching doctors:', error);
        error.value = 'Failed to load doctors. Please try again.';
      }
    };

    const fetchDepartments = async () => {
      try {
        const response = await axios.post('/departments');
        departments.value = response.data;
      } catch (error) {
        console.error('Error fetching departments:', error);
        error.value = 'Failed to load departments. Please try again.';
      }
    };

    const registerDoctor = async () => {
      try {
        await axios.post('/add-doctors', form.value);
        Swal.fire({
          icon: 'success',
          title: 'Doctor registered successfully',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2000,
        });
        showAddDoctorModal.value = false;
        resetForm();
        fetchDoctors();
      } catch (error) {
        console.error('Error registering doctor:', error);
        Swal.fire({
          icon: 'error',
          title: 'Registration failed',
          text: error.response?.data?.message || 'An error occurred. Please try again.',
        });
      }
    };

    const editDoctor = async (id) => {
      try {
        const response = await axios.get(`/doctors/${id}/edit`);
        const doctorData = response.data;
        form.value = {
          name: doctorData?.name || '',
          email: doctorData?.email || '',
          department: doctorData?.department || '',
          phone: doctorData?.phone || '',
          password: '',
          confirmpassword: '',
        };
        editingDoctorId.value = id;
        showEditDoctorModal.value = true;
      } catch (error) {
        console.error('Error fetching doctor details:', error);
        Swal.fire({
          icon: 'error',
          title: 'Failed to fetch doctor data',
          text: 'An error occurred while fetching the doctor data. Please try again.',
        });
      }
    };

    const updateDoctor = async () => {
      try {
        await axios.put(`/doctors/${editingDoctorId.value}`, form.value);
        Swal.fire({
          icon: 'success',
          title: 'Doctor updated successfully',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2000,
        });
        showEditDoctorModal.value = false;
        fetchDoctors();
      } catch (error) {
        console.error('Error updating doctor:', error);
      }
    };

    const removeDoctor = async (doctorId) => {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then(async (result) => {
        if (result.isConfirmed) {
          try {
            await axios.delete(`/doctors/${doctorId}`);
            fetchDoctors();
            Swal.fire({
      icon: 'success',
      title: 'Doctor removed successfully',
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000,
    });
          } catch (error) {
            console.error('Error removing doctor:', error);
            Swal.fire('Error!', 'Failed to remove the doctor.', 'error');
          }
        }
      });
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

    // Watchers for modals to load departments when they open
    watch(showAddDoctorModal, (newValue) => {
      if (newValue === true) fetchDepartments();
    });

    watch(showEditDoctorModal, (newValue) => {
      if (newValue === true) fetchDepartments();
    });

    fetchDoctors();

    return {
      doctors,
      form,
      showAddDoctorModal,
      showEditDoctorModal,
      editingDoctorId,
      departments,
      error,
      registerDoctor,
      editDoctor,
      updateDoctor,
      removeDoctor,
      resetForm,
    };
  },
};
</script>

<style scoped>
@import "/public/assets/css/view.css";
.custom-select-wrapper {
  position: relative;
  width: 100%;
}

.custom-select-wrapper select {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  background-color: #ffffff;
  background-position: right 10px center; /* Position for arrow */
  background-repeat: no-repeat;
  background-image: none; /* Remove default background */
}

/* Adding custom arrow */
.custom-select-wrapper::after {
  content: '\25BC'; /* Unicode for downward triangle */
  font-size: 16px;
  color: #333;
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  pointer-events: none; /* Ensures the arrow doesn't block interaction with the select */
}


.custom-select-wrapper select:focus {
  outline: none;
  border-color:#c86373;
  background-color: #e797a434;
}

</style>
