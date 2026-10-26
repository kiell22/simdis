    </div><!-- /.container-fluid -->
  </div><!-- /.content -->
</div><!-- /.content-wrapper -->

<footer class="main-footer py-2">
  <div class="float-right d-none d-sm-inline text-muted small">
    SIMDIS v1.0
  </div>
  <span class="text-muted small">
    &copy; <?= date('Y') ?> <strong>Dinas Pendidikan Provinsi Papua</strong>
  </span>
</footer>

</div><!-- ./wrapper -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
$(document).ready(function() {
  if ($('.datatable').length) {
    $('.datatable').each(function() {
      if ($.fn.DataTable.isDataTable(this)) return;
      var $tbl = $(this);
      var columnDefs = [];
      $tbl.find('thead tr th').each(function(i) {
        if ($(this).data('orderable') === false) {
          columnDefs.push({ orderable: false, targets: i });
        }
      });
      $tbl.DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
        pageLength: 10,
        columnDefs: columnDefs,
        dom: '<"row align-items-center mb-2"<"col-sm-6"l><"col-sm-6"f>><"t"><"row mt-2"<"col-sm-5"i><"col-sm-7"p>>'
      });
    });
  }
  if ($('.select2').length) {
    $('.select2').select2({ theme: 'bootstrap4', width: '100%' });
  }
  setTimeout(function() { $('.alert').fadeOut('slow'); }, 5000);
});

function konfirmasiHapus(url, nama) {
  Swal.fire({
    title: 'Hapus Data?',
    html: 'Data <strong>"' + nama + '"</strong> akan dihapus permanen.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Hapus!',
    cancelButtonText: 'Batal'
  }).then(function(r) {
    if (r.isConfirmed) window.location.href = url;
  });
}
</script>
<?php if (isset($extra_js)) echo $extra_js; ?>
</body>
</html>
<?php ob_end_flush(); ?>
