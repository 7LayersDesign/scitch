<div class="row">
  <div class="col-md-12">
    <p><a href="javascript:window.history.back();" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-arrow-left"></i> Return to list view</a></p>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-info">
      <div class="panel-heading"><h3 class="panel-title">Page Details <small class="pull-right">UID: <?= $uid ?></small></h3></div>
<!--       <div class="panel-body">
        <p class="text-info">The data below is current as of the last updated date. It is possible the values have changed since this page was checked. </p>
      </div> -->
      <table class="table table-striped">
        <? if ($detail['url']) { ?>
          <tr><td><strong>URL:</strong></td>
          <td><a href="<?= $detail['url'] ?>" target="_blank"><?= $detail['url'] ?> <i class="glyphicon glyphicon-new-window"></i></a></td></tr>
        <? } ?>
        <? if ($detail['sponsorship']) { ?>
          <tr><td><strong>Sponsorship Code:</strong></td> <td><?= $detail['sponsorship'] ?></td></tr>
        <? } ?>
        <? if ($detail['referral']) { ?>
          <tr><td><strong>Referral URL:</strong></td> <td><?= $detail['referral'] ?></td></tr>
        <? } ?>
        <? if ($detail['site']) { ?>
          <tr><td><strong>Site:</strong></td> <td><?= $detail['site'] ?></td></tr>
        <? } ?>
        <? if ($detail['adkey1']) { ?>
          <tr><td><strong>AdKey1:</strong></td> <td><?= $detail['adkey1'] ?></td></tr>
        <? } ?>
        <? if ($detail['adkey2']) { ?>
          <tr><td><strong>AdKey2:</strong></td> <td><?= $detail['adkey2'] ?></td></tr>
        <? } ?>
        <? if ($detail['category']) { ?>
          <tr><td><strong>Category:</strong></td> <td><?= $detail['category'] ?></td></tr>
        <? } ?>
        <? if ($detail['unique_id']) { ?>
          <tr><td><strong>Unique ID:</strong></td> <td><?= $detail['unique_id'] ?></td></tr>
        <? } ?>
        <? if ($detail['page_type']) { ?>
          <tr><td><strong>Page Type:</strong></td> <td><?= $detail['page_type'] ?></td></tr>
        <? } ?>
        <? if ($detail['detail_id']) { ?>
          <tr><td><strong>Detail ID:</strong></td> <td><?= $detail['detail_id'] ?></td></tr>
        <? } ?>
        <? if ($detail['timestamp_for_humans']) { ?>
          <tr><td><strong>Last Updated:</strong></td> <td><?= $detail['timestamp_for_humans'] ?></td></tr>
        <? } ?>
      </table>
      </div>
    </div>
  </div>