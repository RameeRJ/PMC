<template>
    <div class="about-contact-container">
      <!-- About Us Section -->
      <section class="about-section">
        <h2>About Us</h2>
        <p>
          Welcome to Pathambad Medical Center (PMC), where we strive to provide the best medical services.
          Our team of experienced doctors and healthcare professionals is committed to delivering
          quality care to all patients. Whether it's a routine check-up or specialized treatment,
          we're here to help you every step of the way.
        </p>
        <p>
          Our vision is to become a leading healthcare provider, known for its excellent patient care
          and cutting-edge medical services. At PMC, you are our priority, and we aim to give you a
          healthy and happy life.
        </p>
      </section>
  
      <!-- Contact Us Section -->
      <section class="contact-section">
        <h2>Contact Us</h2>
        <p>If you have any questions or would like to schedule an appointment, feel free to reach out to us!</p>
  
        <form>
          <div class="form-group">
            <label for="name">Your Name</label>
            <input type="text" placeholder="Enter your name" required />
          </div>
  
          <div class="form-group">
            <label for="email">Your Email</label>
            <input type="email"  placeholder="Enter your email" required />
          </div>
  
          <div class="form-group">
            <label for="message">Your Message</label>
            <textarea  placeholder="Enter your message" required></textarea>
          </div>
  
          <button type="submit" class="btn-submit">Send Message</button>
        </form>
      </section>
    </div>
  </template>

<style scoped>
body {
  margin: 0;
  font-family: 'Arial', sans-serif;
  background-color: #8b1e3f; /* Adjusted maroon color */
}

.full-height {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background-image: url('/path-to-background-image'); /* Use if you have a background image */
  background-size: cover;
  background-position: center;
  background-color: #8b1e3f; /* Fallback maroon color */
}

.edoc-logo {
  font-size: 2.5em;
  font-weight: bold;
  color: #fff;
}

.edoc-logo-sub {
  font-size: 1.5em;
  color: #fff;
}

.nav-item {
  font-size: 1.1em;
  color: #fff;
  text-transform: uppercase;
  cursor: pointer;
}

.nav-item:hover {
  color: #d9d9d9; /* A slight hover effect */
}

.heading-text {
  font-size: 3.5em;
  color: #fff;
  font-weight: bold;
}

.sub-text2 {
  font-size: 1.2em;
  color: #d9d9d9;
}

@media (max-width: 768px) {
  .heading-text {
    font-size: 2.5em;
  }

  .sub-text2 {
    font-size: 1em;
  }

  .edoc-logo-sub {
    display: block; /* Puts the subtitle below the main logo on small screens */
    font-size: 1.2em;
  }
}

</style>