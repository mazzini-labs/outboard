<style>
:root {
  --menu-speed: 0.75s;
}
/* blurs background for viewing entries */
/*
.modal-open > .navbar,
.modal-open > .limiter {
     filter: blur(8px);
}
.table-vitals {
     color: #fff;
     font-size: 1.5rem!important;
} 
*/


.slide-label {
    display: block;
    background: lightgrey;
    width: 100px;
    height: 100px;
}
.wrapper {
    position: relative;
    overflow: hidden;
    width: 100px;
    height: 100px; 
    border: 1px solid black;
}

#slide:checked + .slide-label {
    position: absolute;
    right: -100px;
    width: 100px;
    height: 100px;
    background: blue;
    transition: 1s;
}

.menu-wrap {
  position: fixed;
  /* top: 50vh; */
  /* right: 46vw; */
  top: 0vh;
  right: 43vw;
  z-index: 1;
}
.menu-wrap .toggler {
  position: absolute;
  /* top: 0;
  left: 0; */
  top: 50vh;
  left: -3vw;
  opacity: 0;
  height: 50px;
  width: 50px;
  cursor: pointer;
  z-index: 2;
}
.menu-wrap .r-tooltip > h2 {
  position: absolute;
  /* top: 0;
  left: 0; */
  top: 50vh;
  /* left: -3vw; */
  /* opacity: 0; */
  /* height: 50px;
  width: 50px;
  cursor: pointer;
  z-index: 2; */
}
.menu-wrap .hamburger {
  position: absolute;
  top: 0;
  /* left: 0; */
  right: -1vh;
  /* height: 60px;
  width: 60px; */
  height: 100vh;
  width: 65px;
  /* background: transparent; */
  background: rgba(0,0,0,0.5);
  padding: 1rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  z-index: 1;
}

.menu-wrap .toggler:checked + .hamburger {
     background-color: #343a40;
     transition: 0.4s;
}
.menu-wrap .toggler:checked + .hamburger > h2 > svg {
     stroke: #59ffff;
     transition: 0.4s;
}

.menu-wrap .toggler:hover + .hamburger {
     background-color: #343a40;
     /* opacity: 0.5; */
     transition: 0.4s;
}
.menu-wrap .toggler:hover + .hamburger > h2 > svg {
     stroke: rgba(89, 255, 255, 0.75);
     transition: 0.4s;
}

/* Hamburger line */
.menu-wrap .hamburger > div {
  position: relative;
  top: 0;
  left: 0;
  width: 100%;
  height: 2px;
  /* background: #fafafa; */
  flex: none;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: 0.4s;

  
}

/* Hamburger top & bottom line */
.menu-wrap .hamburger > div:before,
.menu-wrap .hamburger > div:after {
  content: "";
  position: absolute;
  top: 10px;
  left: 0;
  background: inherit;
  height: 2px;
  width: 100%;
  z-index: 1;
}
.menu-wrap .hamburger > div:after {
  top: -10px;
  /* background: #fafafa; */
}

/* Toggler Animation */
.menu-wrap .toggler:checked + .hamburger > div {
  transform: rotate(135deg);
}
.menu-wrap .toggler:checked + .hamburger > div:before,
.menu-wrap .toggler:checked + .hamburger > div:after {
  top: 0;
  transform: rotate(90deg);
}

/* Text next to hamburger */
.menu-wrap .hamburger > h2 {
     position: inherit;
     color: #fafafa;
     /* right: 3vw; */
}
/* Rotate on hover when checked */
.menu-wrap .toggler:checked:hover + .hamburger > div {
  transform: rotate(225deg);
}
.menu {
  position: fixed;
  top: 0;
  right: 45vw;
  /* background: #f8f9fa; */
  background: rgba(0,0,0,0.5);
  height: 100vh;
  width: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  opacity: 0;
  transition: all var(--menu-speed) ease;
}
.menu > div {
  position: relative;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  flex: none;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  opacity: 0;
  transition: opacity 0.4s ease-in;
}
.menu ul {
  list-style: none;
}
.menu li {
  padding: 1rem 0;
}
.menu > div a {
  text-decoration: none;
  color: #fafafa;
  font-size: 1.5rem;
  opacity: 0;
  transition: opacity 1s ease-in;
}
.menu a:hover {
  color: rgb(230, 177, 177);
  transition: color 0.3s ease-in;
}

/* Show Menu */
.menu-wrap .toggler:checked ~ .menu {
  opacity: 1;
  width: 54vw;
  transition: all var(--menu-speed) ease;
}
.menu-wrap .toggler:checked ~ .menu > div {
  opacity: 1;
  transition: opacity 0.4s ease-in;
}
.menu-wrap .toggler:checked ~ .menu > div table {
  opacity: 1;
  transition: opacity 1s ease-in;
}

@media (max-width: 500px) {
  header {
    background: url("./bg-img.jpg") no-repeat 40% center / cover;
  }
  .menu-wrap .toggler:checked ~ .menu {
    width: 65vw;
  }
}

.menu-opaque { 
     /* background-color: #f8f9fa!important; */
     /* opacity: 0.75!important; */
     background: rgba(0,0,0,0.5)!important;
 }

.feather-lb { white-space: normal; 
     text-align: left!important;
/* display: block; */
}
.break { display: block; 
/* white-space: normal;  */
text-align: center;
}
</style>
<!-- Edit DDR Entry Modal -->

<div id="dataModal" class="modal show fade" tabindex="-1" data-focus-on="input:first">
     <div id="ddr_detail">  
<!--  -->
     <!-- <section class="drawer" id="add_data_Modal" data-drawer-target>
    <div class="drawer__overlay" data-drawer-close tabindex="-1"></div>
    <div class="drawer__wrapper">
        <div class="drawer__header">
        <div class="drawer__title">
            Well Entry
        </div>
        <button class="drawer__close" data-drawer-close aria-label="Close Drawer"></button>
    </div>
    <div class="drawer__content">
         TEST 
         </div>
  </div>
</section> -->
<?php if(isset($_REQUEST["testing"])) { ?>
     <button class="btn" data-toggle="modal" href="#editsModal">Launch modal</button>
     <button class="btn" data-toggle="modal" href="#vitalsModal">Launch modal</button>
     <div id="editsModal" class="modal show fade modal-lg">
          <div class="modal-dialog-edits modal-content" >  
               <div class="" id="edit_history" style="height:100vh!important;">
               <div class="modal-header">  
                                   <h4 class="modal-title">Edit History</h4>  
                                   <button type="button" class="close edits-drawer-close" id="edit-close" name="edit-close"><i data-feather="x"></i></button>
                                   </div>    
                WE ARE HERE!
               </div>  
          </div>
     </div>    
     <div id="vitalsModal" class="modal show fade">
          <div class="modal-dialog-edits modal-lg" >  
               <div class="modal-content" id="edit_history" style="height:100vh!important;">
               <div class="modal-header">  
                                   <h4 class="modal-title">Edit History</h4>  
                                   <button type="button" class="close edits-drawer-close" id="edit-close" name="edit-close"><i data-feather="x"></i></button>
                                   </div>    
                WE ARE HERE!
               </div>  
          </div>
     </div>
<?php } ?>
     <!-- <input type="checkbox" id="slide"/>
     <label class="slide-label" for="slide">I'm a square. Click me.</label>
     <div class="wrapper">
          <img id="sldide" src="http://lorempixel.com/output/cats-q-c-100-100-4.jpg" />
     </div>   
     
     <input id="hamburger" class="hamburger" type="checkbox" />
          <label for="hamburger" class="hamburger">
     <i></i>
     <text>
          <close>close</close>
          <open>menu</open>
     </text>
     </label> -->
     <!-- <div class="modal-dialog modal-lg" >  
          <div class="modal-content" id="ddr_detail_orig" style="height:90vh!important;">  
          </div>  
     </div> 
     <div class="menu-wrap">
          <input type="checkbox" class="toggler">
          <div class="hamburger"><div></div></div>
          <div class="menu" >
          <div class="card">
               <div class="card-body" id="extra_detail" style="width: inherit;">
                    <h5 class="card-title">Card title</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    
                    <div class="row justify-content-center">
                         <h5 class="btn btn-primary card-link" data-toggle="collapse" href="#viewVitalsCollapse" role="button" aria-expanded="false" aria-controls="viewVitalsCollapse">
                         Vitals from this entry
                         </h5>
                         <h5 class="btn btn-danger btn-lg btn-block" data-toggle="collapse" href="#viewEditsCollapse" role="button" aria-expanded="false" aria-controls="viewEditsCollapse">
                              <i data-feather="x" style="color: white; height: 1.5em!important; width: 1.5em!important; "></i> View Vitals 
                         </h5>
                    </div>
                    <div class="collapse" id="viewVitalsCollapse">
                         <div class="table-responsive" >
                              <table class="table">
                                   <tr>
                                   </tr>
                                   <tr>  
                                        <td><label>Fluid Level:</label></td>  
                                        <td>'.$fl.'</td>  
                                   </tr>
                                   <tr>  
                                        <td width="40%"><label>Flowing Tubing Pressure:</label></td>  
                                        <td width="60%">'.$ftp.'</td>  
                                   </tr>
                                   <tr>  
                                        <td width="40%"><label>Flowing Casing Pressure:</label></td>  
                                        <td width="60%">'.$fcp.'</td>  
                                   </tr>
                                   <tr>  
                                        <td width="40%"><label></label></td>  
                                        <td width="60%"></td>
                                   <tr>
                              </table>  
                         </div>
                    </div>
               </div>
          
          </div>
     </div>
     </div> -->
     <?php if(!isset($_REQUEST["testing"])) { ?>
     
     <!-- <nav class="primnav">
          <ul class="" id="">
               <li>
                    <a id="edit-drawer-btn" class="mx-auto p-1 justify-content-center edit-drawer" href="#edit">
                    <i class="fas fa-table fa-3x" style="color:#343a40;"></i> 
                    
                    </a>
               </li>
               <div class="w-100"><br></div>
               <li>
                    <a id="vitals-drawer-btn" class="mx-auto justify-content-center vitals-drawer" href="#vitals">
                    <i class="fas fa-tachometer-alt fa-3x" style="color:#343a40;"></i> 
                    </a>
               </li>
          </ul>
     </nav> -->
     
     <div id="vitals-drawer" class="drawer">
          <!-- Vitals content -->
          <div class="drawer-content">
               <!-- <div class="drawer-dialog modal-lg" >   -->
                    <div class="drawer-content" id="vitals_detail">
                    <span class="vitals-drawer-close drawer-close"><i data-feather="x" style="height:28px; width:28px;vertical-align:middle;"></i></span>
                         <div class="drawer-header">  
                              <h4 class="modal-title">Vitals Entry Details</h4>   
                         </div>    
                    </div>  
                    </div>  
               <!-- </div> -->
          </div>
     <div id="edit-drawer" class="drawer">
          <!-- Edit content -->
          <div class="drawer-content">
               <!-- <div class="modal-dialog modal-lg" >   -->
                    <div class="drawer-content" id="edit_detail">
                    <span class="edit-drawer-close drawer-close"><i data-feather="x" style="height:28px; width:28px;vertical-align:middle;padding-right:2px;"></i></span>
                         <div class="drawer-header">  
                              <h4 class="modal-title">Edit Entry Details</h4>  
                              <button type="button" class="close drawer-close" data-dismiss="modal"><i data-feather="x"></i></button> 
                         </div>      
                    </div>  
               </div>  
          <!-- </div> -->
     </div>
     <?php } ?>
      
<!-- </div> -->
     </div>
 </div>
<!-- Edit DDR Entry Modal -->