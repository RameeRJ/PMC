<template>
  <body>
  <div class="full-height">
    <center>
      <table border="0">
        <tr>
          <td width="80%">
            <router-link to="/about-contact" class="non-style-link">
              <font class="edoc-logo">PMC. </font>
              <font class="edoc-logo-sub">| PATHAMBAD MEDICAL CENTER</font>
            </router-link>
          </td>
          <td width="12%">
            <router-link to="/login" class="non-style-link">
              <p class="nav-item">LOGIN</p>
            </router-link>
          </td>
          <td width="10%">
            <router-link to="/signup" class="non-style-link">
              <p class="nav-item" style="padding-right: 10px;">REGISTER</p>
            </router-link>
          </td>
        </tr>

        <tr>
          <td colspan="3">
            <p class="heading-text">No More Delays.</p>
          </td>
        </tr>
        
        <tr>
          <td colspan="3">
            <p class="sub-text2">
              Skip the hassle and long waits!<br />
              Find your doctor online, book as you wish with PMC. <br />
              Enjoy free doctor appointment booking services. Schedule your visit today!
            </p>
          </td>
       
          <td colspan="3"></td>
        </tr>
      </table>
    </center>
  </div>
  </body>
</template>

<script>
export default {
  name: 'Home',
};
</script>

<style scoped>
@import "/public/assets/css/index.css";
@import "/public/assets/css/main.css";


</style>
