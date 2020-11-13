<?php 

namespace App\Http;

use App\Models\CompanyDetails;

class Company {

   public static function getCompanyName()
   {
   	$company = CompanyDetails::first();
   	return $company->name;
   }

   public static function getEmail()
   {
   	$company = CompanyDetails::first();
   	return $company->email;
   }
}