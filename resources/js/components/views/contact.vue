<template>
    <body>
      <div class="full-height">
        <center>
          <table border="0">
            <tr>
              <td width="80%" style="padding-top: 10px;">
                <router-link to="/" class="non-style-link">
                  <font class="edoc-logo">PMC. </font>
                  <font class="edoc-logo-sub">| Home</font>
                </router-link>
              </td>
              
            </tr>
  
            <tr>
              <td colspan="5">
                <p class="heading-text">Contact Us.</p>
              </td>
            </tr>
            
            <!-- Our Mission Section -->
            <tr>
              <td colspan="3">
                <p class="sub-text2">
        
                </p>
              
              </td>
            </tr>
          </table>
        </center>
      </div>
    </body>
  </template>
  
  <script>
  export default {
    name: 'about-contact',
  };
  </script>
  
  <style scoped>
  @import "/public/assets/css/index.css";
  @import "/public/assets/css/main.css";
  body{
      background-image:url("/public/assets/images/contact.jpg");
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover;
      height: 100%;
  }
  
  </style>