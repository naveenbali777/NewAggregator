<?php
/*
  PHP code to export MySQL data to CSV 
*/ 
include("./controller/function.php");
$fun = new FetchData();
$conn = $fun->conOpen();
// echo "SELECT channel as Ticker, image_link as ImageUrl FROM company_images where status = 'yes' order by Ticker asc";exit;
$query = sprintf("SELECT channel as Ticker, image_link as ImageUrl FROM company_images where status = 'yes' order by Ticker asc");
$result = $conn->query($query);

/*
 * send response headers to the browser
 * following headers instruct the browser to treat the data as a csv file called export.csv
 */

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=company_images.csv');

/*
 * output header row (if atleast one row exists)
 */

$row = mysqli_fetch_assoc($result);
if ($row) {
    echocsv(array_keys($row));
}

/*
 * output data rows (if atleast one row exists)
 */

while ($row) {
    echocsv($row);
    $row = mysqli_fetch_assoc($result);
}

/*
 * echo the input array as csv data maintaining consistency with most CSV implementations
 * - uses double-quotes as enclosure when necessary
 * - uses double double-quotes to escape double-quotes 
 * - uses CRLF as a line separator
 */

function echocsv($fields)
{
    $separator = '';
    foreach ($fields as $field) {
        if (preg_match('/\\r|\\n|,|"/', $field)) {
            $field = '"' . str_replace('"', '""', $field) . '"';
        }
        echo $separator . $field;
        $separator = ',';
    }
    echo "\r\n";
}
?>