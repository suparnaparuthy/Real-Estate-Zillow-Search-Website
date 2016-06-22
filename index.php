

<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');


setlocale(LC_MONETARY, 'en_US');
date_default_timezone_set('America/Los_Angeles');

$street = $_GET["streetInput"];

$street = str_replace(' ', '+', $street);

$city = $_GET["cityInput"];

$city = str_replace(' ', '+', $city);



$url = "http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=X1-ZWz1dy3gv3lszv_13bwv&address=";
$url = $url.$street."&citystatezip=".$city."%2C+".$_GET["stateInput"]."&rentzestimate=true";


$xml = simplexml_load_file($url);




if(!isset($xml->response->results->result->links->homedetails) || empty($xml->response->results->result->links->homedetails))
{ 
 
$zpid = "";
}

else
{
 
$zpid = $xml->response->results->result->zpid;

}


$chart1url = "http://www.zillow.com/webservice/GetChart.htm?zws-id=X1-ZWz1dy3gv3lszv_13bwv&unit-type=percent&zpid=".$zpid."&width=600&height=300&chartDuration=1year";


$chart1 = simplexml_load_file($chart1url);



$chart5url = "http://www.zillow.com/webservice/GetChart.htm?zws-id=X1-ZWz1dy3gv3lszv_13bwv&unit-type=percent&zpid=".$zpid."&width=600&height=300&chartDuration=5years";


$chart5 = simplexml_load_file($chart5url);



$chart10url = "http://www.zillow.com/webservice/GetChart.htm?zws-id=X1-ZWz1dy3gv3lszv_13bwv&unit-type=percent&zpid=".$zpid."&width=600&height=300&chartDuration=10years";

$chart10 = simplexml_load_file($chart10url);



$result = array();

$result['retcode'] = (string)$xml->message->code;
$result['imgn'] = "http://www-scf.usc.edu/~csci571/2014Spring/hw6/down_r.gif";
$result['imgp'] = "http://www-scf.usc.edu/~csci571/2014Spring/hw6/up_g.gif";



if(!isset($xml->response->results->result->address->street) || empty($xml->response->results->result->address->street))
{ 
 
$result['street'] = "";
}

else
{

$street = $xml->response->results->result->address->street;

if((preg_match($pattern,$street)) || ($street == ""))
{
  
$result['street'] = "";
}

else
{
 
$result['street'] = (string)$street;
}

}




if(!isset($xml->response->results->result->address->city) || empty($xml->response->results->result->address->city))
{ 
 
$result['city'] = "";
}

else
{

$city = $xml->response->results->result->address->city;

if((preg_match($pattern,$city)) || ($city == ""))
{
  
$result['city'] = "";
}

else
{
 
$result['city'] = (string)$city;
}

}



if(!isset($xml->response->results->result->address->state) || empty($xml->response->results->result->address->state))
{ 
 
$result['state'] = "";
}

else
{

$state = $xml->response->results->result->address->state;

if((preg_match($pattern,$state)) || ($state == ""))
{
  
$result['state'] = "";
}

else
{
 
$result['state'] = (string)$state;
}

}



if(!isset($xml->response->results->result->address->zipcode) || empty($xml->response->results->result->address->zipcode))
{ 
 
$result['zipcode'] = "";
}

else
{

$zipcode = $xml->response->results->result->address->zipcode;

if((preg_match($pattern,$zipcode)) || ($zipcode == ""))
{
  
$result['zipcode'] = "";
}

else
{
 
$result['zipcode'] = (string)$zipcode;
}

}


if(!isset($xml->response->results->result->links->homedetails) || empty($xml->response->results->result->links->homedetails))
{ 
 
$result['homedetails'] = "";
}

else
{

$homedetails = $xml->response->results->result->links->homedetails;

if((preg_match($pattern,$homedetails)) || ($homedetails == ""))
{
  
$result['homedetails'] = "";
}

else
{
 
$result['homedetails'] = (string)$homedetails;
}

}



if(!isset($xml->response->results->result->useCode) || empty($xml->response->results->result->useCode))
{ 
 
$result['type'] = "";
}

else
{
$type = $xml->response->results->result->useCode;

if((preg_match($pattern,$type)) || ($type == ""))
{
  
$result['type'] = "";
}

else
{
 
$result['type'] = (string)$type;
}

}


if(!isset($xml->response->results->result->lastSoldPrice) || empty($xml->response->results->result->lastSoldPrice))
{
$result['price'] = "";
}
else
{
$price = $xml->response->results->result->lastSoldPrice;
if((preg_match($pattern,$price)) || ($price == ""))
{
$result['price'] = "";
}

else
{
 $price = money_format('%.2n',(int)$price);
$result['price'] = (string)$price;
}
}


if(!isset($xml->response->results->result->yearBuilt) || empty($xml->response->results->result->yearBuilt))
{
$result['year'] = "";
}
else
{
$year = $xml->response->results->result->yearBuilt;

 if((preg_match($pattern,$year)) || ($year == ""))
 {
$result['year'] = "";
 }

 else
 {
$result['year'] = (string)$year;
 }

}



if(!isset($xml->response->results->result->lastSoldDate) || empty($xml->response->results->result->lastSoldDate))
{

$result['soldDate'] = "";
}
else
{
 $soldDate = $xml->response->results->result->lastSoldDate;

if((preg_match($pattern,$soldDate)) || ($soldDate == ""))
{

$result['soldDate'] = "";
}

else
{

 $date2 = new DateTime($soldDate);

 
$result['soldDate'] = (string)$date2->format('d-M-Y');
}

}



if(!isset($xml->response->results->result->lotSizeSqFt) || empty($xml->response->results->result->lotSizeSqFt))
{

$result['lot'] = "";
}
else
{
 $lot = $xml->response->results->result->lotSizeSqFt;

if((preg_match($pattern,$lot)) || ($lot == ""))
{

$result['lot'] = "";
}

else
{
 $lot = number_format((int)$lot);

$result['lot'] = (string)$lot;
}
}



if(!isset($xml->response->results->result->zestimate->{'last-updated'}) || empty($xml->response->results->result->zestimate->{'last-updated'}))
{
 $result['dat1'] = "";
}

else
{
 $dat1 = $xml->response->results->result->zestimate->{'last-updated'};

 $date = new DateTime($dat1);

 $result['dat1'] = (string)$date->format('d-M-Y');
}


if(!isset($xml->response->results->result->zestimate->amount) || empty($xml->response->results->result->zestimate->amount))
{
 

$result['amt'] = "";
}

else
{
 $amt = $xml->response->results->result->zestimate->amount;

if((preg_match($pattern,$amt)) || ($amt == ""))
{

$result['amt'] = "";
}

else
{
 $amt = money_format('%.2n',(int)$amt);

$result['amt'] = (string)$amt;

}
}


if(!isset($xml->response->results->result->finishedSqFt) || empty($xml->response->results->result->finishedSqFt))
{ 
$result['finArea'] = "";
}

else
{ 
 $finArea = $xml->response->results->result->finishedSqFt;

if((preg_match($pattern,$finArea)) || ($finArea == ""))
{
$result['finArea'] = "";
}

else
{
 $finArea = number_format((int)$finArea);
$result['finArea'] = (string)$finArea;

}
}


if(!isset($xml->response->results->result->zestimate->valueChange)|| empty($xml->response->results->result->zestimate->valueChange))
{

$result['val'] = "";
}

else
{
$val = $xml->response->results->result->zestimate->valueChange;

if((preg_match($pattern,$val)) || ($val == ""))
{

$result['val'] = "";
}

else
{
 if((int)$val <  0)
 {
  $val = str_replace('-', '', $val);
  $val = money_format('%.2n',(int)$val);

  $result['val'] = (string)$val;
  $neg = 1;
  $result['negzestimg'] = (string)$neg;
 }
 else
  {
   $val = money_format('%.2n',(int)$val);
  $result['val'] = (string)$val;
  $neg = 0;
  $result['negzestimg'] = (string)$neg;
  }
}
}


if(!isset($xml->response->results->result->bathrooms) || empty($xml->response->results->result->bathrooms))
{
$result['bath'] = "";
}
 
else
{
$bath = $xml->response->results->result->bathrooms;

if((preg_match($pattern,$bath)) || ($bath == ""))
{
$result['bath'] = "";
}

else
{
$result['bath'] = (string)$bath;
}
}


if(!isset($xml->response->results->result->zestimate->valuationRange->low) || empty($xml->response->results->result->zestimate->valuationRange->low))
{
$result['low1'] = "";
$result['high1'] = "";
}

else
{

$low1 = $xml->response->results->result->zestimate->valuationRange->low;
$high1 = $xml->response->results->result->zestimate->valuationRange->high;

if((preg_match($pattern,$low1)) || ($low1 == "") || (preg_match($pattern,$high1)) || ($high1 == ""))
{
$result['low1'] = "";
$result['high1'] = "";
}

else
{
 $low1 = money_format('%.2n',(int)$low1);
 $high1 = money_format('%.2n',(int)$high1);
$result['low1'] = (string)$low1;
$result['high1'] = (string)$high1;
}
}


if(!isset($xml->response->results->result->bedrooms) || empty($xml->response->results->result->bedrooms))
{
$result['bed'] = "";
}

else
{
 
$bed = $xml->response->results->result->bedrooms;

if((preg_match($pattern,$bed)) || ($bed == ""))
{
$result['bed'] = "";
}

else
{
$result['bed'] = (string)$bed;
}
}


if(!isset($xml->response->results->result->rentzestimate->{'last-updated'}) || empty($xml->response->results->result->rentzestimate->{'last-updated'}))
{

$result['dat2'] = "";
}

else
{
$dat2 = $xml->response->results->result->rentzestimate->{'last-updated'};

$date3 = new DateTime($dat2);


$result['dat2'] = (string)$date3->format('d-M-Y');
}
 


if(!isset($xml->response->results->result->rentzestimate->amount) || empty($xml->response->results->result->rentzestimate->amount))
{

$result['rentamt'] = "";
}

else
{
 
$rentamt = $xml->response->results->result->rentzestimate->amount;

if((preg_match($pattern,$rentamt)) || ($rentamt == ""))
{

$result['rentamt'] = "";
}

else
{
 $rentamt = money_format('%.2n',(int)$rentamt);

$result['rentamt'] = (string)$rentamt;

}
}


if(!isset($xml->response->results->result->taxAssessmentYear) || empty($xml->response->results->result->taxAssessmentYear))
{

$result['assYear'] = "";
}

else
{
 
$assYear = $xml->response->results->result->taxAssessmentYear;

if((preg_match($pattern,$assYear)) || ($assYear == ""))
{

$result['assYear'] = "";
}

else
{


$result['assYear'] = (string)$assYear;
}
}


if(!isset($xml->response->results->result->rentzestimate->valueChange) || empty($xml->response->results->result->rentzestimate->valueChange))
{

$result['val2'] = "";
}

else
{
 
$val2 = $xml->response->results->result->rentzestimate->valueChange;

if((preg_match($pattern,$val2)) || ($val2 == ""))
{

$result['val2'] = "";
}

else
{
 
 if((int)$val2 <  0)
 {
  $val2 = str_replace('-', '', $val2); 
  $val2 = money_format('%.2n',(int)$val2);
  $negr = 1;
  $result['val2'] = (string)$val2;
  $result['negrentimg'] = (string)$negr;
 }

 else
  { 
   $val2 = money_format('%.2n',(int)$val2);
  $negr = 0;
  $result['val2'] = (string)$val2;
  $result['negrentimg'] = (string)$negr;
  }
}
}


if(!isset($xml->response->results->result->taxAssessment) || empty($xml->response->results->result->taxAssessment))
{
$result['ass'] = "";
}

else
{
 
$ass = $xml->response->results->result->taxAssessment;

if((preg_match($pattern,$ass)) || ($ass == ""))
{
$result['ass'] = "";
}

else
{
 $ass = money_format('%.2n',(int)$ass);
 $result['ass'] = (string)$ass;
}
}


if(!isset($xml->response->results->result->rentzestimate->valuationRange->low) || empty($xml->response->results->result->rentzestimate->valuationRange->low))
{
$result['low2'] = "";
$result['high2'] = "";
}

else
{
 
$low2 = $xml->response->results->result->rentzestimate->valuationRange->low;
$high2 = $xml->response->results->result->rentzestimate->valuationRange->high;

if((preg_match($pattern,$low2)) || ($low2 == "") || (preg_match($pattern,$high2)) || ($high2 == ""))
{
$result['low2'] = "";
$result['high2'] = "";

}

else
{
 $low2 = money_format('%.2n',(int)$low2);
 $high2 = money_format('%.2n',(int)$high2);
$result['low2'] = (string)$low2;
$result['high2'] = (string)$high2;
}
}


if(!isset($chart1->response->url) || empty($chart1->response->url))
{
 $result['chart1url'] = "";
}
else
{

$chart1url = $chart1->response->url;

if((preg_match($pattern,$chart1url)) || ($chart1url == ""))
{
 
 $result['chart1url'] = "";
}

else
{

  $result['chart1url'] = (string)$chart1url;
}
}



if(!isset($chart5->response->url) || empty($chart5->response->url))
{
 $result['chart5url'] = "";
}
else
{

$chart5url = $chart5->response->url;

if((preg_match($pattern,$chart5url)) || ($chart5url == ""))
{
 
 $result['chart5url'] = "";
}

else
{

  $result['chart5url'] = (string)$chart5url;
}
}


if(!isset($chart10->response->url) || empty($chart10->response->url))
{
 $result['chart10url'] = "";
}
else
{

$chart10url = $chart10->response->url;

if((preg_match($pattern,$chart10url)) || ($chart10url == ""))
{
 
 $result['chart10url'] = "";
}

else
{

  $result['chart10url'] = (string)$chart10url;
}
}


echo json_encode($result);



?>