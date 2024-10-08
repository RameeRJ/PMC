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
        placeholder="Search Doctor, Schedule or Date"
      />
      </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Schedule Title</th>
                <th>Doctor Name</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="!schedules ">
                <td colspan="6" class="text-center">No doctors available</td>
              </tr>
              <tr v-for="schedule in filteredSchedules" :key="schedule.id">
                <td>{{ schedule.schedule_title }}</td>
                <td>{{ schedule.doctor.name }}</td>
                <td>{{ schedule.schedule_date }}</td>
                <td>{{ formatTime(schedule.start_time) }}</td>
                <td>{{ formatTime(schedule.end_time)  }}</td>
                <td>
                  <button class="action" @click="getSession(doctor.id)">
                    <span class="tooltip-text">Get Appointment</span>
                    <i class="fas fa-book-medical"></i>
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
import PatientSidebar from "../../layoutComponents/PatientSidebar.vue";
import Navbar from "../../layoutComponents/NavBar.vue";
import { ref, onMounted,computed } from "vue";
import axios from "axios";

export default {
  name: "PatientSchedules",
  components: {
    PatientSidebar,
    Navbar,
  },
  setup() {
    const schedules = ref([]);
    const searchQuery = ref("");

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

    onMounted(() => {
      fetchSchedules();
    });

    const filteredSchedules = computed(() => {
      if (!searchQuery.value) {
        return schedules.value;
      }
      return schedules.value.filter(schedule => {
        return (
          schedule.doctor.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
          schedule.schedule_title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
          schedule.schedule_date.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
      });
    });

    return {
      schedules,
      formatTime,
      filteredSchedules,
      searchQuery,
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
