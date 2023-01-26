<!DOCTYPE html>
<html lang="en">

<head>
  <?php 
    include('head.php');
  ?>
  
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="index.html">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- department Card -->
            <div class="col-xxl-6 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Department</h5>
                  <div class="d-flex align-items-center">
                  <div class="col-sm-12">
                    <select class="form-select" id="department" aria-label="Default select example">
                    </select>
                  </div>
                  </div>
                </div>

              </div>
            </div><!-- End department Card -->

            <!-- icd 10 Card -->
            <div class="col-xxl-6 col-md-6">
              <div class="card info-card revenue-card">
              <div class="card-body">
                  <h5 class="card-title">ICD 10</h5>
                  <div class="d-flex align-items-center">
                  <div class="col-sm-12">
                    <select class="form-select" id="icd10" >
                      
                    </select>
                  </div>
                  </div>
                </div>
              </div>
            </div><!-- End icd 10 Card -->

            <!-- icd9 Sales -->
            <div class="col-12" >
              <div class="card recent-sales overflow-auto"  id="icd9_card" style="display:none">

                <div class="card-body">
                  <h5 class="card-title">ICD 9 </h5>

                  <table class="table table-borderless datatables" >
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Code</th>
                      <th scope="col">Department</th>
                      </tr>
                  </thead>
                   <tbody id="table_icd9">

                   </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->
          </div>
        </div><!-- End Left side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- jQuery -->


  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>


  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>

  $( document ).ready(function(){

  $('.form-select').select2();

  $("#icd10").select2({
      ajax: { 
          url: "icd10.php",
          type: "post",
          dataType:'json',
          delay: 250,
          data: function (params) {
            return { searchTerm: params.term}
            //console.log(query);
          },
          // success: function (data) {
          //     console.log(data);
          //     $('#icd10').html(data);
          // }
          // ,
        processResults: function (response) {
          //console.log(response)
            return {
                results: response
          };
        },
      cache: true
    }
      // Query parameters will be ?search=[term]&type=public
  })


  

  $("#department").select2({
      ajax: { 
          url: "department.php",
          type: "post",
          dataType:'json',
          delay: 250,
          data: function (params) {
            return { searchTerm: params.term}
            //console.log(query);
          },
          processResults: function (response) {
            //console.log(response)
             return {
                 results: response
             };
         },
         cache: true
      }
      // Query parameters will be ?search=[term]&type=public
    })

    
    



  });


  
  

  $(document).on("change",".form-select",function() {
    var icd10 = document.getElementById("icd10").value;
    var department = document.getElementById("department").value;

    
    if (icd10 != "" && department != "") {
      $.ajax({
    	type: 'POST',
    	url: 'icd9.php',
      data: {
        icd10: icd10,
        department: department,
      },
    	success: function (data) {
        
        
        let timerInterval
        Swal.fire({
          title: 'กรุณารอสักครู่',
          html: 'ระบบกำลังดำเนินการ',
          timer: 2000,
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading()
            const b = Swal.getHtmlContainer().querySelector('b')
            timerInterval = setInterval(() => {
              b.textContent = (Swal.getTimerLeft()/1000)
              console.log(data);
              $('#table_icd9').html(data); 
              $('#table_icd9').load();
              $('.datatables').DataTable();
              $('#icd9_card').show();

              

              
            }, 1000)
          },
          willClose: () => {
            clearInterval(timerInterval)
          }
        }).then((result) => {
          /* Read more about handling dismissals below */
          if (result.dismiss === Swal.DismissReason.timer) {
            console.log('success');
          }
        })
        
        

    	},
    	error: function(error) {
           	console.log('Error: ' + error);
    	}
      });
    }
   
  
  });


  $(document).on('change', '#checkbox_icd9', function() {

    var icd10 = document.getElementById("icd10").value;
    var department = document.getElementById("department").value;
    var icd9 = this.value;
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
    if (this.checked == true) {
      $.ajax({
    	type: 'POST',
    	url: 'updatebase.php',
      data: {
        icd10: icd10,
        department: department,
        icd9: icd9,
        for: 1
      },
    	success: function (data) {
        if (data == 1) {
          Toast.fire({
            icon: 'success',
            title: 'บันทึกข้อมูลสำเร็จ'
          })
        }else{
          Toast.fire({
            icon: 'error',
            title: 'บันทึกข้อมูลไม่สำเร็จ'
          })
        }
    	},
    	error: function(error) {
           	console.log('Error: ' + error);
    	}
      });
      
    }else if(this.checked == false){
      $.ajax({
    	type: 'POST',
    	url: 'updatebase.php',
      data: {
        icd10: icd10,
        department: department,
        icd9: icd9,
        for: 0
      },
    	success: function (data) {
        if (data == 1) {
          Toast.fire({
            icon: 'success',
            title: 'ลบข้อมูลสำเร็จ'
          })
        }else{
          Toast.fire({
            icon: 'error',
            title: 'ลบข้อมูลไม่สำเร็จ'
          })
        }

    	},
    	error: function(error) {
          
           	console.log('Error: ' + error);
    	}
      });

    }
 
  });
  
  </script>

</body>

</html>