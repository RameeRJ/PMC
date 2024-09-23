<template>
    
    <div class="navbar">
      <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link to="/Home" class="nav-link active d-flex flex-column text-center" aria-current="page" ><i class="fas fa-home fa-lg"></i><span class="small">Home</span></router-link>
          </li>
          <li class="nav-item">
            <router-link to="/Login" class="nav-link active d-flex flex-column text-center" aria-current="page"><i class="fas fa-home fa-lg"></i><span class="small">Login</span></router-link>
          </li>
          <li class="nav-item">
            <router-link to="/SignUp" class="nav-link active d-flex flex-column text-center" aria-current="page" ><i class="fas fa-home fa-lg"></i><span class="small">Register</span></router-link >
          </li>
        </ul>
            
      </nav>
    </div>
</template>


<script>
export default{
    name: 'NavBar',
}

</script>

<style >

 


</style>
