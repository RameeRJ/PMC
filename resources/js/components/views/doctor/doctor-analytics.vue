<template>
    <Navbar />
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 col-lg-2 bg-light vh-100 p-0">
          <DoctorSidebar />
        </div>
        <div class="col-md-9 col-lg-10 p-4">
          <h2>Appointments Analytics</h2>
          <div class="chart-container">
            <canvas id="appointmentsChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from "vue";
  import axios from "axios";
  import Chart from "chart.js/auto";
  import DoctorSidebar from "../../layoutComponents/DoctorSidebar.vue";
  import Navbar from "../../layoutComponents/NavBar.vue";
  
  export default {
    name: "Analytics",
    components: {
      DoctorSidebar,
      Navbar,
    },
    setup() {
      const schedules = ref([]);
  
      const fetchAppointmentsBySchedule = async () => {
        const doctorId = localStorage.getItem("doctor_id");
        try {
          const response = await axios.post(`/appointments-by-schedule/${doctorId}`);
          schedules.value = response.data;
  
          // After fetching the data, create the chart
          createChart();
        } catch (error) {
          console.error("Error fetching analytics:", error);
        }
      };
  
      const createChart = () => {
  const ctx = document.getElementById("appointmentsChart").getContext("2d");

  const scheduleTitles = schedules.value.map(schedule => schedule.schedule_title);
  const appointmentCounts = schedules.value.map(schedule => schedule.appointments_count);

  new Chart(ctx, {
    type: "bar", // Change to "line" or any other chart type if needed
    data: {
      labels: scheduleTitles, // X-axis labels (schedule titles)
      datasets: [
        {
          label: "Number of Appointments",
          data: appointmentCounts, // Y-axis data (appointment counts)
          backgroundColor: [
            "rgba(255, 99, 132, 0.2)",
          
          ], // Add different colors for each bar
          borderColor: [
            "rgba(255, 99, 132, 1)",
        
          ], // Add matching border colors for each bar
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        y: {
            
          beginAtZero: true,
          min: 0,
          stepSize: 1,
           max: Math.max(...appointmentCounts) + 5,
          title: {
            display: true,
            text: 'Number of Appointments',
            font: {
              size: 14,
              weight: 'bold',
              family: 'Arial', // Customize font
              color: '#333', // Customize font color
            }
          }
        },
        x: {
          title: {
            display: true,
            text: 'Schedules',
            font: {
              size: 14,
              weight: 'bold',
              family: 'Arial', // Customize font
              color: '#333', // Customize font color
            }
          }
        }
      },
      responsive: true,
      plugins: {
        legend: {
          display: false, // Hide the legend
        },
      },
    },
  });
};

  
      onMounted(fetchAppointmentsBySchedule);
  
      return {
        schedules,
      };
    },
  };
  </script>
  
  <style scoped>
.chart-container {
  width: 100%;
  height: 400px;
  margin-top: 20px;
  background-color: #f8f9fa; /* Light background color for the chart container */
  border: 1px solid #ddd; /* Border around the chart */
  border-radius: 8px; /* Rounded corners */
  padding: 20px; /* Add padding around the chart */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow for depth */
}

h2 {
  color: #000000; /* Blue color for the heading */
  font-size: 30px; /* Larger font size for the heading */
  margin-bottom: 20px;
  text-align: center;
}

.container-fluid {
  background-color: #f4f4f9; /* Light background for the entire container */
}

.bg-light {
  background-color: #f8f9fa !important; /* Light background for sidebar */
}

.col-md-9 {
  background-color: #fff; /* White background for main content */
  border-left: 1px solid #ddd; /* Separation border between sidebar and content */
  padding: 30px; /* Padding around main content */
}

button {
  background-color: #007bff; /* Primary blue color for buttons */
  color: #fff; /* White text for buttons */
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3; /* Darker blue on hover */
}

</style>
