<template>
  <Navbar />

  <!-- Doctor appointments table -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-lg-2 bg-light vh-100 p-0">
        <DoctorSidebar />
      </div>
      <div class="col-md-9 col-lg-10 p-4">
        <div class="doctor-list-section">
          <div class="doctor-list-header d-flex justify-content-between align-items-center margin">
            <input type="text" class="form-control" v-model="searchQuery" placeholder="Search Patient or Schedule" />
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Patient Name</th>
                <th>Age</th>
                <th>Place</th>
                <th>Phone</th>
                <th>Schedule</th>
                <th>Token</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="filteredAppointments.length === 0">
                <td colspan="7" class="text-center">No appointments available</td>
              </tr>
              <tr v-for="appointment in filteredAppointments" :key="appointment.id">
                <td>{{ appointment.name }}</td>
                <td>{{ appointment.age }}</td>
                <td>{{ appointment.place }}</td>
                <td>{{ appointment.phone }}</td>
                <td>{{ appointment.schedule.schedule_title }}</td>
                <td>{{ appointment.token }}</td>
                <td>
                  <!-- Check if the prescription is already sent -->
                  <button v-if="!appointment.prescriptionSent" class="action" @click="openPrescriptionModal(appointment)">
                    <span class="tooltip-text">Send Prescription</span>
                    <i class="fa-solid fa-file"></i>
                  </button>
                  <!-- Show tick if prescription is sent -->
                  <button class="action1" v-else >
                    <span class="tooltip-text">Prescription send successfully</span>
                    <i class="fa fa-check-circle text-success"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div v-if="isModalOpen" class="modal-backdrop">
  <div class="modal-content">
    <button class="close-icon" @click="isModalOpen = false">
      <i class="fas fa-times"></i>
    </button>
    <h3 class="center">Send Prescription</h3>
    <form @submit.prevent="submitPrescription">
      <div class="form-group">
        <label for="prescriptionFile">Upload Prescription File:</label>
        <input
          type="file"
          id="prescriptionFile"
          @change="handleFileUpload"
          class="form-control"
          accept=".pdf, .jpg, .png" 
        />
      </div>
      <div class="button-group">
        <button type="submit" class="btn btn-add">Submit</button>
        <button type="reset" class="btn btn-add-secondary" @click="resetForm">Reset</button>
      </div>
    </form>
  </div>
</div>
    </div>
  </div>
</template>

<script>
import DoctorSidebar from "../../layoutComponents/DoctorSidebar.vue";
import Navbar from "../../layoutComponents/NavBar.vue";
import axios from "axios";
import { ref, computed, onMounted } from "vue";
import Swal from "sweetalert2";
import { useRoute } from "vue-router";

export default {
  name: "MyAppointment",
  components: {
    DoctorSidebar,
    Navbar
  },
  setup() {
    const appointments = ref([]);
    const filteredAppointmentsByDoctor = ref([]);
    const searchQuery = ref("");
    const prescriptionText = ref("");
    const prescriptionFile = ref(null);
    const selectedAppointmentId = ref(null);
    const isModalOpen = ref(false); // Modal visibility flag
    const route = useRoute();

    const fetchAppointments = async () => {
      const doctorId = localStorage.getItem("doctor_id");
      try {
        const response = await axios.post(`/appointments`);
        appointments.value = response.data.map((appointment) => ({
          ...appointment,
          prescriptionSent: !!appointment.prescription, // Track if prescription is already sent
        }));
        filteredAppointmentsByDoctor.value = appointments.value.filter(appointment => 
      appointment.schedule && appointment.schedule.doctor_id === Number(doctorId) // Ensure schedule exists
    );
      } catch (error) {
        console.error("Error fetching appointments:", error);
      }
    };

    const openPrescriptionModal = (appointment) => {
      selectedAppointmentId.value = appointment.id;
      prescriptionText.value = "";
      prescriptionFile.value = null;
      isModalOpen.value = true;
    };

    const closeModal = () => {
      isModalOpen.value = false; // Close modal
    };

    const handleFileUpload = (event) => {
      prescriptionFile.value = event.target.files[0];
    };

    const submitPrescription = async () => {
  if (!prescriptionFile.value) {
    Swal.fire("Error", "File is required.", "error");
    return; // Exit the function if no file is uploaded
  }

  // Get the appointment date
  const appointment = appointments.value.find(app => app.id === selectedAppointmentId.value);
  if (appointment) {
    const appointmentDate = new Date(appointment.schedule.date); // Assuming `schedule.date` contains the appointment date
    const currentDate = new Date();

    // Check if the appointment date is in the past
    if (appointmentDate < currentDate) {
      Swal.fire("Error", "Cannot send prescription for past appointments.", "error");
      return; // Exit the function if the appointment date is in the past
    }
  }

      const formData = new FormData();
      if (prescriptionFile.value) {
        formData.append("prescription", prescriptionFile.value);
      }
      try {
        // Send the prescription via API
        await axios.post(`/appointments/${selectedAppointmentId.value}/prescription`, formData);
        Swal.fire("Success", "Prescription sent successfully", "success");
        closeModal();
        // Update the appointment's prescriptionSent status after sending
        const appointmentIndex = appointments.value.findIndex(
          (appointment) => appointment.id === selectedAppointmentId.value
        );
        if (appointmentIndex !== -1) {
          appointments.value[appointmentIndex].prescriptionSent = true;
        }
      } catch (error) {
    // Check if the error is due to validation
    if (error.response && error.response.status === 422) {
      const errors = error.response.data.errors;
      // Extract error messages
      const errorMessages = Object.values(errors).flat().join(', '); // Join multiple errors into a single string
      Swal.fire("Error", errorMessages || "Failed to send prescription", "error");
    } else {
      Swal.fire("Error", "Failed to send prescription", "error");
    }
  }
};

    onMounted(() => {
      fetchAppointments();
    });

    onMounted(() => {
      fetchAppointments();

      // Populate search query from URL if schedule or token is present
      const scheduleQuery = route.query.schedule ? route.query.schedule : "";
      const tokenQuery = route.query.token ? route.query.token : "";
      searchQuery.value = `${scheduleQuery} ${tokenQuery}`.trim(); // Combine schedule and token
    });

    // Computed property to search through the filtered appointments (by doctor ID)
    const filteredAppointments = computed(() => {
      if (!searchQuery.value) {
        return filteredAppointmentsByDoctor.value; // Return all appointments if no search query
      }

      // Split the search query into terms
      const queryTerms = searchQuery.value.toLowerCase().split(' ');

      return filteredAppointmentsByDoctor.value.filter(appointment => {
        // Check if the appointment matches any of the query terms
        const scheduleMatch = queryTerms.some(term =>
          appointment.schedule.schedule_title.toLowerCase().includes(term)
        );
        const tokenMatch = queryTerms.some(term =>
          appointment.token.toString() === term // Exact match for token
        );

        return scheduleMatch && tokenMatch; // Both conditions must be true
      });
    });

    return {
      filteredAppointments,
      searchQuery,
      openPrescriptionModal,
      closeModal,
      handleFileUpload,
      submitPrescription,
      isModalOpen,
      prescriptionText,
    };
  },
};
</script>

<style scoped>
@import "/public/assets/css/view.css";
/* Custom modal styling */
.custom-modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999;
}

.custom-modal {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  width: 400px;
  position: relative;
}

.custom-modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.custom-modal-body {
  margin-bottom: 20px;
}

.custom-modal-footer {
  display: flex;
  justify-content: flex-end;
}

.close-btn {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
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
.action1:hover .tooltip-text {
  visibility: visible;
  opacity: 1;
}
.action1 {
  position: relative;
}

</style>
