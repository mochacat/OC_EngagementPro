# OpenCart_EngagementPro
An <a href="http://opencart.com/" target="_blank">OpenCart</a> extension that tracks and reports data on customer engagement. 

<h3>About</h3>
<h4>This extension has two major features:</h4>
a) <strong>Search</strong>: Generates report on specific search queries made by customers in the store front.
<br>
b) <strong>Repeat Customers</strong>: Generates report on customers who have made repeat purchases.

<h3>Compatibility</h3>
OpenCart version 2.0 to version 2.0.2.0

<h3>Install</h3>
1) Upload the following files to your OpenCart store root directory:

<ul>admin/controller/report/engagement_pro.php
admin/model/report/engagment_pro.tpl
admin/view/template/report/engagment_pro.tpl
admin/language/english/report/engagment_pro.php
catalog/controller/account/engagment_pro.php
catalog/model/account/engagment_pro.php</ul>

2) Upload epro_install.ocmod.xml to the OpenCart extension installer in the admin or modify the following files:

<h5>Add Engagement PRO search query script</h5>

<ul>catalog/controller/common/header.php</ul>

<ul>Add  <code>$this->document->addScript('catalog/view/javascript/engagement_search.js');</code> before <code>$data['base'] = $server;</code></ul>

<h5>Add Engagement PRO link to admin menu</h5>

<ul>admin/view/template/common/menu.tpl</ul>

<ul>Add  <code>&#x3C;li&#x3E;&#x3C;a href=&#x22;&#x3C;?php echo str_replace(&#x27;report/customer_credit&#x27;, &#x27;report/engagement_pro&#x27;, $report_customer_credit); ?&#x3E;&#x22;&#x3E;Engagement PRO&#x3C;/a&#x3E;&#x3C;/li&#x3E;</code> after <code>&#x3C;li&#x3E;&#x3C;a href=&#x22;&#x3C;?php echo $report_customer_credit; ?&#x3E;&#x22;&#x3E;&#x3C;?php echo $text_report_customer_credit; ?&#x3E;&#x3C;/a&#x3E;&#x3C;/li&#x3E;</code></ul>

<h5>Enable permissions</h5>

<ul>Under User Groups, check "report/engagementpro" in Access Permission and Modify Permission</ul>

<h3>Note</h3>
This extension may not work with a modified OpenCart store or in conjunction with other 3rd party extensions. 

<h3>TODO</h3>
<ul>Add cart abandonment analytics</ul>
<ul>Export data to CSV</ul>
