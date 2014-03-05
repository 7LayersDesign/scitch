<!-- Start filter box -->
<div class="row hide" id="sni-filter" >
  <div class="col-md-12">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">
        Find and Filter
        <button type="button" class="btn btn-primary btn-xs pull-right" data-toggle="collapse" data-target="#sni-control-panel"><i class="glyphicon glyphicon-collapse-up"></i></button>
        </h3>
      </div>
      <div class="panel-body collapse in" id="sni-control-panel">
        <form class="form" id="sni-fnf" role="form">
          <div class="form-group">
            <label for="dd_sponsorship">Filter by sponsorship code:</label>
            <select name="dd_sponsorship" id="dd_sponsorship" class="form-control input-sm">
              <option value="">Select</option>
              <?php
              foreach ($sponsorships as $value) {
                echo "<option value='" . $value . "' >" . $value . "</option>" ;
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="dd_sponsorship">Filter by sponsorship code:</label>
            <select name="dd_sponsorship" id="dd_sponsorship" class="form-control input-sm">
              <option value="">Select</option>
              <?php
              foreach ($sponsorships as $value) {
                echo "<option value='" . $value . "' >" . $value . "</option>" ;
              }
              ?>
            </select>
          </div>
          <button type="submit" class="btn btn-default">Update <i class="glyphicon glyphicon-refresh"></i></button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- END filter box -->


<!-- Start Table -->
<div class="row">
  <div class="col-md-12">
    <table id="sni-sortable" class="table table-striped table-condensed table-bordered tablesorter-blue">
      <thead>
        <tr>
          <th width="100">site</th>
          <th>url</th>
          <th>sponsorship</th>
          <th>adkey1</th>
          <th>Last Update</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $data = $db->getRecords(50, 200, 'ASC', 'modified_at');
        for ($i=0; $i < count($data); $i++) {
          echo "<tr>";
          echo "<td>" . $data[$i]['site'] . "</td>";
          echo "<td><a href='" . $data[$i]['url'] . "' title='" . $data[$i]['url'] . "' target='_blank'>" . substr($data[$i]['url'], 0, 70) . "...</a></td>";
          echo "<td width='100'>" . $data[$i]['sponsorship'] . "</td>";
          echo "<td>" . $data[$i]['adkey1'] . "</td>";
          echo "<td>" . $data[$i]['timestamp_for_humans'] . "</td>";
          echo "<td><a href='/scitch/detail.php?uid=" . $data[$i]['uid'] . "' >Detail</a></td>";

          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
<!-- End Table -->