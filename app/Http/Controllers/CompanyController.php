<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use App\Company;
use App\Director;
use App\CompanyDirector;

class CompanyController extends Controller
{

	public function index()
	{
		$companies = Company::select('id', 'cin', 'name', 'class_company', 'status')->paginate(10);
		return view('index')->with(compact('companies'));
	}

	public function add()
	{
		$validator = request()->validate([
			'url' => 'required|url'
		]);
		$url = request()->url; 

    	// $url = "http://www.mycorporateinfo.com/industry/section/F";
    	// $url = "http://www.mycorporateinfo.com/business/protex-foods-private-limited";
    	// $url = "http://www.mycorporateinfo.com/business/tata-coffee-limited";
    	// $url = "http://www.mycorporateinfo.com/business/mandovi-pellets-limited";

    	$company = Company::where('url', $url)->first();
    	if($company)
    	{
    		return redirect()->back()->withErrors(['url' => "Company Details already exists in Database."]);
    	}
    	else
    	{
	    	$client = new Client();
	    	$crawler = $client->request('GET', $url);

	    	/* Validation for Check Company Detail Page */
	    	if($crawler->filter('div#companyinformation table.table tr td b')->count() == 0)
	    	{
	    		return redirect()->back()->withErrors(['url' => "Company Details not found on this URL."]);
	    	}
	    	else 
	    	{	
	    		$companyArray = array();

	    		/* To Fetch Company Corporate Identification Number Details */
				$companyInfoCIN = $crawler->filter('div#companyinformation table.table tr td b')->each(function ($node) {
					if($node->text() == "Corporate Identification Number")
	    				return $node->closest('tr')->filter('td')->last()->text();
				});
				$companyCIN = array_values(array_filter($companyInfoCIN));
				$companyArray['cin'] = empty($companyCIN) ? "" : $companyCIN[0];

				/* To Fetch Company Name Details */
				$companyInfoName = $crawler->filter('div#companyinformation table.table tr td b')->each(function ($node) {
					if($node->text() == "Company Name")
	    				return $node->closest('tr')->filter('td')->last()->text();
				});
				$companyName = array_values(array_filter($companyInfoName));
				$companyArray['name'] = empty($companyName) ? "" : $companyName[0];

				/* To Fetch Company Status Details */
				$companyInfoStatus = $crawler->filter('div#companyinformation table.table tr td b')->each(function ($node) {
					if($node->text() == "Company Status")
	    				return $node->closest('tr')->filter('td')->last()->text();
				});
				$companyStatus = array_values(array_filter($companyInfoStatus));
				$companyArray['status'] = empty($companyStatus) ? "" : $companyStatus[0];

				/* To Fetch Company Date of Incorporation Details */
				$companyInfoIncorporation = $crawler->filter('div#companyinformation table.table tr td b')->each(function ($node) {
					if($node->text() == "Age (Date of Incorporation)")
	    			{
	    				$str = $node->closest('tr')->filter('td')->last()->text();
	    				$start = strpos($str,'See other');
						$str = substr($str,0,$start);
						$str = str_replace("(", "", $str);
						$str = str_replace(")", "", $str);
						return $str;
	    			}
				});
				$companyIncorporation = array_values(array_filter($companyInfoIncorporation));
				$companyArray['date_incorporation'] = empty($companyIncorporation) ? "" : $companyIncorporation[0];

				/* To Fetch Company Registration Number Details */
				$companyInfoRegNo = $crawler->filter('div#companyinformation table.table tr td b')->each(function ($node) {
					if($node->text() == "Registration Number")
	    				return $node->closest('tr')->filter('td')->last()->text();
				});
				$companyRegNo = array_values(array_filter($companyInfoRegNo));
				$companyArray['reg_no'] = empty($companyRegNo) ? "" : $companyRegNo[0];

				/* To Fetch Company Category Details */
				$companyInfoCategory = $crawler->filter('div#companyinformation table.table tr td b')->each(function ($node) {
					if($node->text() == "Company Category")
					{
	    				$str = $node->closest('tr')->filter('td')->last()->text();
	    				$start = strpos($str,'See other');
						$str = substr($str,0,$start);
						return $str;
					}
				});
				$companyCategory = array_values(array_filter($companyInfoCategory));
				$companyArray['category'] = empty($companyCategory) ? "" : $companyCategory[0];

				/* To Fetch Company Subcategory Details */
				$companyInfoSubcategory = $crawler->filter('div#companyinformation table.table tr td b')->each(function ($node) {
					if($node->text() == "Company Subcategory")
					{
	    				$str = $node->closest('tr')->filter('td')->last()->text();
	    				$start = strpos($str,'See other');
						$str = substr($str,0,$start);
						return $str;
					}
				});
				$companySubcategory = array_values(array_filter($companyInfoSubcategory));
				$companyArray['subcategory'] = empty($companySubcategory) ? "" : $companySubcategory[0];

				/* To Fetch Company Class of Company Details */
				$companyInfoClass = $crawler->filter('div#companyinformation table.table tr td b')->each(function ($node) {
					if($node->text() == "Class of Company")
					{
	    				$str = $node->closest('tr')->filter('td')->last()->text();
	    				$start = strpos($str,'See other');
						$str = substr($str,0,$start);
						return $str;
					}
				});
				$companyClass = array_values(array_filter($companyInfoClass));
				$companyArray['class_company'] = empty($companyClass) ? "" : $companyClass[0];

				/* To Fetch Company ROC Code Details */
				$companyInfoROC = $crawler->filter('div#companyinformation table.table tr td b')->each(function ($node) {
					if($node->text() == "ROC Code")
					{
	    				$str = $node->closest('tr')->filter('td')->last()->text();
	    				$start = strpos($str,'See other');
						$str = substr($str,0,$start);
						return $str;
					}
				});
				$companyROC = array_values(array_filter($companyInfoROC));
				$companyArray['roc_code'] = empty($companyROC) ? "" : $companyROC[0];

				/* To Fetch Company Number of Members Details */
				$companyInfoNoMembers = $crawler->filter('div#companyinformation table.table tr td b')->each(function ($node) {
					if($node->text() == "Number of Members (Applicable only in case of company without Share Capital)")
	    				return $node->closest('tr')->filter('td')->last()->text();
				});
				$companyNoMembers = array_values(array_filter($companyInfoNoMembers));
				$companyArray['no_of_members'] = empty($companyNoMembers) ? "0" : $companyNoMembers[0];

				/* To Fetch Company Email Details */
				$companyInfoEmail = $crawler->filter('div#contactdetails table.table tr td b')->each(function ($node) {
					if($node->text() == "Email Address")
	    				return $node->closest('tr')->filter('td')->last()->text();
				});
				$companyEmail = array_values(array_filter($companyInfoEmail));
				$companyArray['email'] = empty($companyEmail) ? "" : $companyEmail[0];

				/* To Fetch Company Registered Office Details */
				$companyInfoAddress = $crawler->filter('div#contactdetails table.table tr td b')->each(function ($node) {
					if($node->text() == "Registered Office")
	    				return $node->closest('tr')->filter('td')->last()->text();
				});
				$companyAddress = array_values(array_filter($companyInfoAddress));
				$companyArray['reg_office'] = empty($companyAddress) ? "" : $companyAddress[0];

				/* To Fetch Company Whether listed or not Details */
				$companyInfoListed = $crawler->filter('div#listingandannualcomplaincedetails table.table tr td b')->each(function ($node) {
					if($node->text() == "Whether listed or not")
	    			{
	    				$str = $node->closest('tr')->filter('td')->last()->text();
	    				$start = strpos($str,'See other');
						$str = substr($str,0,$start);
						return $str;
	    			}
				});
				$companyListed = array_values(array_filter($companyInfoListed));
				$companyArray['whether_listed_not'] = empty($companyListed) ? "" : $companyListed[0];

				/* To Fetch Company Date of Last AGM Details */
				$companyInfoLastAGM = $crawler->filter('div#listingandannualcomplaincedetails table.table tr td b')->each(function ($node) {
					if($node->text() == "Date of Last AGM")
	    				return $node->closest('tr')->filter('td')->last()->text();
				});
				$companyLastAGM = array_values(array_filter($companyInfoLastAGM));
				$companyArray['date_last_agm'] = empty($companyLastAGM) ? "" : $companyLastAGM[0];

				/* To Fetch Company Date of Balance sheet Details */
				$companyInfoBalanceSheet = $crawler->filter('div#listingandannualcomplaincedetails table.table tr td b')->each(function ($node) {
					if($node->text() == "Date of Balance sheet")
	    				return $node->closest('tr')->filter('td')->last()->text();
				});
				$companyBalanceSheet = array_values(array_filter($companyInfoBalanceSheet));
				$companyArray['date_balance_sheet'] = empty($companyBalanceSheet) ? "" : $companyBalanceSheet[0];

				/* To Fetch Company State Details */
				$companyLocationState = $crawler->filter('div#otherinformation table.table tr td b')->each(function ($node) {
					if($node->text() == "State")
	    				return $node->closest('tr')->filter('td')->last()->text();
				});
				$companyState = array_values(array_filter($companyLocationState));
				$companyArray['state'] = empty($companyState) ? "" : $companyState[0];

				/* To Fetch Company District Details */
				$companyLocationDistrict = $crawler->filter('div#otherinformation table.table tr td b')->each(function ($node) {
					if($node->text() == "District")
	    				return $node->closest('tr')->filter('td')->last()->text();
				});
				$companyDistrict = array_values(array_filter($companyLocationDistrict));
				$companyArray['district'] = empty($companyDistrict) ? "" : $companyDistrict[0];

				/* To Fetch Company City Details */
				$companyLocationCity = $crawler->filter('div#otherinformation table.table tr td b')->each(function ($node) {
					if($node->text() == "City")
	    				return $node->closest('tr')->filter('td')->last()->text();
				});
				$companyCity = array_values(array_filter($companyLocationCity));
				$companyArray['city'] = empty($companyCity) ? "" : $companyCity[0];

				/* To Fetch Company PIN Details */
				$companyLocationPIN = $crawler->filter('div#otherinformation table.table tr td b')->each(function ($node) {
					if($node->text() == "PIN")
	    				return $node->closest('tr')->filter('td')->last()->text();
				});
				$companyPIN = array_values(array_filter($companyLocationPIN));
				$companyArray['pin'] = empty($companyPIN) ? "" : $companyPIN[0];

				/* To Fetch Company Section Details */
				$companyIndustrySection = $crawler->filter('div#industryclassification table.table tr td b')->each(function ($node) {
					if($node->text() == "Section")
					{
	    				$str = $node->closest('tr')->filter('td')->last()->text();
	    				$start = strpos($str,'See other');
						$str = substr($str,0,$start);
						return $str;
					}
				});
				$companySection = array_values(array_filter($companyIndustrySection));
				$companyArray['section'] = empty($companySection) ? "" : $companySection[0];

				/* To Fetch Company Division Details */
				$companyIndustryDivision = $crawler->filter('div#industryclassification table.table tr td b')->each(function ($node) {
					if($node->text() == "Division")
					{
	    				$str = $node->closest('tr')->filter('td')->last()->text();
	    				$start = strpos($str,'See other');
						$str = substr($str,0,$start);
						return $str;
					}
				});
				$companyDivision = array_values(array_filter($companyIndustryDivision));
				$companyArray['division'] = empty($companyDivision) ? "" : $companyDivision[0];

				/* To Fetch Company Main Group Details */
				$companyIndustryMainGroup = $crawler->filter('div#industryclassification table.table tr td b')->each(function ($node) {
					if($node->text() == "Main Group")
					{
	    				$str = $node->closest('tr')->filter('td')->last()->text();
	    				$start = strpos($str,'See other');
						$str = substr($str,0,$start);
						return $str;
					}
				});
				$companyMainGroup = array_values(array_filter($companyIndustryMainGroup));
				$companyArray['main_group'] = empty($companyMainGroup) ? "" : $companyMainGroup[0];

				/* To Fetch Company Main Class Details */
				$companyIndustryMainClass = $crawler->filter('div#industryclassification table.table tr td b')->each(function ($node) {
					if($node->text() == "Main Class")
					{
	    				return $node->closest('tr')->filter('td')->last()->text();
					}
				});
				$companyMainClass = array_values(array_filter($companyIndustryMainClass));
				$companyArray['main_class'] = empty($companyMainClass) ? "" : $companyMainClass[0];

				$companyArray['url'] = $url;

				/* Save the Company Details to Database */
				$company = Company::create($companyArray);

				/* To Fetch Company Directors Details */
				$directors = $crawler->filter('div#directors table.table tr')->each(function ($node) {
	    			$director = $node->filter('td')->each(function ($node2){
	    				return $node2->text();
	    			});
	    			return $director;
				});
				$directors = array_values(array_filter($directors));

				/* Save the Director Details to Database */
				if(count($directors))
				{
					foreach ($directors as $key => $directorItem) 
					{
						$directorArray = array(
											'din'				=> $directorItem[0],
											'name'				=> $directorItem[1],
											'designation'		=> $directorItem[2],
											'date_appointment'	=> $directorItem[3]
										);

						$director = Director::where("din", $directorArray['din'])->first();
						if(!$director)
							$director = Director::create($directorArray);

						$companyDirector = CompanyDirector::create([
																	'company_id' => $company->id,
																	'director_id' => $director->id]
																);
					} 
				}
				return redirect()->back()->with('status', 'Company added to Database.');
				// print_r($companyArray);
				// print_r($directors);
	    	}
	    }
    }
}
