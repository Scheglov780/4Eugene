<?php
/**
 * preview.php
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 11/5/12
 * Time: 1:11 PM
 */
?>
<!-- modal-gallery is the modal dialog used for the image gallery -->
<div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd" tabindex="-1" role="dialog">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3 class="modal-title"></h3>
  </div>
  <div class="modal-body">
    <div class="modal-image"></div>
  </div>
  <div class="modal-footer">
    <a class="btn modal-download" target="_blank">
      <i class="fa fa-download"></i>
      <!--<span>Download</span>-->
    </a>
    <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
      <i class="fa fa-play icon-white"></i>
      <!--<span>Slideshow</span>-->
    </a>
    <a class="btn btn-info modal-prev">
      <i class="fa fa-arrow-left icon-white"></i>
      <!--<span>Previous</span>-->
    </a>
    <a class="btn btn-primary modal-next">
      <!--<span>Next</span>-->
      <i class="fa fa-arrow-right icon-white"></i>
    </a>
  </div>
</div>