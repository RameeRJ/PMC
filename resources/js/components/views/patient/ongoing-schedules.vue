<template>
  <Navbar />
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-lg-2 bg-light vh-100 p-0">
        <PatientSidebar />
      </div>
      <div class="col-md-9 col-lg-10 p-4">
        <div class="doctor-list-section">
          <div class="doctor-list-header d-flex justify-content-between align-items-center margin">
          <input
        type="text"
        class="form-control"
        v-model="searchQuery"
        placeholder="Search Doctor or Schedule "
      />
      </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Schedule Title</th>
                <th>Doctor Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="filteredSchedules.length === 0">
      <td colspan="5" class="text-center">No schedules available</td>
    </tr>
              <tr v-for="schedule in filteredSchedules" :key="schedule.id">
                <td>{{ schedule.schedule_title }}</td>
                <td>{{ schedule.doctor.name }}</td>
                <td>{{ formatDate(schedule.schedule_date)}}</td>
                <td> {{ formatTime(schedule.start_time) }} - {{ formatTime(schedule.end_time) }}</td>
                <td>
                  <button class="action" @click="openBookingModal(schedule)">
                    <span class="tooltip-text">Book Appointment</span>
                    <i class="fas fa-book-medical"></i>
                  </button>      
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div v-if="bookAppointmentModel" class="modal-backdrop">
      <div class="modal-content">
        <button class="close-icon" @click="bookAppointmentModel = false"><i class="fas fa-times"></i></button>
        <h3 class="center">Book Your Appointent</h3>
        <form @submit.prevent="bookAppointment">
          <div class="form-group">
            <label for="age">Age</label>
            <input type="number" id="age" v-model="form.age" required />
          </div>
          <div class="form-group">
            <label for="place">Place</label>
            <input type="text" id="place" v-model="form.place" required />
          </div>
          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" v-model="form.phone" required />
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
import PatientSidebar from "../../layoutComponents/PatientSidebar.vue";
import Navbar from "../../layoutComponents/NavBar.vue";
import { ref, onMounted,computed } from "vue";
import axios from "axios";
import { useRoute , useRouter } from "vue-router";
import Swal from "sweetalert2";

export default {
  name: "PatientSchedules",
  components: {
    PatientSidebar,
    Navbar,
  },
  setup() {
    const schedules = ref([]);
    const searchQuery = ref("");
    const route = useRoute();
    const bookAppointmentModel = ref(false);
    const selectedSchedule = ref(null);
    const form = ref({
      age: "",
      place: "",
      phone:"",
    });
    const router = useRouter();




    const fetchSchedules = async () => {
      try {
        const response = await axios.post("/patient/schedules");
        schedules.value = response.data.schedules;
      } catch (error) {
        console.error("Error fetching schedules:", error);
      }
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

    const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('en-US', {
    day: 'numeric',    // Day of the month (e.g., "10")
    month: 'long',     // Full month name (e.g., "October")
    year: 'numeric'    // Full year (e.g., "2024")
  });
};

const openBookingModal = (schedule) => {
      selectedSchedule.value = schedule;
      bookAppointmentModel.value = true;
    };

    const resetForm = () => {
      form.value.age = "";
      form.value.place = "";
      form.value.phone = "";
      bookAppointmentModel.value = false;
    };

    const bookAppointment = async () => {
  try {
    const response = await axios.post("/patient/appointment", {
      schedule_id: selectedSchedule.value.id, // Selected schedule ID
      age: form.value.age,
      place: form.value.place,
      phone: form.value.phone
    });
    Swal.fire({
      icon: 'success',
      title: 'Appointment booked successfully!',
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000,
    });

    if (response.status === 201) {
    
      router.push("/my-booking");
    }
  } catch (error) {
    console.error("Error booking appointment:", error);
    Swal.fire({
      icon: 'error',
      title: 'Booking failed',
      text: error.response?.data?.error || 'An error occurred while booking. Please try again.',
    });
  }
};
    onMounted(() => {
      fetchSchedules();

      if (route.query.search) {
        searchQuery.value = route.query.search; // Populate search query from URL
      }
    });

    

    const filteredSchedules = computed(() => {
      if (!searchQuery.value) {
        return schedules.value;
      }
      return schedules.value.filter(schedule => {
        return (
          schedule.doctor.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
          schedule.schedule_title.toLowerCase().includes(searchQuery.value.toLowerCase())
         
        );
      });
    });

    return {
      schedules,
      formatTime,
      filteredSchedules,
      searchQuery,
      formatDate,
      bookAppointmentModel,
      form,
      openBookingModal,
      bookAppointment,
      resetForm,
    };
  },
};
</script>

<style scoped>
@import "/public/assets/css/view.css";

        .form-control{
          margin-bottom: 30px;
        }
        .form-control:focus {
        box-shadow: 0 0 5px 2px pink;
        border-color: pink;
        outline: none; /* Remove the default outline */
      }
      .tooltip-text {
        visibility: hidden;
        width: 100px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 125%; /* Position above the button */
        left: 50%;
        transform: translateX(-50%);
        opacity: 1.8;
        transition: opacity 0.2s; /* Fade in effect */
      }

      /* Tooltip arrow */
      .tooltip-text::after {
        content: "";
        position: absolute;
        top: 100%; /* Arrow at the bottom */
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: black transparent transparent transparent;
      }

      /* Show tooltip when hovering */
      .action:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
      }
      .action {
        position: relative; /* Needed for tooltip positioning */

      }
</style>
