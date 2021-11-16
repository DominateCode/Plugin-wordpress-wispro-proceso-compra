<div class="wrap">
<!-- Pills navs -->
<ul class="nav nav-pills justify-content-center mt-5 text-center" id="ex1" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="ex1-tab-1"  data-mdb-toggle="pill" href="#ex1-pills-1" role="tab"
    aria-controls="ex1-pills-1"  aria-selected="true">1 <br> Elige tu plan</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="ex1-tab-2" data-mdb-toggle="pill" href="#ex1-pills-2"role="tab"
       aria-controls="ex1-pills-2" aria-selected="false">2 <br> Datos de compra</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="ex1-tab-3" data-mdb-toggle="pill" href="#ex1-pills-3"
      role="tab"  aria-controls="ex1-pills-3" aria-selected="false" >3 <br> Finalizar compra</a>
  </li>
</ul>
<!-- Pills navs -->

<!-- Pills content -->
<div class="tab-content" id="ex1-content">
  <div class="tab-pane fade show active" id="ex1-pills-1" role="tabpanel" aria-labelledby="ex1-tab-1">
    Tab 1 content
  </div>
  <div class="tab-pane fade" id="ex1-pills-2" role="tabpanel" aria-labelledby="ex1-tab-2">
    Tab 2 content
  </div>
  <div class="tab-pane fade" id="ex1-pills-3" role="tabpanel" aria-labelledby="ex1-tab-3">
    Tab 3 content
  </div>
</div>
<!-- Pills content -->
<script>
jQuery(document).ready(function($) {
    $('#ex1-tab-1').click(function () {
      $('#ex1-pills-1').addClass('active show');
      $('#ex1-pills-2').removeClass('active show');
      $('#ex1-pills-3').removeClass('active show');
    });
    $('#ex1-tab-2').click(function () {
      $('#ex1-pills-2').addClass('active show');
      $('#ex1-pills-1').removeClass('active show');
      $('#ex1-pills-3').removeClass('active show');
    });
    $('#ex1-tab-3').click(function () {
      $('#ex1-pills-3').addClass('active show');
      $('#ex1-pills-1').removeClass('active show');
      $('#ex1-pills-2').removeClass('active show');
    });
  });
</script>

</div>
