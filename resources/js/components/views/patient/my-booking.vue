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
            <h2>All Bookings</h2>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Schedule Title</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>Token</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="appointments.length === 0">
                <td colspan="6" class="text-center">No appointments available</td>
              </tr>
              <tr v-for="appointment in filteredAppointments" :key="appointment.id">
                <td v-if="appointment.schedule">{{ appointment.schedule.schedule_title }}</td>
                <td v-if="appointment.schedule">{{ appointment.schedule.doctor.name }}</td>
                <td v-if="appointment.schedule">{{ formatDate(appointment.schedule.schedule_date) }}</td>
                <td v-if="appointment.schedule">{{ formatTime(appointment.schedule.start_time) }}</td>
                <td v-if="appointment.schedule">{{ appointment.token }}</td>
                <td v-if="appointment.schedule">
                  <button v-if="!appointment.prescription" class="action" @click="removeAppointment(appointment.id)">
                    <span class="tooltip-text">Cancel Booking</span>
                    <i class="fa-solid fa-ban"></i>
                  </button>
                  <button v-else class="action" @click="confirmDownload(appointment.prescription, appointment.schedule.schedule_title, appointment.schedule.schedule_date)">
                    <span class="tooltip-text">Download Prescription</span>
                    <i class="fa-solid fa-download"></i>
                  </button>
                </td>
                <td v-else>
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
import axios from 'axios';
import PatientSidebar from "../../layoutComponents/PatientSidebar.vue";
import Navbar from "../../layoutComponents/NavBar.vue";
import { ref, onMounted,computed } from 'vue';
import Swal from 'sweetalert2';

export default {
  name: "Appointment",
  components: {
    PatientSidebar,
    Navbar,
  },
  setup() {
    const appointments = ref([]); // Array to hold the fetched appointments


    // Fetch appointments from the server
    const fetchAppointments = async () => {
      const userId = localStorage.getItem('user_id'); // Get doctor_id from localStorage
      try {
        const response = await axios.post(`/appointments/${userId}`);
        console.log("appointments fetched:", response.data);
        appointments.value = response.data;
      } catch (error) {
        console.error("Error fetching appointments:", error);
        error.value = 'Failed to load doctors. Please try again.';
      }
    };
    const filteredAppointments = computed(() => {
      return appointments.value.filter(appointment => appointment.schedule);
    });

    const removeAppointment = async (id) => {
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
            await axios.delete(`/appointments/${id}`);
            fetchAppointments();
            appointments.value = appointments.value.filter(appointment => appointment.id !== id);
             Swal.fire({
      icon: 'success',
      title: 'Appointment removed successfully',
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
    const confirmDownload = (prescriptionPath, scheduleName, appointmentDate) => {
  Swal.fire({
    title: 'Do you want to download the file?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Download',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      downloadPrescription(prescriptionPath, scheduleName, appointmentDate);
    }
  });
};

const downloadPrescription = (prescriptionPath, scheduleName, appointmentDate) => {
  // Extract the file extension (e.g., 'pdf', 'jpg', 'png')
  const fileExtension = prescriptionPath.split('.').pop().toLowerCase();

  // Replace spaces in the schedule name with underscores
  const sanitizedScheduleName = scheduleName.replace(/\s+/g, '_');

  // Format the appointment date (e.g., '2024-10-11')
  const formattedDate = new Date(appointmentDate).toISOString().split('T')[0];

  // Create the file name dynamically with the schedule name and date
  const fileName = `${sanitizedScheduleName}_${formattedDate}_prescription.${fileExtension}`;

  // Trigger the file download
  const link = document.createElement('a');
  link.href = `/storage/${prescriptionPath}`; // Ensure the path is correct for your setup
  link.download = fileName; // Use the dynamic file name with the correct extension
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
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

  onMounted(fetchAppointments);// Fetch appointments when the component is mounted

  return {
    appointments,
    fetchAppointments,
    formatDate,
    formatTime, 
    removeAppointment,
    confirmDownload,
    filteredAppointments
  };
},
    };
</script>
<style scoped>
@import "/public/assets/css/view.css";
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
  bottom: 125%;
  left: 50%;
  transform: translateX(-50%);
  opacity: 1.8;
  transition: opacity 0.2s;
}

.tooltip-text::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: black transparent transparent transparent;
}

.action:hover .tooltip-text {
  visibility: visible;
  opacity: 1;
}

.action {
  position: relative;
}
</style>
  