  </div><!-- end page-body -->
  <div class="panel-footer">
    &copy; <?php echo date('Y'); ?> Crime Record Management System 
  </div>
</div><!-- end main-content -->

<script>
function toggleUserDropdown(){
  var d=document.getElementById('userDropdown');
  d.classList.toggle('show');
}
document.addEventListener('click',function(e){
  var d=document.getElementById('userDropdown');
  if(d && !e.target.closest('.user-info') && !e.target.closest('#userDropdown')){
    d.classList.remove('show');
  }
});
setTimeout(function(){
  document.querySelectorAll('.alert').forEach(function(a){
    a.style.transition='opacity 0.5s';
    a.style.opacity='0';
    setTimeout(function(){ a.remove(); },500);
  });
},4000);
</script>
</body>
</html>
