<template>
    <Navbar />
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 col-lg-2 bg-light vh-100 p-0">
          <AdminSidebar />
        </div>
        <div class="col-md-9 col-lg-10 p-4">
          <div class="department-list-section">
            <div class="department-list-header d-flex justify-content-between align-items-center margin">
              <h2>All Departments ({{ departments.length }})</h2>
              <button class="add btn-responsive" @click="showAddDepartmentModal = true">
                <i class="fas fa-plus"></i> Add Department
              </button>
            </div>
            <!-- Department List Table -->
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Department ID</th>
                  <th>Department Name</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="department in departments" :key="department.id">
                  <td>{{ department.id }}</td>
                  <td>{{ department.name }}</td>
                  <td>
                    <button class="action" @click="removeDepartment(department.id)">
                      <i class="fas fa-trash-alt"></i> <!-- Delete icon -->
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
  
          <!-- Add Department Modal -->
          <div v-if="showAddDepartmentModal" class="modal-backdrop">
            <div class="modal-content">
              <button class="close-icon" @click="showAddDepartmentModal = false">
          <i class="fas fa-times"></i>
        </button>
              <h3>Add New Department</h3>
              <form @submit.prevent="registerDepartment">
                <div class="form-group">
                  <label for="departmentName">Department Name:</label>
                  <input type="text" v-model="form.name" id="departmentName" class="form-control" required />
                </div>
                <button type="submit" class="btn add1">Add</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
          <script>
          import AdminSidebar from "../../layoutComponents/AdminSidebar.vue";
          import Navbar from "../../layoutComponents/Navbar.vue";
          import axios from 'axios'; // Assuming you are using Axios for API calls
          import { ref } from 'vue';
          import Swal from "sweetalert2";
          
          export default {
            name: "Departments",
            components: {
              AdminSidebar,
              Navbar,
            },
            setup() {
    const departments= ref([]);
    const error = ref(null);
    const showAddDepartmentModal = ref(false);

    const form = ref({
      name: "",
    });
    
    const fetchDepartments = async () => {
      try {
        const response = await axios.post('/departments'); // Use the POST method with the appropriate endpoint
        departments.value = response.data; // Update the reactive doctors array
      } catch (error) {
        console.error('Error fetching doctors:', error);
        error.value = 'Failed to load doctors. Please try again.'; // Handle the error
      }
    };
    const registerDepartment = async () => {
      try {
        await axios.post('/add-departments', form.value); // Use the form data for adding a new doctor
        Swal.fire({
          icon: 'success',
          title: 'Doctor registered successfully',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2000,
          padding: '2em',
        });
        showAddDepartmentModal.value = false; // Close modal
        resetForm(); // Reset the form after successful registration
        fetchDepartments(); // Re-fetch doctors after adding
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
      };
    };
    const removeDepartment = async (departmentId) => {
  // Show confirmation dialog before deletion
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
      // If user confirms deletion
      try {
        await axios.delete(`/departments/${departmentId}`); // API call for deletion
        Swal.fire({
          toast:true,
          position: 'top-end',
          icon: 'success',
          title: 'Doctor has been deleted.',
          showConfirmButton: false,
          timer: 2000
        });
        fetchDepartments(); // Refresh the doctors list after deletion
      } catch (error) {
        console.error('Error removing doctor:', error);
        Swal.fire({
          icon: 'error',
          title: 'Failed!',
          text: 'Failed to delete doctor. Please try again.',
        });
      }
    }
  });
};
fetchDepartments();
return {
      departments,
      error,
      showAddDepartmentModal,
      form,
      fetchDepartments,
      registerDepartment,
      resetForm,
      removeDepartment,
    };
  },
};
</script>
  
  <style scoped>
  @import "/public/assets/css/view.css";
  .add1 {
  background-color: rgb(255, 255, 255);
  color: #c86373;
  border-color: #c86373;
  border-radius: 4px;
  border-width: thin;
  margin:auto;
  display: block;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 10px 20px;
  transition: background-color 0.3s ease;
}
.add1:hover{
 background-color: #c86373;
 color: #ffffff;


}
  </style>