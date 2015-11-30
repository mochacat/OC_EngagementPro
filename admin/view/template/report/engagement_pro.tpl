<?php echo $header;?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-bar-chart"></i><?php echo $pane_title; ?></h3>
      </div>
      <div class="panel-body">
        <div id="nav-tabs" class="col-md-3">
            <div class="active form-group">
                <a href="#search">
                    <span class="btn btn-success" style="width:130px;"><?php echo $tab_search; ?></span>
                </a>
            </div>
            <div class="form-group">
                 <a href="#repeat">
                     <span class="btn btn-primary" style="width:130px;"><?php echo $tab_repeat; ?></span>
                 </a>
            </div>
        </div>
        <div id="tabs-content" class="col-md-7">
            <div class="tab-pane" id="search">
                <div class="well">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label" for="input-date-start"><?php echo $entry_date_start; ?></label>
                        <div class="input-group date">
                          <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" id="input-date-start" class="form-control" />
                          <span class="input-group-btn">
                          <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                          </span></div>
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="input-date-end"><?php echo $entry_date_end; ?></label>
                        <div class="input-group date">
                          <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" id="input-date-end" class="form-control" />
                          <span class="input-group-btn">
                          <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                          </span></div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label" for="input-customer"><?php echo $entry_customer; ?></label>
                        <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" id="input-customer" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="input-ip"><?php echo $entry_ip; ?></label>
                        <input type="text" name="filter_ip" value="<?php echo $filter_ip; ?>" id="input-ip" class="form-control" />
                      </div>
                      <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                              <td class="text-left"><?php echo $search_query; ?></td>
                              <td class="text-left"><?php echo $search_customer; ?></td>
                              <td class="text-left"><?php echo $search_ip; ?></td>
                              <td class="text-left"><?php echo $search_date; ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($totals['search']) { ?>
                            <?php foreach ($results['search'] as $search) { ?>
                            <tr>
                              <td class="text-left"><?php echo $search['data']; ?></td>
                              <td class="text-left">
                              <?php if (!empty($search['customer']['url'])) { ?>
                                <a href="<?php echo $search['customer']['url']; ?>">
                                    <?php echo $search['customer']['name']; ?>
                                </a>
                              <?php } else { echo $search['customer']['name'];}?>
                              </td>
                              <td class="text-left"><?php echo $search['ip']; ?></td>
                              <td class="text-left"><?php echo $search['date']; ?></td>
                            </tr>
                            <?php } ?>
                            <?php } else { ?>
                            <tr>
                              <td class="text-center" colspan="4">No Results</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-left"><?php echo $pagination['search']; ?></div>
                    <div class="col-sm-6 text-right"><?php echo $pages['search']; ?></div>
                </div>
            </div>
            <div class="tab-pane" id="repeat" style="display:none;">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                              <td class="text-left"><?php echo $repeat_customer; ?></td>
                              <td class="text-left"><?php echo $repeat_count; ?></td>
                              <td class="text-left"><?php echo $repeat_products; ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($totals['repeat']) { ?>
                            <?php foreach ($results['repeat'] as $repeat) { ?>
                            <tr>
                              <td class="text-left">
                              <?php if (!empty($repeat['customer']['url'])) { ?>
                                <a href="<?php echo $repeat['customer']['url']; ?>">
                                    <?php echo $repeat['customer']['name']; ?>
                                </a>
                              <?php } else { echo $repeat['customer']['name'];}?>
                              </td>
                              <td class="text-left"><?php echo $repeat['count']; ?></td>
                              <td class="text-left">
                                <?php $i = count($repeat['products']);?>
                                <?php foreach ($repeat['products'] as $product) { ?>
                                <a href="<?php echo $product['url']; ?>">
                                    <?php echo $product['name']; ?>
                                </a>
                                    <?php $i-- ?>
                                    <?php if ($i != 0) { ?>
                                    ,
                                    <?php }?>
                                <?php } ?>
                              </td>
                            </tr>
                            <?php } ?>
                            <?php } else { ?>
                            <tr>
                              <td class="text-center" colspan="4">No Results</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    var tabs = $('#nav-tabs div');
    tabs.on('click', function(e){
        e.preventDefault();
        
        //activate current tab
        tabs.removeClass('active');
        tabs.find("span").removeClass('btn-success');
        tabs.find("span").addClass('btn-primary');
        $(this).find("span").removeClass('btn-primary');
        $(this).find("span").addClass('active btn-success');
        
        //activate current content
        var current = $(this).find("a").attr("href");
        $(".tab-pane").not(current).css("display", "none");
        $(current).fadeIn();
    });
    
    $('#button-filter').on('click', function() {
      url = 'index.php?route=report/engagement_pro&token=<?php echo $token; ?>';
      
      var filter_customer = $('input[name=\'filter_customer\']').val();
      
      if (filter_customer) {
          url += '&filter_customer=' + encodeURIComponent(filter_customer);
      }
      var filter_ip = $('input[name=\'filter_ip\']').val();
      
      if (filter_ip) {
          url += '&filter_ip=' + encodeURIComponent(filter_ip);
      }
      
      var filter_date_start = $('input[name=\'filter_date_start\']').val();
      
      if (filter_date_start) {
          url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
      }
  
      var filter_date_end = $('input[name=\'filter_date_end\']').val();
      
      if (filter_date_end) {
          url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
      }
  
      location = url;
    });
</script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//-->
</script>
<?php echo $footer; ?>