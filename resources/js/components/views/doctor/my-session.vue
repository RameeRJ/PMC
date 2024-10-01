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
            <h2>All Sessions ({{  }})</h2>
            <button class="add btn-responsive" @click="showAddSessionModal = true">
              <i class="fas fa-plus"></i> Add Session
            </button>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Session Title</th>
                <th>Date</th>
                <th>Time</th>
                <th>Maximum No.of Booking</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="session in doctors" :key="session.id">
                <td>{{ session.name }}</td>
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
        </div>
        </template>
        <script>
        import DoctorSidebar from "../../layoutComponents/DoctorSidebar.vue";
        import Navbar from "../../layoutComponents/NavBar.vue";
        
        export default {
          name: "MySession",
          components: {
            DoctorSidebar,
            Navbar,
          },
        }

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