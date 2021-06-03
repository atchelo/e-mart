<template>
  <div class="row no-pad"> 
        <div v-for="(i,index) in 10" :key="index" class="mt-1 col-6">
            <b-skeleton-img></b-skeleton-img>
            <b-skeleton class="mt-1" animation="throb" height="10px" width="60%"></b-skeleton> <!-- productnmae-->
            <b-skeleton animation="throb" height="8px" width="20%"></b-skeleton> <!-- no rating -->
            <b-skeleton animation="throb" height="9px" width="30%"></b-skeleton> <!-- price -->
        </div>
  </div>
</template>

<script>
export default {

}
</script>