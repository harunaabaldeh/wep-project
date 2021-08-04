
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Avoid form resubmission -->
<script>
  if ( window.history.replaceState ) 
    {
      window.history.replaceState( null, null, window.location.href );
    }
    function submitBookmark(status, id){
    document.getElementById("status").value = status
    document.getElementById("business_id").value = id
    document.getElementById("bookmarkForm").submit();
    }

</script>
