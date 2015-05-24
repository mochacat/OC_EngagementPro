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
<script>
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
</script>
<?php echo $footer; ?>