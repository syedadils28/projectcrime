  </div><!-- end page-body -->
  <div class="panel-footer">
    &copy; <?php echo date('Y'); ?> Crime Record Management System 
  </div>
</div><!-- end main-content -->
<script>
function togglePoliceDropdown(){
  document.getElementById('policeDropdown').classList.toggle('show');
}
document.addEventListener('click',function(e){
  var d=document.getElementById('policeDropdown');
  if(d&&!e.target.closest('.user-info')&&!e.target.closest('#policeDropdown')) d.classList.remove('show');
});
document.querySelectorAll('.sidebar .has-sub > a').forEach(function(l){
  l.addEventListener('click',function(e){
    e.preventDefault();
    var li=this.parentElement,open=li.classList.contains('open');
    document.querySelectorAll('.sidebar .has-sub').forEach(function(x){ x.classList.remove('open'); });
    if(!open) li.classList.add('open');
  });
});
setTimeout(function(){
  document.querySelectorAll('.alert').forEach(function(a){
    a.style.transition='opacity 0.5s'; a.style.opacity='0';
    setTimeout(function(){ a.remove(); },500);
  });
},4000);
</script>
</body>
</html>
