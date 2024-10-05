<template>
  <Navbar />
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-lg-2 bg-light vh-100 p-0">
        <DoctorSidebar />
      </div>
      <div class="col-md-9 col-lg-10 p-4">
        <div class="doctor-list-section">
          <div class="doctor-list-header d-flex justify-content-between align-items-center margin">
            <h2>All schedules ({{ schedules ? schedules.length : 0 }})</h2>
            <button class="add btn-responsive" @click="showAddScheduleModal = true">
              <i class="fas fa-plus"></i> Add Schedule
            </button>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Schedule Title</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Maximum No.of Booking</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="schedules.length === 0">
                <td colspan="6" class="text-center">No schedules available</td>
              </tr>
              <tr v-for="schedule in schedules" :key="schedule.id">
                <td>{{ schedule.schedule_title }}</td>
                <td>{{ schedule.schedule_date }}</td>
                <td>{{ formatTime(schedule.start_time) }}</td>
                <td>{{ formatTime(schedule.end_time) }}</td>
                <td>{{ schedule.max_bookings }}</td>
                <td>
                  <button class="action" @click="removeSchedule(schedule.id)">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div v-if="showAddScheduleModal" class="modal-backdrop">
      <div class="modal-content">
        <button class="close-icon" @click="showAddScheduleModal = false">
          <i class="fas fa-times"></i>
        </button>
        <h3 class="center">Add New Schedule</h3>
        <form @submit.prevent="registerSchedule">
          <div class="form-group">
            <label for="schedule_title">Title</label>
            <input type="text" id="schedule_title" v-model="form.schedule_title" required />
          </div>
          <div class="form-group">
            <label for="schedule_date">Date</label>
            <input type="date" id="schedule_date" v-model="form.schedule_date" required />
          </div>
          <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" id="start_time" v-model="form.start_time" required />
          </div>
          <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" id="end_time" v-model="form.end_time" required />
          </div>
          <div class="form-group">
            <label for="max_bookings">Max Bookings</label>
            <input type="number" id="max_bookings" v-model="form.max_bookings" required />
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
import DoctorSidebar from "../../layoutComponents/DoctorSidebar.vue";
import Navbar from "../../layoutComponents/NavBar.vue";
import axios from 'axios';
import { ref, onMounted } from 'vue';
import Swal from "sweetalert2";

export default {
  name: "MySchedule",
  components: {
    DoctorSidebar,
    Navbar,
  },
  setup() {
    const schedules = ref([]); // Array to hold the fetched schedules
    const showAddScheduleModal = ref(false); // Control modal visibility
    const error = ref(null);

    const form = ref({
      schedule_title: '',
      schedule_date: '',
      start_time: '',
      end_time: '',
      max_bookings: '',
    });

    // Fetch schedules from the server
    const fetchSchedules = async () => {
      const doctorId = localStorage.getItem('doctor_id'); // Get doctor_id from localStorage
      try {
        const response = await axios.post(`/schedules/${doctorId}`);
        console.log("Schedules fetched:", response.data);
        schedules.value = response.data.schedules;
      } catch (error) {
        console.error("Error fetching schedules:", error);
        error.value = 'Failed to load doctors. Please try again.';
      }
    };

    // Register a new schedule
    const registerSchedule = async () => {
      const doctorId = localStorage.getItem('doctor_id'); // Get doctor ID from local storage
      if (!doctorId) {
        console.error("Doctor ID is not found in local storage.");
        return;
      }

      try {
        form.value.doctor_id = doctorId;
        const response = await axios.post('/schedules', form.value); // Store the API response
        schedules.value.push(response.data.schedule);
        Swal.fire({
          icon: 'success',
          title: 'Doctor registered successfully',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2000,
        });
        showAddScheduleModal.value = false;
        resetForm();
        fetchSchedules();
      } catch (error) {
        console.error("Error creating schedule:", error);
        Swal.fire({
          icon: 'error',
          title: 'Registration failed',
          text: error.response?.data?.message || 'An error occurred. Please try again.',
        });
      }
    };
    const removeSchedule = async (id) => {
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
            await axios.delete(`/schedules/${id}`);
            fetchSchedules();
    schedules.value = schedules.value.filter(schedule => schedule.id !== id);

    Swal.fire({
      icon: 'success',
      title: 'Schedule removed successfully',
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000,
    });
  } catch (error) {
    console.error("Error removing schedule:", error);
    Swal.fire('Error', 'Failed to remove schedule. Please try again.', 'error');
  }
}
      });
    };

    // Reset the form fields
    const resetForm = () => {
      form.value = {
        schedule_title: '',
        schedule_date: '',
        start_time: '',
        end_time: '',
        max_bookings: '',
      };
      showAddScheduleModal.value = false; // Close the modal
    };

    const formatTime = (time) => {
      const [hours, minutes] = time.split(':');
      const date = new Date();
      date.setHours(hours);
      date.setMinutes(minutes);
      return date.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: 'numeric',
        hour12: true,
      });
    };

    // Fetch schedules when the component is mounted
    onMounted(fetchSchedules);

    return {
      schedules,
      form,
      showAddScheduleModal,
      registerSchedule,
      resetForm,
      error,
      removeSchedule,
      formatTime,
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
  border-color: #c86373;
  background-color: #e797a434;
}
</style>
