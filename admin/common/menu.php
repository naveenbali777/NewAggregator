<?php
$linkName = $fun->get_url_name($_SERVER['REQUEST_URI']);
?>
<div class="col-sm-3 sidenav">
  <h4>Admin</h4>
  <ul class="nav nav-pills nav-stacked">
    <li <?php if($linkName == "dashboard"){ echo 'class="active"'; } ?>><a href="./dashboard.php">Categories</a></li>
    <li <?php if($linkName == "website"){ echo 'class="active"'; } ?>><a href="./website.php">Websites</a></li>
    <li <?php if($linkName == "news"){ echo 'class="active"'; } ?>><a href="./news.php">All News</a></li>
    <li <?php if($linkName == "approve_news"){ echo 'class="active"'; } ?>><a href="./approve_news.php">Approved News</a></li>
    <li <?php if($linkName == "nonasnkeywords"){ echo 'class="active"'; } ?>><a href="./nonasnkeywords.php">Non Approved Keywords News</a></li>
    <li <?php if($linkName == "asnkeywords"){ echo 'class="active"'; } ?>><a href="./asnkeywords.php">Approved Keywords News</a></li>
    <li <?php if($linkName == "influencers"){ echo 'class="active"'; } ?>><a href="./influencers.php">Influencers</a></li>
    <li <?php if($linkName == "hotnews"){ echo 'class="active"'; } ?>><a href="./hotnews.php">Hot News</a></li>
    <li <?php if($linkName == "company"){ echo 'class="active"'; } ?>><a href="./company.php">Ceo.ca</a></li>
    <li <?php if($linkName == "hot_comment"){ echo 'class="active"'; } ?>><a href="./hot_comment.php">Ceo Hot Comments</a></li>
    <li <?php if($linkName == "suggested_source"){ echo 'class="active"'; } ?>><a href="./suggested_source.php">Suggested Source</a></li>
    <li <?php if($linkName == "company_news"){ echo 'class="active"'; } ?>><a href="./company_news.php">Company News</a></li>
    <li <?php if($linkName == "taged_company"){ echo 'class="active"'; } ?>><a href="./taged_company.php">Tagged Websites</a></li>
    <li <?php if($linkName == "exclusive_news"){ echo 'class="active"'; } ?>><a href="./exclusive_news.php">Exclusive News</a></li>
    <li <?php if($linkName == "exclusive_company"){ echo 'class="active"'; } ?>><a href="./exclusive_company.php">Exclusive Company</a></li>
    <li <?php if($linkName == "home_page_news"){ echo 'class="active"'; } ?>><a href="./home_page_news.php">Home Page News</a></li>
    <li <?php if($linkName == "custom_news"){ echo 'class="active"'; } ?>><a href="./custom_news.php">Custom News</a></li>
    <li <?php if($linkName == "get_listed"){ echo 'class="active"'; } ?>><a href="./get_listed.php">Get Listed</a></li>
    <li <?php if($linkName == "company_contact"){ echo 'class="active"'; } ?>><a href="./company_contact.php">Company Contact</a></li>
    <li <?php if($linkName == "claim_listing"){ echo 'class="active"'; } ?>><a href="./claim_listing.php">Claim Listing</a></li>
    <li <?php if($linkName == "meta_tags"){ echo 'class="active"'; } ?>><a href="./meta_tags.php">Meta Tags</a></li>
    <li <?php if($linkName == "static_page"){ echo 'class="active"'; } ?>><a href="./static_page.php">Static Pages</a></li>
    <li <?php if($linkName == "company_images"){ echo 'class="active"'; } ?>><a href="./company_images.php">Company Images</a></li>
    <li <?php if($linkName == "mark_company_images"){ echo 'class="active"'; } ?>><a href="./mark_company_images.php">Selected Company Images</a></li>
    <li <?php if($linkName == "enhanced_company"){ echo 'class="active"'; } ?>><a href="./enhanced_company.php">Premium Company</a></li>
    <li <?php if($linkName == "upload_excel"){ echo 'class="active"'; } ?>><a href="./upload_excel.php">Upload Excel</a></li>
    <li <?php if($linkName == "tags"){ echo 'class="active"'; } ?>><a href="./tags.php">Tags</a></li>
    <li <?php if($linkName == "news_stat" || $linkName == "web_news" || $linkName == "auth_news" || $linkName == "inf_news"){ echo 'class="active"'; } ?>><a href="./news_stat.php">News Stat</a></li>
    <li <?php if($linkName == "company_list"){ echo 'class="active"'; } ?>><a href="./company_list.php">Company List</a></li>
  </ul>
</div>