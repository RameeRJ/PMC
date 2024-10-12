<template>
  <Navbar />
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-lg-2 bg-light vh-100 p-0">
        <PatientSidebar />
      </div>
      <div class="col-md-9 col-lg-10 p-4">
        <h2 class="mb-4">Account Settings</h2>
        <div class="settings-option" @click="openProfileModal">
          <h5 class="text">View your profile</h5>
          <p>View your Account Details</p>
        </div>
        <div class="settings-option" @click="openEditProfileModal">
          <h5 class="text">Edit your profile</h5>
          <p>Edit your Account Details & Upload Profile picture</p>
        </div>
        <div class="settings-option delete-option">
          <h5 class="text-danger">Delete Account</h5>
          <p>Will Permanently Remove Your Account</p>
        </div>
      </div>
      <div v-if="EditProfileModel" class="modal-backdrop">
        <div class="modal-content">
          <button class="close-icon" @click="EditProfileModel = false">
            <i class="fas fa-times"></i>
          </button>
          <h3 class="center">Edit your profile</h3>
          <form @submit.prevent="editProfile">
            <div class="profile-pic-container">
            <img
              :src="previewImage || '/storage/assets/images/default.jpg'"
              alt="Profile Preview"
              class="profile-preview"
            />
          </div>
            <div class="form-group">
              <label for="name">Name</label>
              <input
                type="text"
                class="form-control"
                id="name"
                v-model="formData.name"
                required
              />
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input
                type="email"
                class="form-control"
                id="email"
                v-model="formData.email"
                required
              />
            </div>
            <div class="form-group">
              <label for="Phone">Phone</label>
              <input
                type="Phone"
                class="form-control"
                id="Phone"
                v-model="formData.phone"
                required
              />
            </div>
            <div class="form-group">
              <label for="profilePicture">Profile Picture</label>
              <input
                type="file"
                class="form-control"
                id="profilePicture"
                accept="image/*"
                @change="onFileChange"
              />
            </div>
            <div class="button-group">
              <button type="submit" class="btn btn-add">Submit</button>
              <button type="reset" class="btn btn-add-secondary" @click="resetForm">Reset</button>
            </div>
          </form>
        </div>
      </div>
      <div v-if="ViewProfileModel" class="modal-backdrop">
  <div class="modal-content">
    <button class="close-icon" @click="ViewProfileModel = false">
      <i class="fas fa-times"></i>
    </button>
    <h3 class="center"> View Profile</h3>
    <div class="profile-pic-container">
      <img
        :src="previewImage || '/storage/assets/images/default.jpg'"
        alt="Profile Preview"
        class="profile-preview"
      />
    </div>
    <div class="form-group text-center">
      <p class="data">{{ formData.name }}</p>
    </div>
    <div class="form-group text-center">
      <p class="data">{{ formData.email }}</p>
    </div>
    <div class="form-group text-center">
      <p class="data">{{ formData.phone }}</p>
    </div>
    <!-- Add more fields as needed -->
  </div>
</div>



    </div>
  </div>
</template>
<script>

import PatientSidebar from "../../layoutComponents/PatientSidebar.vue";
import Navbar from "../../layoutComponents/NavBar.vue";
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from "sweetalert2";

export default {
  name: "Settings",
  components: {
    PatientSidebar,
    Navbar,
  },
  setup() {
    const EditProfileModel = ref(false);
    const ViewProfileModel = ref(false);
    const formData = ref({
      name: '',
      email: '',
      phone: '',
      profile_pic: null,
    });
    const previewImage = ref(''); // Preview image variable
    const error = ref(null);

    // Function to fetch user details
    const fetchUserDetails = async () => {
      try {
        const response = await axios.post('/patient/user-details');
        formData.value.name = response.data.name;
        formData.value.email = response.data.email;
        formData.value.phone = response.data.phone;

        // Set profile picture if exists
        formData.value.profile_pic = response.data.profile_pic;
        previewImage.value = response.data.profile_pic 
          ? `/storage/${response.data.profile_pic}` 
          : '/storage/assets/images/default.jpg';
      } catch (error) {
        console.error('Error fetching user details:', error);
      }
    };

    // Function to open the edit profile modal and prefill data
    const openEditProfileModal = () => {
      EditProfileModel.value = true;
      fetchUserDetails(); // Prefill form with user details
    };

   const  openProfileModal = () => {
      ViewProfileModel.value = true;
      fetchUserDetails();
    }

    const onFileChange = (event) => {
      const file = event.target.files[0];
      formData.value.profile_pic = file;

      // Show a preview of the selected image
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          previewImage.value = e.target.result; // Set the preview image
        };
        reader.readAsDataURL(file); // Read the image file as Data URL
      }
    };

    const editProfile = async () => {
      try {
        const formDataObj = new FormData();
        formDataObj.append('name', formData.value.name);
        formDataObj.append('email', formData.value.email);
        formDataObj.append('phone', formData.value.phone);

        if (formData.value.profile_pic) {
          formDataObj.append('profile_pic', formData.value.profile_pic);
        }

        const response = await axios.post('/patient/update-profile', formDataObj, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });

        console.log(response.data.message); // Display success message
        EditProfileModel.value = false; // Close the modal after submission
        Swal.fire({
          icon: 'success',
          title: 'Profile Edited successfully',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2000,
        });
      } catch (error) {
        console.error('Error updating profile:', error);
        Swal.fire({
          icon: 'error',
          title: 'Editing  Profile Failed',

          text: error.response?.data?.message || 'An error occurred. Please try again.',
        });
      }
    };

    const resetForm = () => {
      formData.value = {
        name: '',
        email: '',
        phone: '',
        profilePicture: null,
      };
      previewImage.value = ''; // Reset the image preview
    };

    return {
      EditProfileModel,
      ViewProfileModel,
      formData,
      previewImage,
      onFileChange,
      editProfile,
      resetForm,
      openEditProfileModal,
      openProfileModal,
      error,
    };
  },
};

</script>

<style scoped>
@import "/public/assets/css/view.css";
.settings-option {
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  padding: 20px;
  margin-bottom: 20px;
  background-color: #f9f9f9;
  transition: box-shadow 0.3s;
}

.settings-option:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.delete-option {
  border-color: #f44336; /* Red for delete option */
}

.text{
  color: #c86373; /* Bootstrap primary color */
}

.text-danger {
  color: #ea0017; /* Bootstrap danger color */
}
.profile-pic-container {
    margin-bottom: 20px;
  }
  
  .profile-preview {
    display: block;
    width: 150px;
    height: 150px;
    border-radius: 21%;
    object-fit: cover;
    margin: auto;
    padding: 14px;
    margin-top: 24px;
  }
  .data{
    font-size: 20px;
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  }
</style>
