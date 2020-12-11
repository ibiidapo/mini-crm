<div class="alert alert-{{ $type }} alert-dismissible fade in" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>{{ $title }}</strong>
  {{ $slot }}
</div>

<script>
  $('.alert').alert();
</script>