  </div><!-- end page-body -->
  <div class="panel-footer">
    &copy; <?php echo date('Y'); ?> Crime Record Management System
  </div>
</div><!-- end main-content -->

<script>
function toggleDropdown(){
  var d = document.getElementById('adminDropdown');
  d.classList.toggle('show');
}
document.addEventListener('click',function(e){
  var d = document.getElementById('adminDropdown');
  if(d && !e.target.closest('.user-info') && !e.target.closest('#adminDropdown')){
    d.classList.remove('show');
  }
});

// Sidebar submenu toggle
document.querySelectorAll('.sidebar .has-sub > a').forEach(function(link){
  link.addEventListener('click',function(e){
    e.preventDefault();
    var li = this.parentElement;
    var isOpen = li.classList.contains('open');
    document.querySelectorAll('.sidebar .has-sub').forEach(function(el){ el.classList.remove('open'); });
    if(!isOpen) li.classList.add('open');
  });
});

// Auto dismiss alerts
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
